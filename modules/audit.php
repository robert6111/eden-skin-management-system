<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
require_permission('audit.view');

$bid = current_branch_id();
$canAllBranches = can('branches.view_all');

function audit_table_exists(string $table): bool {
    try {
        return (int) scalar(
            'SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?',
            [$table]
        ) > 0;
    } catch (Throwable) {
        return false;
    }
}

function audit_clean_label(?string $value): string {
    $value = trim((string) $value);
    if ($value === '') return '—';
    return ucwords(str_replace(['_', '-'], ' ', $value));
}

function audit_friendly_message(array $row): string {
    $source = $row['source'] ?? 'audit';
    $action = audit_clean_label($row['action'] ?? '');
    $entity = audit_clean_label($row['entity_type'] ?? '');
    $entityId = $row['entity_id'] ?? null;

    if ($source === 'activity') {
        return (string) ($row['message'] ?? 'System activity');
    }

    $parts = [];
    if ($action !== '—') $parts[] = $action;
    if ($entity !== '—') $parts[] = $entity;
    if ($entityId !== null && $entityId !== '') $parts[] = '#' . $entityId;

    return $parts ? implode(' ', $parts) : 'Audit entry';
}

function audit_readable_details(mixed $details): string {
    if ($details === null || $details === '') return '<span class="muted">No extra details</span>';

    $decoded = is_string($details) ? json_decode($details, true) : null;

    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        if (!$decoded) return '<span class="muted">No extra details</span>';
        $html = '<div class="audit-details-grid">';
        foreach ($decoded as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }
            if ($value === null || $value === '') $value = '—';
            $html .= '<div><strong>' . e(audit_clean_label((string) $key)) . '</strong><br><span>' . e((string) $value) . '</span></div>';
        }
        $html .= '</div>';
        return $html;
    }

    return '<div class="audit-message">' . nl2br(e((string) $details)) . '</div>';
}

function audit_badge_class(string $source, string $action): string {
    $a = strtolower($action);
    if (str_contains($a, 'delete') || str_contains($a, 'refund') || str_contains($a, 'failed')) return 'badge red';
    if (str_contains($a, 'create') || str_contains($a, 'payment') || str_contains($a, 'sale')) return 'badge green';
    if (str_contains($a, 'update') || str_contains($a, 'adjust') || str_contains($a, 'edit')) return 'badge amber';
    if ($source === 'activity') return 'badge blue';
    return 'badge';
}

$from = trim($_GET['from'] ?? date('Y-m-d', strtotime('-30 days')));
$to = trim($_GET['to'] ?? date('Y-m-d'));
$qterm = trim($_GET['q'] ?? '');
$sourceFilter = trim($_GET['source'] ?? 'all');
$branchFilter = (int) ($_GET['branch_id'] ?? 0);
$limit = (int) ($_GET['limit'] ?? 200);
if ($limit < 25) $limit = 25;
if ($limit > 1000) $limit = 1000;

if (!valid_date($from)) $from = date('Y-m-d', strtotime('-30 days'));
if (!valid_date($to)) $to = date('Y-m-d');

$startDateTime = $from . ' 00:00:00';
$endDateTime = $to . ' 23:59:59';

$rows = [];

if (($sourceFilter === 'all' || $sourceFilter === 'audit') && audit_table_exists('audit_logs')) {
    $where = ['a.created_at BETWEEN ? AND ?'];
    $params = [$startDateTime, $endDateTime];

    if ($canAllBranches && $branchFilter > 0) {
        $where[] = 'a.branch_id = ?';
        $params[] = $branchFilter;
    } elseif (!$canAllBranches) {
        $where[] = '(a.branch_id = ? OR a.branch_id IS NULL)';
        $params[] = $bid;
    }

    if ($qterm !== '') {
        $where[] = '(a.action LIKE ? OR a.entity_type LIKE ? OR CAST(a.entity_id AS CHAR) LIKE ? OR a.details LIKE ? OR a.ip_address LIKE ? OR u.username LIKE ? OR b.name LIKE ?)';
        for ($i = 0; $i < 7; $i++) $params[] = '%' . $qterm . '%';
    }

    $auditRows = all(
        'SELECT 
            "audit" AS source,
            a.id,
            a.created_at,
            a.branch_id,
            COALESCE(b.name, "All / System") AS branch_name,
            a.user_id,
            COALESCE(u.username, "System") AS username,
            a.action,
            a.entity_type,
            a.entity_id,
            a.details,
            a.ip_address,
            a.user_agent,
            NULL AS message
         FROM audit_logs a
         LEFT JOIN users u ON u.id = a.user_id
         LEFT JOIN branches b ON b.id = a.branch_id
         WHERE ' . implode(' AND ', $where) . '
         ORDER BY a.created_at DESC, a.id DESC
         LIMIT ' . (int) $limit,
        $params
    );
    $rows = array_merge($rows, $auditRows);
}

if (($sourceFilter === 'all' || $sourceFilter === 'activity') && audit_table_exists('system_activities')) {
    $where = ['sa.created_at BETWEEN ? AND ?'];
    $params = [$startDateTime, $endDateTime];

    if ($canAllBranches && $branchFilter > 0) {
        $where[] = 'sa.branch_id = ?';
        $params[] = $branchFilter;
    } elseif (!$canAllBranches) {
        $where[] = '(sa.branch_id = ? OR sa.branch_id IS NULL)';
        $params[] = $bid;
    }

    if ($qterm !== '') {
        $where[] = '(sa.activity_type LIKE ? OR sa.message LIKE ? OR u.username LIKE ? OR b.name LIKE ?)';
        for ($i = 0; $i < 4; $i++) $params[] = '%' . $qterm . '%';
    }

    $activityRows = all(
        'SELECT
            "activity" AS source,
            sa.id,
            sa.created_at,
            sa.branch_id,
            COALESCE(b.name, "All / System") AS branch_name,
            sa.user_id,
            COALESCE(u.username, "System") AS username,
            sa.activity_type AS action,
            "system_activity" AS entity_type,
            NULL AS entity_id,
            NULL AS details,
            NULL AS ip_address,
            NULL AS user_agent,
            sa.message
         FROM system_activities sa
         LEFT JOIN users u ON u.id = sa.user_id
         LEFT JOIN branches b ON b.id = sa.branch_id
         WHERE ' . implode(' AND ', $where) . '
         ORDER BY sa.created_at DESC, sa.id DESC
         LIMIT ' . (int) $limit,
        $params
    );
    $rows = array_merge($rows, $activityRows);
}

usort($rows, function ($a, $b) {
    $dateCmp = strcmp((string) ($b['created_at'] ?? ''), (string) ($a['created_at'] ?? ''));
    if ($dateCmp !== 0) return $dateCmp;
    return (int) ($b['id'] ?? 0) <=> (int) ($a['id'] ?? 0);
});
$rows = array_slice($rows, 0, $limit);

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    $exportRows = [];
    foreach ($rows as $r) {
        $exportRows[] = [
            $r['created_at'] ?? '',
            $r['source'] ?? '',
            $r['branch_name'] ?? '',
            $r['username'] ?? '',
            audit_clean_label($r['action'] ?? ''),
            audit_clean_label($r['entity_type'] ?? ''),
            $r['entity_id'] ?? '',
            audit_friendly_message($r),
            $r['details'] ?? $r['message'] ?? '',
            $r['ip_address'] ?? '',
        ];
    }
    csv_download('audit_log_' . date('Ymd_His') . '.csv', ['Date', 'Source', 'Branch', 'User', 'Action', 'Entity', 'Record ID', 'Readable Message', 'Details', 'IP Address'], $exportRows);
}

$branches = $canAllBranches ? all('SELECT id, name FROM branches ORDER BY name') : [];

$title = 'Audit Trail';
$subtitle = 'Readable complete record of user actions, business changes, payments, stock movements, bookings, and system activity.';
include dirname(__DIR__) . '/includes/header.php';
?>
<style>
.audit-feed{display:grid;gap:12px}.audit-entry{border:1px solid #e6e8ef;border-radius:14px;padding:14px;background:#fff}.audit-entry-head{display:flex;gap:10px;align-items:flex-start;justify-content:space-between;flex-wrap:wrap}.audit-title{font-weight:700;font-size:15px}.audit-meta{color:#667085;font-size:12px;margin-top:4px}.audit-details-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:10px;margin-top:10px}.audit-details-grid div{background:#f8fafc;border:1px solid #eef2f7;border-radius:10px;padding:8px}.audit-message{background:#f8fafc;border:1px solid #eef2f7;border-radius:10px;padding:10px;margin-top:8px}.audit-tech{margin-top:10px}.audit-tech summary{cursor:pointer;color:#475467;font-size:13px}.audit-tech pre{white-space:pre-wrap;background:#111827;color:#f9fafb;border-radius:10px;padding:10px;overflow:auto;font-size:12px}.badge.blue{background:#e0f2fe;color:#075985}.badge.amber{background:#fef3c7;color:#92400e}.badge.red{background:#fee2e2;color:#991b1b}.filters .form-grid{align-items:end}
</style>

<section class="card filters" style="margin-bottom:16px">
    <form method="get">
        <div class="form-grid">
            <div class="form-group">
                <label>Search</label>
                <input name="q" value="<?= e($qterm) ?>" placeholder="Search action, user, item, IP, details…">
            </div>
            <div class="form-group">
                <label>From</label>
                <input type="date" name="from" value="<?= e($from) ?>">
            </div>
            <div class="form-group">
                <label>To</label>
                <input type="date" name="to" value="<?= e($to) ?>">
            </div>
            <div class="form-group">
                <label>Show</label>
                <select name="source">
                    <option value="all" <?= selected($sourceFilter, 'all') ?>>Audit + System Activity</option>
                    <option value="audit" <?= selected($sourceFilter, 'audit') ?>>Audit Logs Only</option>
                    <option value="activity" <?= selected($sourceFilter, 'activity') ?>>System Activity Only</option>
                </select>
            </div>
            <?php if ($canAllBranches): ?>
                <div class="form-group">
                    <label>Branch</label>
                    <select name="branch_id">
                        <option value="0">All branches</option>
                        <?php foreach ($branches as $b): ?>
                            <option value="<?= e($b['id']) ?>" <?= selected($branchFilter, $b['id']) ?>><?= e($b['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label>Limit</label>
                <select name="limit">
                    <?php foreach ([50, 100, 200, 500, 1000] as $l): ?>
                        <option value="<?= e($l) ?>" <?= selected($limit, $l) ?>><?= e($l) ?> records</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="toolbar" style="margin-top:12px">
            <button class="btn">Apply Filter</button>
            <a class="btn light" href="audit.php">Reset</a>
            <span class="spacer"></span>
            <a class="btn secondary" href="audit.php?<?= e(http_build_query(array_merge($_GET, ['export' => 'csv']))) ?>">Export CSV</a>
            <button class="btn light" type="button" onclick="window.print()">Print</button>
        </div>
    </form>
</section>

<section class="card" style="margin-bottom:16px">
    <div class="grid cols-4">
        <div><strong><?= e(count($rows)) ?></strong><br><span class="muted">Records shown</span></div>
        <div><strong><?= e($from) ?></strong><br><span class="muted">Start date</span></div>
        <div><strong><?= e($to) ?></strong><br><span class="muted">End date</span></div>
        <div><strong><?= e($sourceFilter === 'all' ? 'Audit + Activity' : audit_clean_label($sourceFilter)) ?></strong><br><span class="muted">Current view</span></div>
    </div>
</section>

<div class="audit-feed">
    <?php foreach ($rows as $r): ?>
        <?php
            $source = (string) ($r['source'] ?? 'audit');
            $action = (string) ($r['action'] ?? '');
            $detailsRaw = $source === 'activity' ? ($r['message'] ?? '') : ($r['details'] ?? '');
        ?>
        <section class="audit-entry">
            <div class="audit-entry-head">
                <div>
                    <div class="audit-title"><?= e(audit_friendly_message($r)) ?></div>
                    <div class="audit-meta">
                        <?= e($r['created_at'] ?? '') ?>
                        • <?= e($r['branch_name'] ?? 'All / System') ?>
                        • User: <?= e($r['username'] ?? 'System') ?>
                        <?php if (!empty($r['ip_address'])): ?> • IP: <?= e($r['ip_address']) ?><?php endif; ?>
                    </div>
                </div>
                <div>
                    <span class="<?= e(audit_badge_class($source, $action)) ?>"><?= e(audit_clean_label($action)) ?></span>
                    <span class="badge"><?= e($source === 'activity' ? 'System Activity' : 'Audit Log') ?></span>
                </div>
            </div>

            <?= audit_readable_details($detailsRaw) ?>

            <details class="audit-tech">
                <summary>Technical details</summary>
                <pre><?= e(json_encode([
                    'source' => $source,
                    'id' => $r['id'] ?? null,
                    'branch_id' => $r['branch_id'] ?? null,
                    'user_id' => $r['user_id'] ?? null,
                    'action' => $r['action'] ?? null,
                    'entity_type' => $r['entity_type'] ?? null,
                    'entity_id' => $r['entity_id'] ?? null,
                    'details' => $r['details'] ?? null,
                    'message' => $r['message'] ?? null,
                    'ip_address' => $r['ip_address'] ?? null,
                    'user_agent' => $r['user_agent'] ?? null,
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?></pre>
            </details>
        </section>
    <?php endforeach; ?>

    <?php if (!$rows): ?>
        <section class="card text-center muted">No audit or system activity records found for the selected filters.</section>
    <?php endif; ?>
</div>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
