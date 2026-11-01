<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
require_permission('queue.manage');
$bid = current_branch_id();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $customerId = (int) ($_POST['customer_id'] ?? 0);
    if (!$customerId && trim($_POST['quick_name'] ?? ''))
        $customerId = create_customer_quick($_POST['quick_name'], $_POST['quick_phone'] ?? '');
    $qn = next_queue_no($bid);
    q('INSERT INTO queues(branch_id,queue_date,queue_number,customer_id,service_id,staff_id,status,checked_in_at,notes) VALUES(?,CURDATE(),?,?,?,?,' . "'waiting'" . ',NOW(),?)', [$bid, $qn, $customerId ?: null, (int) ($_POST['service_id'] ?? 0) ?: null, (int) ($_POST['staff_id'] ?? 0) ?: null, trim($_POST['notes'] ?? '')]);
    $id = (int) db()->lastInsertId();
    audit('create', 'queues', $id);
    log_activity('Walk-in customer added to queue #' . $qn, 'queue', $bid);
    flash('success', 'Customer added to queue number ' . $qn . '.');
    redirect('modules/queue.php');
}
$title = 'Walk-In Customers';
$subtitle = 'Fast entry for customers that do not rely only on appointments.';
include dirname(__DIR__) . '/includes/header.php'; ?>
<section class="card">
    <h2>Add Walk-in / Quick Customer</h2>
    <form method="post"><?= csrf_field() ?>
        <div class="form-grid">
            <div class="form-group"><label>Select Existing Customer</label><select name="customer_id">
                    <option value="">select a customer</option><?php foreach (customers_options() as $id => $l): ?>
                        <option value="<?= e($id) ?>"><?= e($l) ?></option><?php endforeach; ?>
                </select></div>
            <div class="form-group"><label> Customer Name</label><input name="quick_name" placeholder="e.g. Mary">
            </div>
            <div class="form-group"><label>Phone</label><input name="quick_phone" placeholder="07xx xxx xxx">
            </div>
            <div class="form-group"><label>Expected Service</label><select name="service_id">
                    <option value="">Not sure yet</option><?php foreach (service_options() as $id => $l): ?>
                        <option value="<?= e($id) ?>"><?= e($l) ?></option><?php endforeach; ?>
                </select></div>
            <div class="form-group"><label>Assign Staff</label><select name="staff_id">
                    <option value="">Unassigned</option><?php foreach (staff_options() as $id => $l): ?>
                        <option value="<?= e($id) ?>"><?= e($l) ?></option><?php endforeach; ?>
                </select></div>
            <div class="form-group full"><label>Notes</label><textarea name="notes"></textarea></div>
        </div><button class="btn">Add to Queue</button>
    </form>
</section><?php include dirname(__DIR__) . '/includes/footer.php'; ?>