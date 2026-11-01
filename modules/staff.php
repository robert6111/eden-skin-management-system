<?php
require dirname(__DIR__).'/includes/bootstrap.php';
require_permission('staff.view');

$bid = current_branch_id();
$canManage = can('staff.manage');
$self = $_SERVER['SCRIPT_NAME'] ?? '/modules/staff.php';

function staff_page_url($params = []) {
    $self = $_SERVER['SCRIPT_NAME'] ?? '/modules/staff.php';
    if (!$params) return $self;
    return $self.'?'.http_build_query($params);
}

function staff_redirect($params = []) {
    header('Location: '.staff_page_url($params));
    exit;
}

function staff_date_or_null($value) {
    $value = trim((string)$value);
    if ($value === '') return null;
    return preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) ? $value : null;
}

function staff_decimal($value) {
    $value = trim((string)$value);
    if ($value === '') return 0;
    return (float)$value;
}

function staff_next_employee_number() {
    $next = (int)(scalar('SELECT COALESCE(MAX(id),0)+1 FROM staff') ?: 1);
    do {
        $number = 'EMP-'.str_pad((string)$next, 4, '0', STR_PAD_LEFT);
        $exists = scalar('SELECT id FROM staff WHERE employee_no=? LIMIT 1', [$number]);
        $next++;
    } while ($exists);
    return $number;
}

function staff_branch_where(&$params) {
    if (!can('branches.view_all')) {
        $params[] = current_branch_id();
        return ' AND branch_id=?';
    }
    return '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_permission('staff.manage');
    verify_csrf();

    $action = $_POST['_action'] ?? 'save';

    try {
        if ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id <= 0) {
                flash('error', 'Invalid staff member.');
                staff_redirect();
            }

            $params = [$id];
            $where = 'id=?'.staff_branch_where($params);
            $existing = one("SELECT id, full_name FROM staff WHERE $where LIMIT 1", $params);

            if (!$existing) {
                flash('error', 'Staff member was not found or you do not have permission to delete it.');
                staff_redirect();
            }

            q("DELETE FROM staff WHERE $where", $params);
            audit('delete', 'staff', $id, ['name' => $existing['full_name'] ?? '']);
            flash('success', 'Staff member deleted successfully.');
            staff_redirect();
        }

        if ($action !== 'save') {
            flash('error', 'Invalid staff action.');
            staff_redirect();
        }

        $id = (int)($_POST['id'] ?? 0);
        $employeeNo = trim((string)($_POST['employee_no'] ?? ''));
        $fullName = trim((string)($_POST['full_name'] ?? ''));

        if ($fullName === '') {
            flash('error', 'Full name is required.');
            staff_redirect($id > 0 ? ['edit' => $id] : ['new' => 1]);
        }

        if ($employeeNo === '') {
            $employeeNo = staff_next_employee_number();
        }

        $duplicateParams = [$employeeNo];
        $duplicateSql = 'SELECT id FROM staff WHERE employee_no=?';
        if ($id > 0) {
            $duplicateSql .= ' AND id<>?';
            $duplicateParams[] = $id;
        }
        $duplicateSql .= ' LIMIT 1';
        if (scalar($duplicateSql, $duplicateParams)) {
            flash('error', 'That employee number already exists. Use another employee number.');
            staff_redirect($id > 0 ? ['edit' => $id] : ['new' => 1]);
        }

        $gender = $_POST['gender'] ?? 'Female';
        if (!in_array($gender, ['Male', 'Female', 'Other'], true)) $gender = 'Female';

        $commissionType = $_POST['default_commission_type'] ?? 'percentage';
        if (!in_array($commissionType, ['percentage', 'fixed'], true)) $commissionType = 'percentage';

        $status = $_POST['status'] ?? 'active';
        if (!in_array($status, ['active', 'inactive', 'terminated'], true)) $status = 'active';

        $data = [
            'employee_no' => $employeeNo,
            'full_name' => $fullName,
            'phone' => trim((string)($_POST['phone'] ?? '')) ?: null,
            'email' => trim((string)($_POST['email'] ?? '')) ?: null,
            'gender' => $gender,
            'date_of_birth' => staff_date_or_null($_POST['date_of_birth'] ?? ''),
            'address' => trim((string)($_POST['address'] ?? '')) ?: null,
            'role_title' => trim((string)($_POST['role_title'] ?? '')) ?: null,
            'salary' => staff_decimal($_POST['salary'] ?? 0),
            'default_commission_type' => $commissionType,
            'default_commission_value' => staff_decimal($_POST['default_commission_value'] ?? 0),
            'employment_date' => staff_date_or_null($_POST['employment_date'] ?? ''),
            'emergency_contact' => trim((string)($_POST['emergency_contact'] ?? '')) ?: null,
            'status' => $status,
            'updated_at' => now(),
        ];

        if ($id > 0) {
            $params = [$id];
            $where = 'id=?'.staff_branch_where($params);
            $existing = one("SELECT id FROM staff WHERE $where LIMIT 1", $params);
            if (!$existing) {
                flash('error', 'Staff member was not found or you do not have permission to edit it.');
                staff_redirect();
            }

            $set = [];
            $updateParams = [];
            foreach ($data as $col => $value) {
                $set[] = "`$col`=?";
                $updateParams[] = $value;
            }
            $updateParams = array_merge($updateParams, $params);
            q('UPDATE staff SET '.implode(', ', $set).' WHERE '.$where, $updateParams);
            audit('update', 'staff', $id, $data);
            flash('success', 'Staff member updated successfully.');
        } else {
            $data['branch_id'] = $bid ?: 1;
            $cols = array_keys($data);
            $marks = array_fill(0, count($cols), '?');
            q('INSERT INTO staff (`'.implode('`,`', $cols).'`) VALUES ('.implode(',', $marks).')', array_values($data));
            $id = (int)db()->lastInsertId();
            audit('create', 'staff', $id, $data);
            flash('success', 'Staff member added successfully.');
        }

        staff_redirect();
    } catch (PDOException $e) {
        flash('error', 'Staff could not be saved. '.$e->getMessage());
        $id = (int)($_POST['id'] ?? 0);
        staff_redirect($id > 0 ? ['edit' => $id] : ['new' => 1]);
    } catch (Throwable $e) {
        flash('error', 'Staff could not be saved. '.$e->getMessage());
        $id = (int)($_POST['id'] ?? 0);
        staff_redirect($id > 0 ? ['edit' => $id] : ['new' => 1]);
    }
}

$edit = null;
$showForm = isset($_GET['new']);
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $params = [$id];
    $where = 'id=?'.staff_branch_where($params);
    $edit = one("SELECT * FROM staff WHERE $where LIMIT 1", $params);
    if ($edit) {
        $showForm = true;
    } else {
        flash('error', 'Staff member was not found or you do not have permission to edit it.');
    }
}

$qterm = trim((string)($_GET['q'] ?? ''));
$params = [];
$where = '1=1';
if (!can('branches.view_all')) {
    $where .= ' AND branch_id=?';
    $params[] = $bid;
}
if ($qterm !== '') {
    $where .= ' AND (employee_no LIKE ? OR full_name LIKE ? OR phone LIKE ? OR role_title LIKE ?)';
    $like = '%'.$qterm.'%';
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}
$rows = all("SELECT * FROM staff WHERE $where ORDER BY id DESC", $params);

$title = 'Staff Management';
$subtitle = 'Add, edit and manage salon and spa staff without changing other system modules.';
include dirname(__DIR__).'/includes/header.php';
?>
<div class="toolbar">
    <form method="get" action="<?=e($self)?>">
        <input name="q" value="<?=e($qterm)?>" placeholder="Search staff name, phone, employee number or role…">
        <button class="btn light" type="submit">Search</button>
    </form>
    <span class="spacer"></span>
    <?php if ($canManage): ?>
        <a class="btn" href="<?=e($self)?>?new=1">+ Add Staff Member</a>
    <?php endif; ?>
</div>

<?php if ($showForm && $canManage): ?>
<section class="card" style="margin-bottom:16px">
    <h2><?= $edit ? 'Edit Staff Member' : 'Add New Staff Member' ?></h2>
    <form method="post" action="<?=e($self)?>">
        <?=csrf_field()?>
        <input type="hidden" name="_action" value="save">
        <input type="hidden" name="id" value="<?=e($edit['id'] ?? '')?>">

        <div class="form-grid">
            <div class="form-group">
                <label>Employee Number</label>
                <input name="employee_no" value="<?=e($edit['employee_no'] ?? '')?>" placeholder="Leave blank for automatic number">
            </div>
            <div class="form-group">
                <label>Full Name *</label>
                <input name="full_name" required value="<?=e($edit['full_name'] ?? '')?>">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input name="phone" value="<?=e($edit['phone'] ?? '')?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?=e($edit['email'] ?? '')?>">
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender">
                    <?php foreach (['Male'=>'Male','Female'=>'Female','Other'=>'Other'] as $value => $label): ?>
                        <option value="<?=e($value)?>"<?=selected($edit['gender'] ?? 'Female', $value)?>><?=e($label)?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" value="<?=e($edit['date_of_birth'] ?? '')?>">
            </div>
            <div class="form-group full">
                <label>Address</label>
                <input name="address" value="<?=e($edit['address'] ?? '')?>">
            </div>
            <div class="form-group">
                <label>Role / Staff Type</label>
                <input name="role_title" value="<?=e($edit['role_title'] ?? '')?>" placeholder="Hair Stylist, Barber, Nail Technician…">
            </div>
            <div class="form-group">
                <label>Salary</label>
                <input type="number" step="0.01" min="0" name="salary" value="<?=e($edit['salary'] ?? '0')?>">
            </div>
            <div class="form-group">
                <label>Default Commission Type</label>
                <select name="default_commission_type">
                    <option value="percentage"<?=selected($edit['default_commission_type'] ?? 'percentage', 'percentage')?>>Percentage</option>
                    <option value="fixed"<?=selected($edit['default_commission_type'] ?? '', 'fixed')?>>Fixed Amount</option>
                </select>
            </div>
            <div class="form-group">
                <label>Default Commission Value</label>
                <input type="number" step="0.01" min="0" name="default_commission_value" value="<?=e($edit['default_commission_value'] ?? '0')?>">
            </div>
            <div class="form-group">
                <label>Employment Date</label>
                <input type="date" name="employment_date" value="<?=e($edit['employment_date'] ?? today())?>">
            </div>
            <div class="form-group">
                <label>Emergency Contact</label>
                <input name="emergency_contact" value="<?=e($edit['emergency_contact'] ?? '')?>">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="active"<?=selected($edit['status'] ?? 'active', 'active')?>>Active</option>
                    <option value="inactive"<?=selected($edit['status'] ?? '', 'inactive')?>>Inactive</option>
                    <option value="terminated"<?=selected($edit['status'] ?? '', 'terminated')?>>Terminated</option>
                </select>
            </div>
        </div>

        <div class="toolbar" style="margin-top:15px;margin-bottom:0">
            <button class="btn" type="submit">Save Staff Member</button>
            <a class="btn light" href="<?=e($self)?>">Cancel</a>
        </div>
    </form>
</section>
<?php endif; ?>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Employee No.</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Salary</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td><?=e($r['employee_no'] ?? '')?></td>
                <td><?=e($r['full_name'] ?? '')?></td>
                <td><?=e($r['phone'] ?? '')?></td>
                <td><?=e($r['role_title'] ?? '')?></td>
                <td><?=money($r['salary'] ?? 0)?></td>
                <td><?=e(ucfirst((string)($r['status'] ?? '')))?></td>
                <td>
                    <?php if ($canManage): ?>
                        <a class="btn small light" href="<?=e($self)?>?edit=<?=e($r['id'])?>">Edit</a>
                        <form method="post" action="<?=e($self)?>" style="display:inline">
                            <?=csrf_field()?>
                            <input type="hidden" name="_action" value="delete">
                            <input type="hidden" name="id" value="<?=e($r['id'])?>">
                            <button class="btn small danger" type="submit" data-confirm="Delete this staff member?">Delete</button>
                        </form>
                    <?php else: ?>
                        <span class="muted">View only</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$rows): ?>
            <tr><td colspan="7" class="text-center muted">No staff members found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include dirname(__DIR__).'/includes/footer.php'; ?>