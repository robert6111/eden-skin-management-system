<?php
require __DIR__.'/includes/bootstrap.php'; if(is_logged_in())redirect('dashboard.php');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $username=trim($_POST['username']??''); $password=$_POST['password']??'';
 $u=one('SELECT * FROM users WHERE username=? AND status="active"',[$username]);
 if($u && password_verify($password,$u['password_hash'])){ login_user($u); q('UPDATE users SET last_login_at=NOW() WHERE id=?',[$u['id']]); audit('login','user',(int)$u['id']); redirect('dashboard.php'); }
 $error='Invalid username or password.';
}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="icon" type="image/png" href="<?=url('assets/img/favicon.png')?>"><link rel="shortcut icon" type="image/png" href="<?=url('assets/img/favicon.png')?>"><link rel="stylesheet" href="<?=url('assets/css/app.css')?>"><title>Sign in</title></head><body class="login-page"><form method="post" class="login-card"><?=csrf_field()?><h1>Eden Skin</h1><p class="muted">Skin Beauty Aesthetics</p><?php if($error):?><div class="alert error"><?=e($error)?></div><?php endif;?><?php if(isset($_GET['expired'])):?><div class="alert error">Your session expired. Please sign in again.</div><?php endif;?><?php if(isset($_GET['nobranch'])):?><div class="alert error">No active branch is assigned to your account. Please sign in again or contact the administrator.</div><?php endif;?><div class="form-group"><label>Username</label><input name="username" required autofocus></div><div class="form-group" style="margin-top:12px"><label>Password</label><input type="password" name="password" required></div><button class="btn" style="width:100%;margin-top:18px">Sign in</button><p class="text-center muted" style="margin-bottom:0">Need setup? <a href="install.php">Run installer</a></p></form></body></html>
