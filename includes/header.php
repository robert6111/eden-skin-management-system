<?php
require_login(); $u=current_user(); $title=$title??'Dashboard';
function nav_file_available(string $href): bool {
    if(preg_match('~^https?://~',$href)) return true;
    return is_file(dirname(__DIR__).'/'.ltrim($href,'/'));
}
function current_rel_script_for_nav(): string {
    $script=str_replace('\\','/',$_SERVER['SCRIPT_NAME']??'');
    $base=(string)(app_config()['app']['base_url']??'');
    if(preg_match('~^https?://~i',$base)) $base=(string)(parse_url($base,PHP_URL_PATH)??'');
    $base=rtrim(str_replace('\\','/',$base),'/');
    if($base!=='' && str_starts_with($script,$base.'/')) $script=substr($script,strlen($base)+1);
    return ltrim($script,'/');
}
$navGroups=[
 'Main'=>[
  ['dashboard.php','Dashboard','dashboard.view'],
  ['modules/appointments.php','Appointments','appointments.view'],
  ['modules/continuations.php','Service Continuations','appointments.view'],
  ['modules/booking_link.php','Send Booking Link','appointments.manage'],
  ['modules/walkins.php','Walk-ins','queue.manage'],
  ['modules/queue.php','Queue','queue.manage'],
  ['modules/pos.php','POS / Sales','sales.create'],
  ['modules/customers.php','Customers','customers.view'],
 ],
 'Services & Stock'=>[
  ['modules/services.php','Services','services.manage'],
  ['modules/service_consumption.php','Product Consumption','services.manage'],
  ['modules/packages.php','Packages','services.manage'],
  ['modules/inventory.php','Inventory','inventory.view'],
  ['modules/purchases.php','Purchases','purchases.manage'],
  ['modules/suppliers.php','Suppliers','suppliers.manage'],
 ],
 'Business'=>[
  ['modules/expenses.php','Expenses','expenses.manage'],
  ['modules/staff.php','Staff','staff.view'],
  ['modules/commissions.php','Commissions','commissions.view'],
  ['modules/equipment.php','Equipment','equipment.manage'],
  ['modules/reports.php','Reports','reports.view'],
  ['modules/notifications.php','Notifications','notifications.manage'],
 ],
 'Control'=>[
  ['modules/audit.php','Audit Log','audit.view'],
  ['modules/settings.php','Settings','settings.manage'],
 ],
 'Administration'=>[
  ['modules/users.php','Users & Roles','users.manage'],
  ['modules/branches.php','Branches','users.manage'],
  ['modules/backups.php','Backup & Restore','users.manage'],
  ['modules/imports.php','Import / Export','users.manage'],
 ],
];
$current=current_rel_script_for_nav();
$hasSearch=nav_file_available('modules/search.php');
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e($title)?> — <?=e(app_config()['app']['name'])?></title><link rel="icon" type="image/png" href="<?=url('assets/img/favicon.png')?>"><link rel="shortcut icon" type="image/png" href="<?=url('assets/img/favicon.png')?>"><link rel="stylesheet" href="<?=url('assets/css/app.css')?>"></head><body>
<header class="topbar"><button class="menu-btn" data-toggle-menu>☰</button><div class="brand"><span class="brand-mark">S</span><div><strong><?=e(setting('business_name',app_config()['app']['name']))?></strong><small><?=e($u['branch_name']??'Main Branch')?></small></div></div><?php if($hasSearch):?><form class="global-search" action="<?=url('modules/search.php')?>"><input name="q" placeholder="Search customer, invoice, product…"></form><?php else:?><div class="global-search"></div><?php endif;?><div class="userbox"><span><?=e($u['staff_name']?:$u['username'])?></span><small><?=e($u['role_name'])?></small><a href="<?=url('logout.php')?>">Logout</a></div></header>
<div class="layout"><aside class="sidebar" id="sidebar"><nav><?php foreach($navGroups as $group=>$items): $visible=[]; foreach($items as $item){ [$href,$label,$perm]=$item; if(nav_file_available($href) && can($perm)) $visible[]=$item; } if(!$visible) continue; if($group!=='Main'): ?><div class="nav-heading"><?=e($group)?></div><?php endif; foreach($visible as [$href,$label,$perm]): ?><a href="<?=url($href)?>" class="<?=$current===$href?'active':''?>"><?=e($label)?></a><?php endforeach; endforeach; ?></nav></aside><main class="content"><div class="page-head"><div><h1><?=e($title)?></h1><?php if(!empty($subtitle)):?><p><?=e($subtitle)?></p><?php endif;?></div></div>
<?php if($m=flash('success')):?><div class="alert success"><?=e($m)?></div><?php endif;?><?php if($m=flash('error')):?><div class="alert error"><?=e($m)?></div><?php endif;?>
