<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
require_permission('appointments.view');
$bid = current_branch_id();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    require_permission('appointments.manage');
    $action = $_POST['_action'] ?? 'save';
    if ($action === 'status') {
        $id = (int) $_POST['id'];
        $status = $_POST['status'];
        q('UPDATE appointments SET status=? WHERE id=? AND branch_id=?', [$status, $id, $bid]);
        if ($status === 'checked_in') {
            $a = one('SELECT * FROM appointments WHERE id=? AND branch_id=?', [$id, $bid]);
            if ($a && !scalar('SELECT id FROM queues WHERE appointment_id=? AND branch_id=? AND queue_date=CURDATE() LIMIT 1', [$id, $bid])) {
                $qn = next_queue_no($bid);
                $firstService = (int) (scalar('SELECT service_id FROM appointment_services WHERE appointment_id=? ORDER BY id LIMIT 1', [$id]) ?: 0);
                q('INSERT INTO queues(branch_id,queue_date,queue_number,appointment_id,customer_id,service_id,staff_id,status,checked_in_at,notes) VALUES(?,CURDATE(),?,?,?,?,?,"waiting",NOW(),?)', [$bid, $qn, $id, $a['customer_id'], $firstService ?: null, $a['staff_id'], 'Checked in from appointment ' . $a['appointment_no']]);
            }
        }
        audit('update', 'appointments', $id, ['status' => $status]);
        flash('success', 'Appointment updated.');
        redirect('modules/appointments.php');
    }
    $id = (int) ($_POST['id'] ?? 0);
    $customerId = (int) ($_POST['customer_id'] ?? 0);
    if (!$customerId && trim($_POST['quick_name'] ?? ''))
        $customerId = create_customer_quick($_POST['quick_name'], $_POST['quick_phone'] ?? '');
    $date = $_POST['appointment_date'];
    $time = $_POST['start_time'];
    $staffId = (int) ($_POST['staff_id'] ?? 0) ?: null;
    $serviceIds = array_values(array_filter(array_map('intval', $_POST['service_id'] ?? [])));
    if (!$serviceIds)
        throw new RuntimeException('Select at least one service.');
    $services = all('SELECT id,price,duration_minutes FROM services WHERE branch_id=? AND status="active" AND id IN (' . implode(',', array_fill(0, count($serviceIds), '?')) . ')', array_merge([$bid], $serviceIds));
    if (count($services) !== count($serviceIds))
        throw new RuntimeException('One selected service is not active or not available in this branch.');
    $duration = 0;
    foreach ($services as $svc)
        $duration += (int) $svc['duration_minutes'];
    if ($duration <= 0)
        $duration = 30;
    $start = new DateTime($date . ' ' . $time);
    $end = (clone $start)->modify('+' . $duration . ' minutes');
    $endTime = $end->format('H:i:s');
    if ($staffId) {
        $over = (int) scalar('SELECT COUNT(*) FROM appointments WHERE branch_id=? AND staff_id=? AND appointment_date=? AND id<>? AND status NOT IN("cancelled","no_show","completed") AND start_time < ? AND end_time > ?', [$bid, $staffId, $date, $id, $endTime, $time]);
        if ($over > 0) {
            flash('error', 'This staff member is already booked at that time.');
            redirect('modules/appointments.php' . ($id ? '?edit=' . $id : ''));
        }
    }
    if (!$id) {
        $no = next_code('APT', 'appointments', 'appointment_no');
        q('INSERT INTO appointments(branch_id,customer_id,appointment_no,appointment_date,start_time,end_time,staff_id,status,source,notes,created_by,created_at) VALUES(?,?,?,?,?,?,?,"booked",?,?,?,NOW())', [$bid, $customerId ?: null, $no, $date, $time, $endTime, $staffId, $_POST['source'] ?? 'phone', trim($_POST['notes'] ?? ''), $_SESSION['user_id']]);
        $id = (int) db()->lastInsertId();
        audit('create', 'appointments', $id);
    } else {
        q('UPDATE appointments SET customer_id=?,appointment_date=?,start_time=?,end_time=?,staff_id=?,source=?,notes=? WHERE id=? AND branch_id=?', [$customerId ?: null, $date, $time, $endTime, $staffId, $_POST['source'] ?? 'phone', trim($_POST['notes'] ?? ''), $id, $bid]);
        q('DELETE FROM appointment_services WHERE appointment_id=?', [$id]);
        audit('update', 'appointments', $id);
    }
    foreach ($services as $svc)
        q('INSERT INTO appointment_services(appointment_id,service_id,price,duration_minutes,staff_id) VALUES(?,?,?,?,?)', [$id, $svc['id'], $svc['price'], $svc['duration_minutes'], $staffId]);
    if ($customerId && ($c = one('SELECT full_name,phone FROM customers WHERE id=?', [$customerId])) && $c['phone'])
        post_notification($customerId, 'whatsapp', $c['phone'], 'Hello ' . $c['full_name'] . ', your appointment is booked for ' . $date . ' at ' . $time, $bid);
    flash('success', 'Appointment saved.');
    redirect('modules/appointments.php');
}
$filter = $_GET['date'] ?? today();
if (!valid_date($filter))
    $filter = today();
$edit = null;
$editServices = [];
if (isset($_GET['edit'])) {
    $edit = one('SELECT * FROM appointments WHERE id=? AND branch_id=?', [(int) $_GET['edit'], $bid]);
    if ($edit)
        $editServices = array_column(all('SELECT service_id FROM appointment_services WHERE appointment_id=?', [$edit['id']]), 'service_id');
}
$rows = all('SELECT a.*,c.full_name customer,st.full_name staff,GROUP_CONCAT(s.name SEPARATOR ", ") services FROM appointments a LEFT JOIN customers c ON c.id=a.customer_id LEFT JOIN staff st ON st.id=a.staff_id LEFT JOIN appointment_services aps ON aps.appointment_id=a.id LEFT JOIN services s ON s.id=aps.service_id WHERE a.branch_id=? AND a.appointment_date=? GROUP BY a.id ORDER BY a.start_time', [$bid, $filter]);
$title = 'Appointment Booking';
$subtitle = 'Daily, weekly and monthly booking with staff double-booking prevention.';
include dirname(__DIR__) . '/includes/header.php'; ?>
<div class="toolbar">
    <form><input type="date" name="date" value="<?= e($filter) ?>" data-autosubmit></form><a class="btn"
        href="?new=1&date=<?= e($filter) ?>">+ Book Appointment</a><a class="btn secondary" href="booking_link.php">Send
        WhatsApp Booking Link</a><a class="btn light"
        href="?date=<?= e(date('Y-m-d', strtotime($filter . ' -1 day'))) ?>">Previous Day</a><a class="btn light"
        href="?date=<?= e(date('Y-m-d', strtotime($filter . ' +1 day'))) ?>">Next Day</a>
</div>
<?php if (isset($_GET['new']) || $edit): ?>
    <section class="card">
        <h2><?= $edit ? 'Edit' : 'Book' ?> Appointment</h2>
        <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>">
            <div class="form-grid">
                <div class="form-group"><label>Existing Customer</label><select name="customer_id">
                        <option value="">Walk-in / Quick Customer</option>
                        <?php foreach (customers_options() as $id => $l): ?>
                            <option value="<?= e($id) ?>" <?= selected($edit['customer_id'] ?? '', $id) ?>><?= e($l) ?></option>
                        <?php endforeach; ?>
                    </select></div>
                <div class="form-group"><label> Customer Name</label><input name="quick_name"></div>
                <div class="form-group"><label>Phone</label><input name="quick_phone"></div>
                <div class="form-group"><label>Date</label><input type="date" name="appointment_date" required
                        value="<?= e($edit['appointment_date'] ?? $filter) ?>"></div>
                <div class="form-group"><label>Start Time</label><input type="time" name="start_time" required
                        value="<?= e(isset($edit['start_time']) ? substr($edit['start_time'], 0, 5) : '09:00') ?>"></div>
                <div class="form-group"><label>Staff</label><select name="staff_id">
                        <option value="">Unassigned</option><?php foreach (staff_options() as $id => $l): ?>
                            <option value="<?= e($id) ?>" <?= selected($edit['staff_id'] ?? '', $id) ?>><?= e($l) ?></option>
                        <?php endforeach; ?>
                    </select></div>
                <div class="form-group"><label>Source</label><select
                        name="source"><?php foreach (['phone', 'walk_in', 'whatsapp', 'website', 'other'] as $src): ?>
                            <option value="<?= e($src) ?>" <?= selected($edit['source'] ?? 'phone', $src) ?>><?= e($src) ?>
                            </option>
                        <?php endforeach; ?>
                    </select></div>
                <div class="form-group full"><label>Services</label>
                    <div class="grid cols-3">
                        <?php foreach (all('SELECT id,name,duration_minutes,price FROM services WHERE branch_id=? AND status="active" ORDER BY name', [$bid]) as $s): ?><label><input
                                    type="checkbox" name="service_id[]" value="<?= e($s['id']) ?>" <?= checked(in_array($s['id'], $editServices)) ?>> <?= e($s['name']) ?>
                                <small><?= e($s['duration_minutes']) ?> min •
                                    <?= money($s['price']) ?></small></label><?php endforeach; ?>
                    </div>
                </div>
                <div class="form-group full"><label>Notes</label><textarea
                        name="notes"><?= e($edit['notes'] ?? '') ?></textarea></div>
            </div><button class="btn">Save Appointment</button>
        </form>
    </section><?php endif; ?>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Time</th>
                <th>No.</th>
                <th>Customer</th>
                <th>Services</th>
                <th>Staff</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody><?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= e(substr($r['start_time'], 0, 5)) ?>–<?= e(substr($r['end_time'], 0, 5)) ?></td>
                    <td><?= e($r['appointment_no']) ?></td>
                    <td><?= e($r['customer'] ?? 'Walk-in') ?></td>
                    <td><?= e($r['services']) ?></td>
                    <td><?= e($r['staff'] ?? 'Unassigned') ?></td>
                    <td><span class="badge purple"><?= e($r['status']) ?></span></td>
                    <td><a class="btn small light"
                            href="?edit=<?= e($r['id']) ?>&date=<?= e($filter) ?>">Edit</a><?php foreach (['confirmed' => 'Confirm', 'checked_in' => 'Check In', 'in_progress' => 'Start', 'completed' => 'Complete', 'cancelled' => 'Cancel', 'no_show' => 'No Show'] as $st => $lab): ?>
                            <form method="post" style="display:inline"><?= csrf_field() ?><input type="hidden" name="_action"
                                    value="status"><input type="hidden" name="id" value="<?= e($r['id']) ?>"><input
                                    type="hidden" name="status" value="<?= e($st) ?>"><button
                                    class="btn small secondary"><?= e($lab) ?></button>
                            </form><?php endforeach; ?>
                    </td>
                </tr><?php endforeach; ?><?php if (!$rows): ?>
                <tr>
                    <td colspan="7" class="text-center muted">No appointments for this date.</td>
                </tr><?php endif; ?>
        </tbody>
    </table>
</div><?php include dirname(__DIR__) . '/includes/footer.php'; ?>