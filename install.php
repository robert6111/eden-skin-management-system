<?php
$root=__DIR__; $lock=$root.'/storage/installed.lock'; $done=is_file($lock) && is_file($root.'/config.php'); $error=''; $success='';
function run_sql(PDO $pdo,string $sql): void {
    $sql=preg_replace('/^\s*--.*$/m','',$sql);
    $parts=preg_split('/;\s*(?:\r?\n|$)/',$sql);
    foreach($parts as $stmt){ $stmt=trim($stmt); if($stmt!=='') $pdo->exec($stmt); }
}
if($_SERVER['REQUEST_METHOD']==='POST' && !$done){
 try{
  foreach([$root.'/storage',$root.'/storage/backups',$root.'/storage/cache',$root.'/storage/logs',$root.'/storage/uploads',$root.'/storage/uploads/documents'] as $dir){ if(!is_dir($dir) && !mkdir($dir,0775,true) && !is_dir($dir)) throw new RuntimeException('Could not create storage directory: '.basename($dir)); }
  $host=trim($_POST['db_host']??'127.0.0.1'); $port=trim($_POST['db_port']??'3306'); $name=preg_replace('/[^a-zA-Z0-9_]/','',$_POST['db_name']??'salon_spa_tz');
  $user=trim($_POST['db_user']??'root'); $pass=$_POST['db_pass']??''; $business=trim($_POST['business_name']??'Eden Skin'); $branch=trim($_POST['branch_name']??'Main Branch');
  $owner=trim($_POST['owner_name']??'System Owner'); $phone=trim($_POST['owner_phone']??''); $username=trim($_POST['username']??'admin'); $password=$_POST['password']??'';
  if(strlen($password)<8) throw new RuntimeException('Owner password must contain at least 8 characters.');
  $pdo=new PDO("mysql:host=$host;port=$port;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>false]);
  $pdo->exec("CREATE DATABASE IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"); $pdo->exec("USE `$name`");
  run_sql($pdo,file_get_contents($root.'/database/schema.sql')); run_sql($pdo,file_get_contents($root.'/database/seed.sql'));
  $pdo->prepare('UPDATE businesses SET name=?,phone=? WHERE id=1')->execute([$business,$phone]);
  $pdo->prepare('UPDATE branches SET name=?,phone=? WHERE id=1')->execute([$branch,$phone]);
  $pdo->prepare('UPDATE settings SET setting_value=? WHERE branch_id=1 AND setting_key="business_name"')->execute([$business]);
  $pdo->prepare('UPDATE settings SET setting_value=? WHERE branch_id=1 AND setting_key="business_phone"')->execute([$phone]);
  $pdo->prepare('UPDATE settings SET setting_value=? WHERE branch_id=1 AND setting_key="business_tagline"')->execute(['Skin Beauty Aesthetics']);
  $emp='EMP-001'; $pdo->prepare('INSERT INTO staff(branch_id,employee_no,full_name,phone,role_title,salary,employment_date,status) VALUES(1,?,?,?,?,0,CURDATE(),"active")')->execute([$emp,$owner,$phone,'Owner']); $staffId=(int)$pdo->lastInsertId();
  $hash=password_hash($password,PASSWORD_DEFAULT); $pdo->prepare('INSERT INTO users(branch_id,staff_id,role_id,username,password_hash,status) VALUES(1,?,1,?,? ,"active")')->execute([$staffId,$username,$hash]);
  $base=rtrim(str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']??'')),'/'); if($base==='.')$base='';
  $config="<?php\nreturn ".var_export(['db'=>['host'=>$host,'port'=>$port,'name'=>$name,'user'=>$user,'pass'=>$pass,'charset'=>'utf8mb4'],'app'=>['name'=>'Eden Skin','base_url'=>$base,'timezone'=>'Africa/Dar_es_Salaam','currency'=>'TZS','session_timeout'=>3600,'debug'=>false]],true).";\n";
  if(file_put_contents($root.'/config.php',$config)===false) throw new RuntimeException('Could not write config.php. Check folder permissions.');
  file_put_contents($lock,date('c')."\n"); $success='Installation completed successfully.'; $done=true;
 }catch(Throwable $e){ $error=$e->getMessage(); }
}
?><!doctype html><html><head><link rel="icon" type="image/png" href="assets/img/favicon.png"><link rel="shortcut icon" type="image/png" href="assets/img/favicon.png"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Install Eden Skin</title><link rel="stylesheet" href="assets/css/app.css"></head><body class="login-page"><div class="login-card" style="width:min(760px,94vw)"><h1>Eden Skin</h1><p class="muted">Skin Beauty Aesthetics — Installation</p><?php if($error):?><div class="alert error"><?=htmlspecialchars($error)?></div><?php endif;?><?php if($done):?><div class="alert success"><?=$success?:'This system is already installed.'?></div><p>The installer is locked. Sign in with the Owner account created during setup.</p><a class="btn" href="login.php">Go to sign in</a><?php else:?><form method="post"><h3>Database</h3><div class="form-grid"><div class="form-group"><label>MySQL Host</label><input name="db_host" value="127.0.0.1" required></div><div class="form-group"><label>Port</label><input name="db_port" value="3306" required></div><div class="form-group"><label>Database Name</label><input name="db_name" value="salon_spa_tz" required></div><div class="form-group"><label>MySQL User</label><input name="db_user" value="root" required></div><div class="form-group full"><label>MySQL Password (blank on default XAMPP)</label><input type="password" name="db_pass"></div></div><h3>Business</h3><div class="form-grid"><div class="form-group"><label>Business Name</label><input name="business_name" value="Eden Skin" required></div><div class="form-group"><label>Branch Name</label><input name="branch_name" value="Main Branch" required></div></div><h3>Owner Account</h3><div class="form-grid"><div class="form-group"><label>Owner Full Name</label><input name="owner_name" required></div><div class="form-group"><label>Phone</label><input name="owner_phone"></div><div class="form-group"><label>Username</label><input name="username" value="admin" required></div><div class="form-group"><label>Password (minimum 8 characters)</label><input type="password" name="password" required minlength="8"></div></div><button class="btn" style="margin-top:18px">Install Complete System</button></form><?php endif;?></div></body></html>
