<?php
if(PHP_SAPI !== 'cli'){ http_response_code(403); exit('Scheduled task is CLI-only.'); }
require dirname(__DIR__).'/includes/bootstrap.php';
ensure_continuation_schema();

// Queue continuation reminders for customers whose return visit is due soon.
try {
    $leadDays=(int)(scalar('SELECT COALESCE(MAX(CAST(setting_value AS UNSIGNED)),1) FROM settings WHERE setting_key="continuation_reminder_days"') ?: 1);
    $due=all('SELECT f.*,c.full_name,c.phone,s.name service_name FROM customer_service_continuations f JOIN customers c ON c.id=f.customer_id JOIN services s ON s.id=f.service_id WHERE f.status IN("planned","reminded") AND f.reminder_sent_at IS NULL AND f.due_date<=DATE_ADD(CURDATE(),INTERVAL ? DAY) AND c.phone IS NOT NULL AND c.phone<>"" LIMIT 100',[$leadDays]);
    foreach($due as $f){
        $msg='Hello '.$f['full_name'].', reminder: your continuation visit for '.$f['service_name'].' is due on '.$f['due_date'].'. Please reply to confirm your preferred time.';
        post_notification((int)$f['customer_id'],'whatsapp',$f['phone'],$msg,(int)$f['branch_id']);
        q('UPDATE customer_service_continuations SET status=IF(status="planned","reminded",status), reminder_sent_at=NOW(), updated_at=NOW() WHERE id=?',[$f['id']]);
    }
} catch(Throwable $e) {}

$rows=all('SELECT * FROM notifications WHERE status="queued" AND scheduled_at<=NOW() ORDER BY id LIMIT 100');
$sent=0; $pending=0;
foreach($rows as $n){
    if(($n['type']??'')==='system'){
        q('UPDATE notifications SET status="sent",sent_at=NOW(),provider_response="Delivered as internal system notification" WHERE id=?',[$n['id']]);
        log_activity('System notification processed','notification',$n['branch_id']);
        $sent++;
        continue;
    }
    // External delivery is intentionally left queued until an SMS/WhatsApp/email provider is configured.
    q('UPDATE notifications SET provider_response="External provider not configured; send manually from Notifications" WHERE id=?',[$n['id']]);
    $pending++;
}
echo $sent." system notification(s) processed; ".$pending." external notification(s) left queued for manual/provider delivery.\n";
