<?php
if(PHP_SAPI !== 'cli'){ http_response_code(403); exit('Scheduled task is CLI-only.'); }
require dirname(__DIR__).'/includes/bootstrap.php';
$dir=dirname(__DIR__).'/storage/backups'; if(!is_dir($dir))mkdir($dir,0775,true);
function worker_dump(PDO $pdo): string { $out="SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\n"; foreach($pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN) as $t){$c=$pdo->query('SHOW CREATE TABLE `'.$t.'`')->fetch(PDO::FETCH_ASSOC);$out.="\nDROP TABLE IF EXISTS `$t`;\n".$c['Create Table'].";\n";foreach($pdo->query('SELECT * FROM `'.$t.'`')->fetchAll(PDO::FETCH_ASSOC) as $r){$cols=array_map(fn($x)=>'`'.$x.'`',array_keys($r));$vals=array_map(fn($v)=>$v===null?'NULL':$pdo->quote($v),array_values($r));$out.='INSERT INTO `'.$t.'` ('.implode(',',$cols).') VALUES('.implode(',',$vals).');'."\n";}} return $out."SET FOREIGN_KEY_CHECKS=1;\n";}
$name='auto_backup_'.date('Ymd_His').'.sql'; $path=$dir.'/'.$name; file_put_contents($path,worker_dump(db())); q('INSERT INTO backups(file_name,file_size,backup_type,status,notes,created_at) VALUES(?,?,"automatic","completed","Scheduled backup",NOW())',[$name,filesize($path)]); echo "Backup created: $name\n";
