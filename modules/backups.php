<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
require_permission('users.manage');
$cfg = app_config();
$dir = dirname(__DIR__) . '/storage/backups';
if (!is_dir($dir))
    mkdir($dir, 0775, true);
function make_sql_dump(PDO $pdo): string
{
    $out = "SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\n";
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $t) {
        $create = $pdo->query('SHOW CREATE TABLE `' . $t . '`')->fetch(PDO::FETCH_ASSOC);
        $out .= "\nDROP TABLE IF EXISTS `$t`;\n" . $create['Create Table'] . ";\n";
        $rows = $pdo->query('SELECT * FROM `' . $t . '`')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $r) {
            $cols = array_map(fn($c) => '`' . $c . '`', array_keys($r));
            $vals = array_map(fn($v) => $v === null ? 'NULL' : $pdo->quote($v), array_values($r));
            $out .= 'INSERT INTO `' . $t . '` (' . implode(',', $cols) . ') VALUES(' . implode(',', $vals) . ');' . "\n";
        }
    }
    return $out . "SET FOREIGN_KEY_CHECKS=1;\n";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    if (($_POST['_action'] ?? '') === 'backup') {
        try {
            $name = 'backup_' . date('Ymd_His') . '.sql';
            $path = $dir . '/' . $name;
            file_put_contents($path, make_sql_dump(db()));
            q('INSERT INTO backups(file_name,file_size,backup_type,status,notes,created_by,created_at) VALUES(?,?,"manual","completed",?,?,NOW())', [$name, filesize($path), 'Manual backup', $_SESSION['user_id']]);
            flash('success', 'Backup created.');
        } catch (Throwable $e) {
            flash('error', $e->getMessage());
        }
        redirect('modules/backups.php');
    }
    if (($_POST['_action'] ?? '') === 'restore') {
        try {
            $file = basename($_POST['file_name']);
            $path = $dir . '/' . $file;
            if (!is_file($path))
                throw new RuntimeException('Backup file not found.');
            db()->exec(file_get_contents($path));
            flash('success', 'Backup restored. Sign in again if needed.');
        } catch (Throwable $e) {
            flash('error', $e->getMessage());
        }
        redirect('modules/backups.php');
    }
}
if (isset($_GET['download'])) {
    $file = basename($_GET['download']);
    $path = $dir . '/' . $file;
    if (!is_file($path))
        exit('File not found');
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="' . $file . '"');
    readfile($path);
    exit;
}
$rows = all('SELECT * FROM backups ORDER BY id DESC');
$title = 'Backup & Restore';
$subtitle = 'Manual backups and restore from backup files.';
include dirname(__DIR__) . '/includes/header.php'; ?>
<section class="card">
    <form method="post"><?= csrf_field() ?><input type="hidden" name="_action" value="backup"><button class="btn">Create
            Manual Backup</button></form>
    <p class="muted">Here you can create manual backups and restore from backup files.</p>
</section>
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>File</th>
                <th>Size</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody><?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= e($r['created_at']) ?></td>
                    <td><?= e($r['file_name']) ?></td>
                    <td><?= e(number_format($r['file_size'] / 1024, 1)) ?> KB</td>
                    <td><?= e($r['backup_type']) ?></td>
                    <td><a class="btn small light" href="?download=<?= e($r['file_name']) ?>">Download</a>
                        <form method="post" style="display:inline"><?= csrf_field() ?><input type="hidden" name="_action"
                                value="restore"><input type="hidden" name="file_name"
                                value="<?= e($r['file_name']) ?>"><button class="btn small danger"
                                data-confirm="Restore this backup? Current data will be replaced.">Restore</button></form>
                    </td>
                </tr><?php endforeach; ?>
        </tbody>
    </table>
</div><?php include dirname(__DIR__) . '/includes/footer.php'; ?>