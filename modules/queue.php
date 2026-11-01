<?php
require dirname(__DIR__).'/includes/bootstrap.php';
require_permission('queue.manage');
$bid=current_branch_id();
if($_SERVER['REQUEST_METHOD']==='POST'){
    verify_csrf();
    $id=(int)($_POST['id']??0);
    $action=$_POST['_action']??'';
    $qrow=one('SELECT * FROM queues WHERE id=? AND branch_id=?',[$id,$bid]);
    if(!$qrow){ flash('error','Queue record not found.'); redirect('modules/queue.php'); }
    $map=['call'=>'called','start'=>'in_service','complete'=>'completed','cancel'=>'cancelled','noshow'=>'no_show'];
    if(isset($map[$action])){
        $status=$map[$action];
        if($action==='call') q('UPDATE queues SET status="called",called_at=NOW() WHERE id=? AND branch_id=?',[$id,$bid]);
        elseif($action==='start') q('UPDATE queues SET status="in_service",service_started_at=NOW() WHERE id=? AND branch_id=?',[$id,$bid]);
        elseif($action==='complete') q('UPDATE queues SET status="completed",completed_at=NOW() WHERE id=? AND branch_id=?',[$id,$bid]);
        else q('UPDATE queues SET status=? WHERE id=? AND branch_id=?',[$status,$id,$bid]);
        audit('update','queues',$id,['status'=>$status]);
        log_activity('Queue #'.$qrow['queue_number'].' marked '.$status,'queue',$bid);
    }
    redirect('modules/queue.php');
}
$date=$_GET['date']??today(); if(!valid_date($date))$date=today();
$rows=all('SELECT q.*,c.full_name customer,c.phone,s.name service,st.full_name staff,TIMESTAMPDIFF(MINUTE,q.checked_in_at,NOW()) waiting_minutes FROM queues q LEFT JOIN customers c ON c.id=q.customer_id LEFT JOIN services s ON s.id=q.service_id LEFT JOIN staff st ON st.id=q.staff_id WHERE q.branch_id=? AND q.queue_date=? ORDER BY q.queue_number',[$bid,$date]);
$title='Queue Management'; $subtitle='Current customer, next customer, waiting time and completed queue.'; include dirname(__DIR__).'/includes/header.php';
?>
<div class="toolbar"><form><input type="date" name="date" value="<?=e($date)?>" data-autosubmit></form><a class="btn" href="walkins.php">+ Add Walk-in</a></div>
<div class="grid cols-3"><?php foreach(['waiting'=>'Waiting','called'=>'Called','in_service'=>'In Service','completed'=>'Completed','cancelled'=>'Cancelled','no_show'=>'No Show'] as $status=>$label):?><section class="card"><h2><?=e($label)?></h2><?php $any=false; foreach($rows as $r): if($r['status']!==$status)continue; $any=true;?><div class="card queue-card" style="box-shadow:none"><div><div class="queue-number">#<?=e($r['queue_number'])?></div><strong><?=e($r['customer']??'Walk-in Customer')?></strong><br><small><?=e($r['service']??'Service not selected')?> • <?=e($r['staff']??'Unassigned')?></small><br><small>Waiting: <?=e(max(0,(int)$r['waiting_minutes']))?> min</small></div><div class="text-right"><?php if(!in_array($status,['completed','cancelled','no_show'],true)):?><form method="post"><?=csrf_field()?><input type="hidden" name="id" value="<?=e($r['id'])?>"><?php if($status==='waiting'):?><button name="_action" value="call" class="btn small secondary">Call</button><?php endif;?><?php if(in_array($status,['waiting','called'],true)):?><button name="_action" value="start" class="btn small">Start</button><?php endif;?><button name="_action" value="complete" class="btn small success">Complete</button><button name="_action" value="noshow" class="btn small light">No Show</button><button name="_action" value="cancel" class="btn small danger">Cancel</button></form><?php endif;?><a class="btn small light" href="pos.php?queue_id=<?=e($r['id'])?>">POS</a></div></div><?php endforeach; if(!$any):?><p class="muted">No customers.</p><?php endif;?></section><?php endforeach;?></div><?php include dirname(__DIR__).'/includes/footer.php'; ?>