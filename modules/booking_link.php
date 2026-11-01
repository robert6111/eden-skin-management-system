<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
require_permission('appointments.manage');
$bid = current_branch_id();
$branch = one('SELECT b.*,bs.name business_name FROM branches b JOIN businesses bs ON bs.id=b.business_id WHERE b.id=?', [$bid]);
$businessName = $branch['business_name'] ?? setting('business_name', 'Salon & Spa');
$branchName = $branch['name'] ?? 'Branch';
$ngrokPublicUrl = detect_ngrok_public_url();
$link = public_booking_link($bid);

function booking_link_message(string $customerName, string $businessName, string $branchName, string $link): string
{
  $greeting = trim($customerName) !== '' ? 'Hello ' . trim($customerName) . ',' : 'Hello,';
  return $greeting . ' you can book your salon/spa appointment with ' . $businessName . ' - ' . $branchName . ' using this link: ' . $link;
}

if (($_GET['action'] ?? '') === 'send_whatsapp') {
  $customerId = (int) ($_GET['customer_id'] ?? 0);
  $customer = null;
  if ($customerId > 0) {
    $customer = one('SELECT id,full_name,phone FROM customers WHERE id=? AND branch_id=?', [$customerId, $bid]);
  }
  $customerName = trim((string) ($_GET['customer_name'] ?? ($customer['full_name'] ?? '')));
  $phone = trim((string) ($_GET['phone'] ?? ($customer['phone'] ?? '')));
  if ($phone === '') {
    flash('error', 'Enter or select a customer WhatsApp number first.');
    redirect('modules/booking_link.php' . ($customerId ? '?customer_id=' . $customerId : ''));
  }
  $message = trim((string) ($_GET['message'] ?? ''));
  if ($message === '')
    $message = booking_link_message($customerName, $businessName, $branchName, $link);
  post_notification($customer['id'] ?? null, 'whatsapp', $phone, $message, $bid);
  audit('whatsapp_booking_link_opened', 'customer', $customer['id'] ?? null, ['phone' => $phone, 'booking_link' => $link]);
  header('Location: ' . whatsapp_url($phone, $message));
  exit;
}

$customers = all('SELECT id,full_name,phone FROM customers WHERE branch_id=? AND status="active" AND phone IS NOT NULL AND phone<>"" ORDER BY full_name LIMIT 500', [$bid]);
$prefillCustomer = null;
if (!empty($_GET['customer_id'])) {
  $prefillCustomer = one('SELECT id,full_name,phone FROM customers WHERE id=? AND branch_id=?', [(int) $_GET['customer_id'], $bid]);
}
$defaultMessage = booking_link_message('', $businessName, $branchName, $link);
$title = 'Send WhatsApp Booking Link';
$subtitle = 'Send the public booking page to customers using the  WhatsApp redirect method.';
include dirname(__DIR__) . '/includes/header.php';
?>
<section class="card" style="border-left:7px solid #16a34a;background:#f0fff4">
  <div class="badge green" style="margin-bottom:10px">WHATSAPP BOOKING SENDER ACTIVE</div>
  <h2>Send Booking Page to Customer WhatsApp</h2>
  <p class="muted"><strong></strong> the button opens the WhatsApp action first, logs the message, then redirects to
    WhatsApp
    with the customer number and booking message already filled.</p>
  <?php if ($ngrokPublicUrl !== ''): ?>
    <div class="alert success"><strong>Ngrok detected automatically:</strong> <?= e($ngrokPublicUrl) ?>. The WhatsApp
      message will use this online booking link automatically.</div>
  <?php else: ?>
    <div class="alert warning"><strong>Ngrok not detected yet.</strong> Start Ngrok with <code>ngrok http 80</code>, then
      refresh this page. The WhatsApp message will update automatically.</div>
  <?php endif; ?>
  <form method="get" target="_blank" id="whatsappSendForm">
    <input type="hidden" name="action" value="send_whatsapp">
    <div class="form-grid">
      <div class="form-group">
        <label>1. Select Existing Customer</label>
        <select id="customerPicker" name="customer_id">
          <option value="" data-name="" data-phone="">Choose customer or type number below</option>
          <?php foreach ($customers as $c): ?>
            <option value="<?= e($c['id']) ?>" data-name="<?= e($c['full_name']) ?>" data-phone="<?= e($c['phone']) ?>"
              <?= ($prefillCustomer && (int) $prefillCustomer['id'] === (int) $c['id']) ? 'selected' : '' ?>>
              <?= e($c['full_name']) ?>
              — <?= e($c['phone']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>2. Customer Name Optional</label>
        <input name="customer_name" id="customerName" placeholder="Example: Mary"
          value="<?= e($prefillCustomer['full_name'] ?? ($_GET['name'] ?? '')) ?>">
      </div>
      <div class="form-group">
        <label>3. Customer WhatsApp Number</label>
        <input name="phone" id="customerPhone" placeholder="Example: 0712 345 678 or 255712345678"
          value="<?= e($prefillCustomer['phone'] ?? ($_GET['phone'] ?? '')) ?>">
      </div>
      <div class="form-group full">
        <label>4. Message Preview</label>
        <textarea name="message" id="whatsappMessage" rows="4"></textarea>
      </div>
    </div>
    <div class="toolbar" style="margin-top:12px">
      <button class="btn success" type="submit">Open WhatsApp and Send Booking Link</button>
      <button class="btn"
        onclick="navigator.clipboard?navigator.clipboard.writeText(document.getElementById('bookingLink').value):document.getElementById('bookingLink').select();return false;"
        type="button">Copy Booking Link</button>
      <a class="btn light" target="_blank" href="<?= e($link) ?>">Open Booking Page</a>
      <a class="btn light" href="booking_link.php">Refresh Detected Link</a>
    </div>
  </form>
  <p class="muted">When Ngrok is running, the system automatically detects the current Ngrok HTTPS URL and puts it
    inside the WhatsApp message. You only select/type the customer number, then click the green button.</p>
</section>

<section class="card">
  <h2><?= e($businessName) ?> — <?= e($branchName) ?></h2>
  <p class="muted">This is the exact booking page link that will be sent to customers. Customers can choose service,
    date, time, and preferred staff. The booking will appear automatically in Appointments with source
    <strong>website</strong>.
  </p>
  <div class="form-group full">
    <label>Auto Customer Booking Link <?php if ($ngrokPublicUrl !== ''): ?>(Ngrok Public Link)<?php endif; ?></label>
    <input id="bookingLink" value="<?= e($link) ?>" readonly onclick="this.select()">
  </div>
  <div class="toolbar">
    <a class="btn success" target="_blank" href="https://wa.me/?text=<?= e(rawurlencode($defaultMessage)) ?>">Share Link
      by WhatsApp Without Customer Number</a>
    <a class="btn light" target="_blank" href="<?= e($link) ?>">Open Booking Page</a>
  </div>
  <p class="muted"><strong>Note:</strong> keep the Ngrok Command Prompt window open. When the free Ngrok URL changes,
    refresh this page and the WhatsApp button will use the new link automatically.</p>
</section>
<script>
  (function () {
    const picker = document.getElementById('customerPicker');
    const nameInput = document.getElementById('customerName');
    const phoneInput = document.getElementById('customerPhone');
    const msgInput = document.getElementById('whatsappMessage');
    const form = document.getElementById('whatsappSendForm');
    const bookingLink = <?= json_encode($link) ?>;
    const business = <?= json_encode($businessName . ' - ' . $branchName) ?>;
    function updateWhatsappMessage() {
      const name = (nameInput.value || '').trim();
      const greeting = name ? 'Hello ' + name + ',' : 'Hello,';
      msgInput.value = greeting + ' you can book your salon/spa appointment with ' + business + ' using this link: ' + bookingLink;
    }
    if (picker) {
      picker.addEventListener('change', function () {
        const opt = picker.options[picker.selectedIndex];
        const selectedPhone = opt.getAttribute('data-phone') || '';
        const selectedName = opt.getAttribute('data-name') || '';
        if (selectedName) nameInput.value = selectedName;
        if (selectedPhone) phoneInput.value = selectedPhone;
        updateWhatsappMessage();
      });
    }
    nameInput.addEventListener('input', updateWhatsappMessage);
    phoneInput.addEventListener('input', updateWhatsappMessage);
    form.addEventListener('submit', function (e) {
      if (!(phoneInput.value || '').trim()) {
        e.preventDefault();
        alert('Enter the customer WhatsApp number first.');
        phoneInput.focus();
      }
    });
    updateWhatsappMessage();
  })();
</script>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>