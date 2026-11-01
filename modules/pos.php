<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
require_permission('sales.create');
$bid = current_branch_id();
ensure_continuation_schema();
$prefillCustomer = '';
$prefillQueue = (int) ($_GET['queue_id'] ?? 0);
$prefillAppointment = (int) ($_GET['appointment_id'] ?? 0);
$prefillService = '';
$prefillStaff = '';
if ($prefillQueue) {
  $qr = one('SELECT * FROM queues WHERE id=? AND branch_id=?', [$prefillQueue, $bid]);
  if ($qr) {
    $prefillCustomer = $qr['customer_id'];
    $prefillService = $qr['service_id'] ?? '';
    $prefillStaff = $qr['staff_id'] ?? '';
  }
}
if ($prefillAppointment) {
  $ar = one('SELECT * FROM appointments WHERE id=? AND branch_id=?', [$prefillAppointment, $bid]);
  if ($ar) {
    $prefillCustomer = $ar['customer_id'];
    $prefillStaff = $ar['staff_id'];
    $prefillService = scalar('SELECT service_id FROM appointment_services WHERE appointment_id=? LIMIT 1', [$prefillAppointment]);
  }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  verify_csrf();
  try {
    db()->beginTransaction();
    $customerId = (int) ($_POST['customer_id'] ?? 0);
    if (!$customerId && trim($_POST['quick_name'] ?? ''))
      $customerId = create_customer_quick($_POST['quick_name'], $_POST['quick_phone'] ?? '');
    $types = $_POST['item_type'] ?? [];
    $ids = $_POST['item_id'] ?? [];
    $qtys = $_POST['quantity'] ?? [];
    $staffs = $_POST['staff_id'] ?? [];
    $lineDiscounts = $_POST['line_discount'] ?? [];
    $items = [];
    $subtotal = 0;
    $serviceIds = [];
    foreach ($types as $i => $type) {
      $itemId = (int) ($ids[$i] ?? 0);
      $qty = max(0.01, (float) ($qtys[$i] ?? 1));
      $staffId = (int) ($staffs[$i] ?? 0) ?: null;
      $disc = max(0, (float) ($lineDiscounts[$i] ?? 0));
      if (!$itemId)
        continue;
      if ($type === 'service') {
        $s = one('SELECT * FROM services WHERE id=? AND branch_id=? AND status="active"', [$itemId, $bid]);
        if (!$s)
          throw new RuntimeException('Invalid service selected.');
        $gross = $qty * (float) $s['price'];
        $total = max(0, $gross - $disc);
        $subtotal += $total;
        $serviceIds[] = $itemId;
        $items[] = ['type' => 'service', 'id' => $itemId, 'description' => $s['name'], 'unit' => (float) $s['price'], 'qty' => $qty, 'discount' => $disc, 'total' => $total, 'staff_id' => $staffId, 'service_id' => $itemId];
      } elseif ($type === 'product') {
        $p = one('SELECT * FROM products WHERE id=? AND branch_id=? AND status="active"', [$itemId, $bid]);
        if (!$p)
          throw new RuntimeException('Invalid product selected.');
        if ((int) $p['track_stock'] && stock_balance($bid, $itemId) < $qty)
          throw new RuntimeException('Insufficient stock for ' . $p['name']);
        $gross = $qty * (float) $p['selling_price'];
        $total = max(0, $gross - $disc);
        $subtotal += $total;
        $items[] = ['type' => 'product', 'id' => $itemId, 'description' => $p['name'], 'unit' => (float) $p['selling_price'], 'qty' => $qty, 'discount' => $disc, 'total' => $total, 'staff_id' => null, 'service_id' => null, 'track_stock' => (int) $p['track_stock']];
      } elseif ($type === 'package') {
        $p = one('SELECT * FROM packages WHERE id=? AND branch_id=? AND status="active"', [$itemId, $bid]);
        if (!$p)
          throw new RuntimeException('Invalid package selected.');
        $gross = $qty * (float) $p['package_price'];
        $total = max(0, $gross - $disc);
        $subtotal += $total;
        $items[] = ['type' => 'package', 'id' => $itemId, 'description' => $p['name'], 'unit' => (float) $p['package_price'], 'qty' => $qty, 'discount' => $disc, 'total' => $total, 'staff_id' => $staffId, 'service_id' => null];
        foreach (all('SELECT service_id FROM package_services WHERE package_id=?', [$itemId]) as $ps)
          $serviceIds[] = (int) $ps['service_id'];
      }
    }
    if (!$items)
      throw new RuntimeException('Add at least one service, product, or package.');

    // Stop the sale before saving if direct products, service-consumption products,
    // or package-consumption products are not available in stock.
    validate_sale_stock_availability($bid, $items);

    $membershipDiscount = 0;
    if ($customerId) {
      $mp = active_membership_discount($customerId);
      if ($mp > 0)
        $membershipDiscount = round($subtotal * $mp / 100, 2);
    }
    $promoId = (int) ($_POST['promotion_id'] ?? 0) ?: null;
    $promoDiscount = promotion_discount($promoId, $customerId, $subtotal - $membershipDiscount, $serviceIds);
    $manualDiscount = max(0, (float) ($_POST['discount_amount'] ?? 0));
    $spendPerPoint = (float) setting('loyalty_spend_per_point', 1000, $bid);
    $pointValue = (float) setting('loyalty_point_value', 100, $bid);
    $redeem = (int) ($_POST['loyalty_points_redeemed'] ?? 0);
    if (!$customerId)
      $redeem = 0;
    $available = loyalty_balance($customerId);
    $redeem = min($redeem, $available);
    $loyaltyDiscount = min(max(0, $subtotal - $membershipDiscount - $promoDiscount - $manualDiscount), $redeem * $pointValue);
    $discount = $membershipDiscount + $promoDiscount + $manualDiscount + $loyaltyDiscount;
    $taxPercent = (float) setting('tax_percent', 0, $bid);
    $tax = round(max(0, $subtotal - $discount) * $taxPercent / 100, 2);
    $total = max(0, $subtotal - $discount + $tax);
    $payments = [];
    $paid = 0;
    foreach (payment_methods() as $method => $label) {
      $amt = max(0, (float) ($_POST['pay_' . $method] ?? 0));
      if ($amt > 0) {
        $payments[] = ['method' => $method, 'amount' => $amt, 'ref' => trim($_POST['ref_' . $method] ?? ''), 'gift_code' => trim($_POST['gift_code'] ?? '')];
        $paid += $amt;
      }
    }
    if ($paid > $total + 0.01)
      throw new RuntimeException('Payment is greater than invoice total.');
    $status = $paid + 0.01 >= $total ? 'paid' : 'partial';
    $invoice = next_code('INV', 'sales', 'invoice_no');
    $appointmentId = (int) ($_POST['appointment_id'] ?? 0) ?: null;
    $queueId = (int) ($_POST['queue_id'] ?? 0) ?: null;
    q('INSERT INTO sales(branch_id,invoice_no,customer_id,appointment_id,queue_id,subtotal,discount_amount,tax_amount,total_amount,paid_amount,balance_amount,status,promotion_id,membership_discount,loyalty_points_redeemed,notes,created_by,created_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())', [$bid, $invoice, $customerId ?: null, $appointmentId, $queueId, $subtotal, $discount, $tax, $total, $paid, max(0, $total - $paid), $status, $promoId, $membershipDiscount, $redeem, trim($_POST['notes'] ?? ''), $_SESSION['user_id']]);
    $saleId = (int) db()->lastInsertId();
    foreach ($items as $it) {
      q('INSERT INTO sale_items(sale_id,item_type,item_id,description,staff_id,quantity,unit_price,discount_amount,line_total) VALUES(?,?,?,?,?,?,?,?,?)', [$saleId, $it['type'], $it['id'], $it['description'], $it['staff_id'], $it['qty'], $it['unit'], $it['discount'], $it['total']]);
      $saleItemId = (int) db()->lastInsertId();
      if ($it['type'] === 'service') {
        consume_service_products($bid, $it['id'], $it['qty'], 'sale', $saleId);
        if ($it['staff_id'])
          make_commission($bid, $saleId, $saleItemId, $it['staff_id'], $it['id'], $it['total']);
        if ($customerId)
          create_customer_continuation($bid, $customerId, $saleId, $saleItemId, $it['id'], $it['staff_id'], $it['qty']);
      } elseif ($it['type'] === 'product' && !empty($it['track_stock']))
        stock_move($bid, $it['id'], -1 * $it['qty'], 'sale', 'sale', $saleId, 'Product sold');
      elseif ($it['type'] === 'package') {
        $svc = all('SELECT ps.service_id,ps.quantity,s.price FROM package_services ps JOIN services s ON s.id=ps.service_id WHERE ps.package_id=?', [$it['id']]);
        $sum = 0;
        foreach ($svc as $s)
          $sum += (float) $s['price'] * (int) $s['quantity'];
        foreach ($svc as $s) {
          $serviceBase = $sum > 0 ? ($it['total'] * ((float) $s['price'] * (int) $s['quantity'] / $sum)) : $it['total'] / max(1, count($svc));
          consume_service_products($bid, (int) $s['service_id'], $it['qty'] * (int) $s['quantity'], 'sale', $saleId);
          if ($it['staff_id'])
            make_commission($bid, $saleId, $saleItemId, $it['staff_id'], (int) $s['service_id'], $serviceBase);
          if ($customerId)
            create_customer_continuation($bid, $customerId, $saleId, $saleItemId, (int) $s['service_id'], $it['staff_id'], $it['qty'] * (int) $s['quantity']);
        }
      }
    }
    foreach ($payments as $pay) {
      $giftId = null;
      if ($pay['method'] === 'gift_card') {
        $gc = one('SELECT * FROM gift_cards WHERE code=? AND branch_id=? AND status="active"', [$pay['gift_code'], $bid]);
        if (!$gc)
          throw new RuntimeException('Gift card not found or inactive.');
        if ($gc['expiry_date'] && $gc['expiry_date'] < today())
          throw new RuntimeException('Gift card has expired.');
        if ((float) $gc['current_balance'] < $pay['amount'])
          throw new RuntimeException('Gift card balance is too low.');
        $giftId = (int) $gc['id'];
        q('UPDATE gift_cards SET current_balance=current_balance-?, status=IF(current_balance-?<=0,"used","active") WHERE id=?', [$pay['amount'], $pay['amount'], $giftId]);
        q('INSERT INTO gift_card_transactions(gift_card_id,sale_id,amount,type,created_by,created_at) VALUES(?,?,?,"redeem",?,NOW())', [$giftId, $saleId, $pay['amount'], $_SESSION['user_id']]);
      }
      q('INSERT INTO payments(branch_id,sale_id,payment_method,amount,reference_no,gift_card_id,received_by,payment_date) VALUES(?,?,?,?,?,?,?,NOW())', [$bid, $saleId, $pay['method'], $pay['amount'], $pay['ref'], $giftId, $_SESSION['user_id']]);
    }
    if ($customerId) {
      $acc = ensure_loyalty_account($customerId);
      if ($redeem > 0) {
        q('UPDATE loyalty_accounts SET points_balance=points_balance-?,updated_at=NOW() WHERE id=?', [$redeem, $acc]);
        q('INSERT INTO loyalty_transactions(account_id,sale_id,transaction_type,points,description,created_by,created_at) VALUES(?,?,"redeem",?,?,?,NOW())', [$acc, $saleId, -$redeem, 'Redeemed points', $_SESSION['user_id']]);
      }
      $earn = $spendPerPoint > 0 ? (int) floor($total / $spendPerPoint) : 0;
      if ($earn > 0) {
        q('UPDATE loyalty_accounts SET points_balance=points_balance+?,lifetime_points=lifetime_points+?,updated_at=NOW() WHERE id=?', [$earn, $earn, $acc]);
        q('INSERT INTO loyalty_transactions(account_id,sale_id,transaction_type,points,description,created_by,created_at) VALUES(?,?,"earn",?,?,?,NOW())', [$acc, $saleId, $earn, 'Earned from invoice ' . $invoice, $_SESSION['user_id']]);
      }
      if (($c = one('SELECT full_name,phone FROM customers WHERE id=?', [$customerId])) && $c['phone'])
        post_notification($customerId, 'sms', $c['phone'], 'Payment of ' . money($paid) . ' received for invoice ' . $invoice, $bid);
    }
    if ($appointmentId)
      q('UPDATE appointments SET status="completed" WHERE id=? AND branch_id=?', [$appointmentId, $bid]);
    if ($queueId)
      q('UPDATE queues SET status="completed",completed_at=NOW() WHERE id=? AND branch_id=?', [$queueId, $bid]);
    audit('create', 'sales', $saleId, ['invoice' => $invoice, 'total' => $total]);
    log_activity('Payment received for ' . $invoice . ' (' . money($paid) . ')', 'sale', $bid);
    db()->commit();
    redirect('modules/sale_view.php?id=' . $saleId);
  } catch (Throwable $e) {
    if (db()->inTransaction())
      db()->rollBack();
    flash('error', $e->getMessage());
    redirect('modules/pos.php');
  }
}
$services = all('SELECT id,name,price,duration_minutes FROM services WHERE branch_id=? AND status="active" ORDER BY name', [$bid]);
$products = all('SELECT p.id,p.name,p.selling_price price,COALESCE(sl.quantity,0) stock FROM products p LEFT JOIN stock_levels sl ON sl.product_id=p.id AND sl.branch_id=p.branch_id WHERE p.branch_id=? AND p.status="active" ORDER BY p.name', [$bid]);
$packages = all('SELECT id,name,package_price price FROM packages WHERE branch_id=? AND status="active" ORDER BY name', [$bid]);
$promos = all('SELECT id,CONCAT(name," — ",discount_value,IF(discount_type="percentage","%"," TZS")) label FROM promotions WHERE branch_id=? AND status="active" AND NOW() BETWEEN start_at AND end_at ORDER BY name', [$bid]);
$title = 'Point of Sale';
$subtitle = 'Sell services, products or packages with cash, M-Pesa, Airtel Money, Tigo Pesa, HaloPesa, and bank transfer.';
include dirname(__DIR__) . '/includes/header.php'; ?>
<form method="post" id="posForm"><?= csrf_field() ?><input type="hidden" name="queue_id"
    value="<?= e($prefillQueue) ?>"><input type="hidden" name="appointment_id" value="<?= e($prefillAppointment) ?>">
  <div class="pos-layout">
    <section class="card">
      <h2>Customer</h2>
      <div class="form-grid">
        <div class="form-group"><label>Existing Customer</label><select name="customer_id">
            <option value="">Walk-in And Saved Customer</option><?php foreach (customers_options() as $id => $l): ?>
              <option value="<?= e($id) ?>" <?= selected($prefillCustomer, $id) ?>><?= e($l) ?></option>
            <?php endforeach; ?>
          </select></div>
        <div class="form-group"><label>Customer Name</label><input name="quick_name"></div>
        <div class="form-group"><label>Customer Phone</label><input name="quick_phone"></div>
        <div class="form-group"><label>Promotion</label><select name="promotion_id">
            <option value="">No promotion</option><?php foreach ($promos as $p): ?>
              <option value="<?= e($p['id']) ?>"><?= e($p['label']) ?></option><?php endforeach; ?>
          </select></div>
      </div>
      <h2>Catalog</h2>
      <div class="tabs"><a href="#" onclick="showCat('services');return false" class="active">Services</a><a href="#"
          onclick="showCat('products');return false">Products</a><a href="#"
          onclick="showCat('packages');return false">Packages</a></div>
      <div class="catalog" id="cat_services"><?php foreach ($services as $s): ?>
          <div class="catalog-item"
            onclick="addItem('service',<?= e($s['id']) ?>,'<?= e(addslashes($s['name'])) ?>',<?= e($s['price']) ?>)">
            <strong><?= e($s['name']) ?></strong><small><?= e($s['duration_minutes']) ?> min •
              <?= money($s['price']) ?></small>
          </div><?php endforeach; ?>
      </div>
      <div class="catalog hidden" id="cat_products"><?php foreach ($products as $p): ?>
          <div class="catalog-item"
            onclick="addItem('product',<?= e($p['id']) ?>,'<?= e(addslashes($p['name'])) ?>',<?= e($p['price']) ?>)">
            <strong><?= e($p['name']) ?></strong><small><?= money($p['price']) ?> • Stock <?= e($p['stock']) ?></small>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="catalog hidden" id="cat_packages"><?php foreach ($packages as $p): ?>
          <div class="catalog-item"
            onclick="addItem('package',<?= e($p['id']) ?>,'<?= e(addslashes($p['name'])) ?>',<?= e($p['price']) ?>)">
            <strong><?= e($p['name']) ?></strong><small><?= money($p['price']) ?></small>
          </div><?php endforeach; ?>
      </div>
    </section>
    <section class="card">
      <h2>Cart</h2>
      <div id="cart"></div>
      <div class="form-grid" style="margin-top:10px">
        <div class="form-group"><label>Manual Discount</label><input type="number" step="0.01" name="discount_amount"
            value="0" oninput="calcTotals()"></div>
        <!-- <div class="form-group"><label>Loyalty Points Redeemed</label><input type="number"
            name="loyalty_points_redeemed" value="0"></div>
      </div> -->
        <h3>Payments</h3>
        <div class="form-grid"><?php foreach (payment_methods() as $m => $l): ?>
            <div class="form-group"><label><?= e($l) ?></label><input type="number" step="0.01" min="0"
                name="pay_<?= e($m) ?>" value="0"></div>
            <div class="form-group"><label>Reference</label><input name="ref_<?= e($m) ?>" placeholder="Optional"></div>
          <?php endforeach; ?>
          <div class="form-group full"><label>Gift Card Code</label><input name="gift_code"
              placeholder="Required when paying by gift card"></div>
          <div class="form-group full"><label>Notes</label><textarea name="notes"></textarea></div>
        </div>
        <div class="totals">
          <div><span>Subtotal</span><strong id="subT">TZS 0</strong></div>
          <div class="grand"><span>Enter payment and save</span></div>
        </div><button class="btn success" style="width:100%;margin-top:12px">Complete Sale</button>
    </section>
  </div>
</form>
<script>const staffOptions = `<option value="">No staff</option><?php foreach (staff_options() as $id => $l): ?><option value="<?= e($id) ?>"<?= selected($prefillStaff, $id) ?>><?= e($l) ?></option><?php endforeach; ?>`; function money(n) { return 'TZS ' + Number(n || 0).toLocaleString('en-US', { maximumFractionDigits: 0 }) } function showCat(c) { ['services', 'products', 'packages'].forEach(x => document.querySelector('#cat_' + x).classList.toggle('hidden', x !== c)); document.querySelectorAll('.tabs a').forEach(a => a.classList.remove('active')); event.target.classList.add('active') } function addItem(type, id, name, price) { let row = document.createElement('div'); row.className = 'cart-row'; row.innerHTML = `<input type="hidden" name="item_type[]" value="${type}"><input type="hidden" name="item_id[]" value="${id}"><div><strong>${name}</strong><br><small>${type} • ${money(price)}</small><select name="staff_id[]" style="margin-top:5px;width:100%;display:${type === 'product' ? 'none' : 'block'}">${staffOptions}</select></div><input type="number" step="0.01" min="0.01" name="quantity[]" value="1" oninput="calcTotals()"><input type="number" step="0.01" min="0" name="line_discount[]" value="0" oninput="calcTotals()" title="Line discount"><button type="button" class="btn small danger" onclick="this.parentElement.remove();calcTotals()">×</button><input type="hidden" class="line-price" value="${price}">`; document.querySelector('#cart').appendChild(row); calcTotals() } function calcTotals() { let s = 0; document.querySelectorAll('#cart .cart-row').forEach(r => { let p = Number(r.querySelector('.line-price').value), q = Number(r.querySelector('[name="quantity[]"]').value), d = Number(r.querySelector('[name="line_discount[]"]').value); s += Math.max(0, p * q - d) }); document.querySelector('#subT').innerText = money(s) }<?php if ($prefillService): ?>addItem('service', <?= e($prefillService) ?>, 'Selected Service', 0); <?php endif; ?></script>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>