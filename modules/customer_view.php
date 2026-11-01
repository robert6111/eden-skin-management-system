<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
require_permission('customers.view');
$bid = current_branch_id();
ensure_continuation_schema();
$id = (int) ($_GET['id'] ?? 0);
$c = one('SELECT * FROM customers WHERE id=? AND branch_id=?', [$id, $bid]);
if (!$c)
    exit('Customer not found');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    require_permission('customers.manage');
    q('INSERT INTO customer_notes(customer_id,user_id,note,created_at) VALUES(?,?,?,NOW())', [$id, $_SESSION['user_id'], trim($_POST['note'])]);
    flash('success', 'Note saved.');
    redirect('modules/customer_view.php?id=' . $id);
}
$sales = all('SELECT * FROM sales WHERE customer_id=? ORDER BY id DESC LIMIT 100', [$id]);
$apps = all('SELECT * FROM appointments WHERE customer_id=? ORDER BY appointment_date DESC,start_time DESC LIMIT 100', [$id]);
$conts = all('SELECT f.*,s.name service_name,COALESCE(cs.name,s.name) continuation_service,st.full_name staff,a.appointment_no FROM customer_service_continuations f JOIN services s ON s.id=f.service_id LEFT JOIN services cs ON cs.id=f.continuation_service_id LEFT JOIN staff st ON st.id=f.staff_id LEFT JOIN appointments a ON a.id=f.appointment_id WHERE f.customer_id=? ORDER BY f.due_date DESC,f.id DESC LIMIT 100', [$id]);
$notes = all('SELECT cn.*,u.username FROM customer_notes cn LEFT JOIN users u ON u.id=cn.user_id WHERE cn.customer_id=? ORDER BY cn.id DESC', [$id]);
$loyalty = one('SELECT * FROM loyalty_accounts WHERE customer_id=?', [$id]);
$members = all('SELECT cm.*,m.name FROM customer_memberships cm JOIN memberships m ON m.id=cm.membership_id WHERE cm.customer_id=? ORDER BY cm.id DESC', [$id]);
$title = 'Customer History';
$subtitle = $c['full_name'] . ' — services, products, payments, notes, continuations and preferences.';
include dirname(__DIR__) . '/includes/header.php'; ?>
<section class="card">
    <div class="grid cols-3">
        <p><strong>Phone:</strong><br><?= e($c['phone']) ?></p>
        <p><strong>Email:</strong><br><?= e($c['email']) ?></p>
        <!-- <p><strong>Loyalty:</strong><br><?= e($loyalty['points_balance'] ?? 0) ?> points</p> -->
    </div>
    <p><strong>Preferences:</strong> <?= e($c['preferences']) ?></p>
    <div class="toolbar"><a class="btn secondary" href="continuations.php?new=1&customer_id=<?= e($id) ?>">Plan Service
            Continuation</a><a class="btn light" href="appointments.php?new=1">Book Appointment</a></div>
</section>
<div class="grid cols-2" style="margin-top:16px">
    <section class="card">
        <h2>Visits / Sales</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody><?php foreach ($sales as $s): ?>
                    <tr>
                        <td><?= e($s['sale_date']) ?></td>
                        <td><a href="sale_view.php?id=<?= e($s['id']) ?>"><?= e($s['invoice_no']) ?></a></td>
                        <td><?= money($s['total_amount']) ?></td>
                        <td><?= e($s['status']) ?></td>
                    </tr><?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <section class="card">
        <h2>Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody><?php foreach ($apps as $a): ?>
                    <tr>
                        <td><?= e($a['appointment_date']) ?></td>
                        <td><?= e($a['start_time']) ?></td>
                        <td><?= e($a['status']) ?></td>
                    </tr><?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<section class="card" style="margin-top:16px">
    <h2>Service Continuations</h2>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Due Date</th>
                    <th>Original Service</th>
                    <th>Continuation</th>
                    <th>Staff</th>
                    <th>Status</th>
                    <th>Appointment</th>
                </tr>
            </thead>
            <tbody><?php foreach ($conts as $f): ?>
                    <tr>
                        <td><?= e($f['due_date']) ?></td>
                        <td><?= e($f['service_name']) ?></td>
                        <td><?= e($f['continuation_service']) ?></td>
                        <td><?= e($f['staff'] ?: 'Unassigned') ?></td>
                        <td><span class="<?= e(continuation_badge($f['status'])) ?>"><?= e($f['status']) ?></span></td>
                        <td><?= e($f['appointment_no'] ?: '—') ?></td>
                    </tr><?php endforeach; ?><?php if (!$conts): ?>
                    <tr>
                        <td colspan="6" class="text-center muted">No continuation plans yet.</td>
                    </tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<div class="grid cols-2" style="margin-top:16px">
    <!-- <section class="card">
        <h2>Memberships</h2><?php foreach ($members as $m): ?>
            <p><?= e($m['name']) ?> — <?= e($m['start_date']) ?> to <?= e($m['end_date']) ?> (<?= e($m['status']) ?>)</p>

        <?php endforeach; ?>
    </section> -->
    <section class="card">
        <h2>Notes</h2>
        <form method="post"><?= csrf_field() ?><textarea name="note" required></textarea><button class="btn">Add
                Note</button></form><?php foreach ($notes as $n): ?>

            <p><strong><?= e($n['created_at']) ?></strong> <?= e($n['username']) ?><br><?= e($n['note']) ?></p>
        <?php endforeach; ?>
    </section>
</div><?php include dirname(__DIR__) . '/includes/footer.php'; ?>