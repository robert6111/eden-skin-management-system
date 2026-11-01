<?php
require dirname(__DIR__).'/includes/bootstrap.php';
require_permission('appointments.view');
$bid=current_branch_id();
ensure_continuation_schema();

function continuation_create_appointment(array $row,int $branchId): int {
    $date=$row['due_date'];
    $time=$row['preferred_time'] ?: '09:00:00';
    $serviceId=(int)($row['continuation_service_id'] ?: $row['service_id']);
    $svc=one('SELECT id,price,duration_minutes,name FROM services WHERE id=? AND branch_id=? AND status="active"',[$serviceId,$branchId]);
    if(!$svc) throw new RuntimeException('Continuation service is not active or cannot be found.');
    $duration=max(1,(int)$svc['duration_minutes']);
    $start=new DateTime($date.' '.$time);
    $end=(clone $start)->modify('+'.$duration.' minutes');
    $staffId=(int)($row['staff_id'] ?? 0) ?: null;
    if($staffId){
        $over=(int)scalar('SELECT COUNT(*) FROM appointments WHERE branch_id=? AND staff_id=? AND appointment_date=? AND status NOT IN("cancelled","no_show","completed") AND start_time < ? AND end_time > ?',[$branchId,$staffId,$date,$end->format('H:i:s'),$time]);
        if($over>0) throw new RuntimeException('This staff member is already booked at the continuation time. Change the preferred time or staff.');
    }
    $no=next_code('APT','appointments','appointment_no');
    q('INSERT INTO appointments(branch_id,customer_id,appointment_no,appointment_date,start_time,end_time,staff_id,status,source,notes,created_by,created_at) VALUES(?,?,?,?,?,?,?,"booked","other",?,?,NOW())',[$branchId,$row['customer_id'],$no,$date,$time,$end->format('H:i:s'),$staffId,'Continuation visit from plan #'.$row['id'],$_SESSION['user_id']]);
    $appointmentId=(int)db()->lastInsertId();
    q('INSERT INTO appointment_services(appointment_id,service_id,price,duration_minutes,staff_id) VALUES(?,?,?,?,?)',[$appointmentId,$serviceId,$svc['price'],$duration,$staffId]);
    q('UPDATE customer_service_continuations SET status="booked", appointment_id=?, updated_at=NOW() WHERE id=? AND branch_id=?',[$appointmentId,$row['id'],$branchId]);
    if(($c=one('SELECT full_name,phone FROM customers WHERE id=?',[$row['customer_id']])) && $c['phone']){
        post_notification((int)$row['customer_id'],'whatsapp',$c['phone'],'Hello '.$c['full_name'].', your continuation appointment is booked for '.$date.' at '.substr($time,0,5).'.',$branchId);
    }
    audit('book','customer_service_continuations',(int)$row['id'],['appointment_id'=>$appointmentId]);
    log_activity('Continuation appointment booked: '.$no,'appointment',$branchId);
    return $appointmentId;
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    verify_csrf(); require_permission('appointments.manage'); $action=$_POST['_action']??'create';
    try{
        if($action==='create'){
            $customerId=(int)($_POST['customer_id']??0); $serviceId=(int)($_POST['service_id']??0); $contServiceId=(int)($_POST['continuation_service_id']??0) ?: $serviceId; $staffId=(int)($_POST['staff_id']??0) ?: null;
            $due=$_POST['due_date']??''; if(!$customerId||!$serviceId||!valid_date($due)) throw new RuntimeException('Customer, service and valid due date are required.');
            $pref=trim($_POST['preferred_time']??''); $pref=$pref?($pref.':00'):null;
            q('INSERT INTO customer_service_continuations(branch_id,customer_id,service_id,continuation_service_id,staff_id,original_service_date,due_date,preferred_time,status,notes,created_by,created_at) VALUES(?,?,?,?,?,CURDATE(),?,?,"planned",?,?,NOW())',[$bid,$customerId,$serviceId,$contServiceId,$staffId,$due,$pref,trim($_POST['notes']??''),$_SESSION['user_id']]);
            $id=(int)db()->lastInsertId();
            if($id>0 && ($c=one('SELECT full_name,phone FROM customers WHERE id=?',[$customerId])) && $c['phone'] && ($svc=one('SELECT name FROM services WHERE id=?',[$serviceId]))){
                $lead=max(0,(int)setting('continuation_reminder_days',1,$bid));
                $scheduled=date('Y-m-d 09:00:00',strtotime($due.' -'.$lead.' days'));
                if($scheduled<now()) $scheduled=now();
                $msg='Hello '.$c['full_name'].', reminder: your continuation visit for '.$svc['name'].' is due on '.$due.'. Please reply to confirm your preferred time.';
                q('INSERT INTO notifications(branch_id,customer_id,type,recipient,message,status,scheduled_at,created_at) VALUES(?,?,?,?,?,"queued",?,NOW())',[$bid,$customerId,'whatsapp',$c['phone'],$msg,$scheduled]);
            }
            audit('create','customer_service_continuations',$id); flash('success','Continuation plan created.');
        } elseif($action==='book'){
            $id=(int)$_POST['id']; $row=one('SELECT * FROM customer_service_continuations WHERE id=? AND branch_id=?',[$id,$bid]); if(!$row) throw new RuntimeException('Continuation not found.');
            $apptId=continuation_create_appointment($row,$bid); flash('success','Continuation booked as appointment #'.$apptId.'.');
        } elseif($action==='remind'){
            $id=(int)$_POST['id']; $row=one('SELECT f.*,c.full_name,c.phone,s.name service_name FROM customer_service_continuations f JOIN customers c ON c.id=f.customer_id JOIN services s ON s.id=f.service_id WHERE f.id=? AND f.branch_id=?',[$id,$bid]); if(!$row) throw new RuntimeException('Continuation not found.');
            if(!$row['phone']) throw new RuntimeException('Customer has no phone number.');
            $msg='Hello '.$row['full_name'].', reminder: your continuation visit for '.$row['service_name'].' is due on '.$row['due_date'].'. Please reply to confirm your preferred time.';
            post_notification((int)$row['customer_id'],'whatsapp',$row['phone'],$msg,$bid);
            q('UPDATE customer_service_continuations SET status=IF(status="planned","reminded",status), reminder_sent_at=NOW(), updated_at=NOW() WHERE id=? AND branch_id=?',[$id,$bid]);
            flash('success','WhatsApp reminder queued. Open Notifications to send it.'); audit('remind','customer_service_continuations',$id);
        } elseif($action==='status'){
            $id=(int)$_POST['id']; $status=$_POST['status']??'planned'; if(!in_array($status,['planned','reminded','booked','completed','cancelled','missed'],true)) throw new RuntimeException('Invalid status.');
            q('UPDATE customer_service_continuations SET status=?, updated_at=NOW() WHERE id=? AND branch_id=?',[$status,$id,$bid]); audit('update','customer_service_continuations',$id,['status'=>$status]); flash('success','Continuation status updated.');
        }
    }catch(Throwable $e){ flash('error',$e->getMessage()); }
    redirect('modules/continuations.php');
}

$status=$_GET['status']??'open';
$from=$_GET['from']??date('Y-m-d',strtotime('-7 days')); if(!valid_date($from)) $from=date('Y-m-d',strtotime('-7 days'));
$to=$_GET['to']??date('Y-m-d',strtotime('+30 days')); if(!valid_date($to)) $to=date('Y-m-d',strtotime('+30 days'));
$where=['f.branch_id=?','f.due_date BETWEEN ? AND ?']; $params=[$bid,$from,$to];
if($status==='open') $where[]='f.status IN ("planned","reminded","booked")';
elseif($status && $status!=='all'){ $where[]='f.status=?'; $params[]=$status; }
$rows=all('SELECT f.*,c.full_name customer,c.phone,s.name original_service,COALESCE(cs.name,s.name) continuation_service,st.full_name staff,a.appointment_no FROM customer_service_continuations f JOIN customers c ON c.id=f.customer_id JOIN services s ON s.id=f.service_id LEFT JOIN services cs ON cs.id=f.continuation_service_id LEFT JOIN staff st ON st.id=f.staff_id LEFT JOIN appointments a ON a.id=f.appointment_id WHERE '.implode(' AND ',$where).' ORDER BY f.due_date ASC,f.id DESC',$params);
$counts=continuation_due_counts($bid);
$title='Service Continuations'; $subtitle='Track customers who must return after a few days for service continuation, refill, review or maintenance.'; include dirname(__DIR__).'/includes/header.php';
?>
<div class="grid cols-3" style="margin-bottom:16px"><div class="card kpi"><small>Due Today</small><strong><?=e($counts['today'])?></strong></div><div class="card kpi"><small>Overdue</small><strong><?=e($counts['overdue'])?></strong></div><div class="card kpi"><small>Next 7 Days</small><strong><?=e($counts['upcoming'])?></strong></div></div>
<div class="toolbar"><form class="toolbar"><select name="status"><option value="open"<?=selected($status,'open')?>>Open</option><option value="all"<?=selected($status,'all')?>>All</option><?php foreach(['planned','reminded','booked','completed','cancelled','missed'] as $s):?><option value="<?=e($s)?>"<?=selected($status,$s)?>><?=e(ucfirst($s))?></option><?php endforeach;?></select><input type="date" name="from" value="<?=e($from)?>"><input type="date" name="to" value="<?=e($to)?>"><button class="btn light">Filter</button></form><span class="spacer"></span><?php if(can('appointments.manage')):?><a class="btn" href="?new=1">+ Add Continuation</a><?php endif;?></div>
<?php if(isset($_GET['new']) && can('appointments.manage')):?><section class="card" style="margin-bottom:16px"><h2>Add Manual Continuation</h2><form method="post"><?=csrf_field()?><input type="hidden" name="_action" value="create"><div class="form-grid"><div class="form-group"><label>Customer *</label><select name="customer_id" required><option value="">— Select —</option><?php foreach(customers_options() as $id=>$l):?><option value="<?=e($id)?>"<?=selected($_GET['customer_id']??'', $id)?>><?=e($l)?></option><?php endforeach;?></select></div><div class="form-group"><label>Original Service *</label><select name="service_id" required><option value="">— Select —</option><?php foreach(service_options() as $id=>$l):?><option value="<?=e($id)?>"><?=e($l)?></option><?php endforeach;?></select></div><div class="form-group"><label>Continuation Service</label><select name="continuation_service_id"><option value="">Same as original</option><?php foreach(service_options() as $id=>$l):?><option value="<?=e($id)?>"><?=e($l)?></option><?php endforeach;?></select></div><div class="form-group"><label>Preferred Staff</label><select name="staff_id"><option value="">Unassigned</option><?php foreach(staff_options() as $id=>$l):?><option value="<?=e($id)?>"><?=e($l)?></option><?php endforeach;?></select></div><div class="form-group"><label>Due Date *</label><input type="date" name="due_date" required value="<?=e(date('Y-m-d',strtotime('+7 days')))?>"></div><div class="form-group"><label>Preferred Time</label><input type="time" name="preferred_time" value="09:00"></div><div class="form-group full"><label>Notes</label><textarea name="notes" placeholder="Example: come back for review, refill, second treatment or wash-out."></textarea></div></div><div class="toolbar" style="margin-top:15px"><button class="btn">Save Continuation</button><a class="btn light" href="continuations.php">Cancel</a></div></form></section><?php endif;?>
<div class="table-wrap"><table><thead><tr><th>Due Date</th><th>Customer</th><th>Phone</th><th>Original Service</th><th>Continuation</th><th>Staff</th><th>Status</th><th>Appointment</th><th>Actions</th></tr></thead><tbody><?php foreach($rows as $r):?><tr><td><?=e($r['due_date'])?><?=($r['due_date']<today() && in_array($r['status'],['planned','reminded'],true))?' <span class="badge red">Overdue</span>':''?></td><td><a href="customer_view.php?id=<?=e($r['customer_id'])?>"><?=e($r['customer'])?></a></td><td><?=e($r['phone'])?></td><td><?=e($r['original_service'])?></td><td><?=e($r['continuation_service'])?></td><td><?=e($r['staff']?:'Unassigned')?></td><td><span class="<?=e(continuation_badge($r['status']))?>"><?=e($r['status'])?></span></td><td><?= $r['appointment_no'] ? '<a href="appointments.php?date='.e($r['due_date']).'">'.e($r['appointment_no']).'</a>' : '—' ?></td><td class="no-print"><?php if(can('appointments.manage')):?><form method="post" style="display:inline"><?=csrf_field()?><input type="hidden" name="_action" value="book"><input type="hidden" name="id" value="<?=e($r['id'])?>"><button class="btn small success" <?= $r['appointment_id']?'disabled':'' ?>>Book</button></form> <form method="post" style="display:inline"><?=csrf_field()?><input type="hidden" name="_action" value="remind"><input type="hidden" name="id" value="<?=e($r['id'])?>"><button class="btn small secondary">Remind</button></form> <form method="post" style="display:inline"><?=csrf_field()?><input type="hidden" name="_action" value="status"><input type="hidden" name="id" value="<?=e($r['id'])?>"><select name="status" onchange="this.form.submit()"><option value="">Status</option><?php foreach(['completed','cancelled','missed','planned'] as $s):?><option value="<?=e($s)?>"><?=e(ucfirst($s))?></option><?php endforeach;?></select></form><?php endif;?></td></tr><?php endforeach;?><?php if(!$rows):?><tr><td colspan="9" class="text-center muted">No continuation visits found for this filter.</td></tr><?php endif;?></tbody></table></div>
<?php include dirname(__DIR__).'/includes/footer.php'; ?>
