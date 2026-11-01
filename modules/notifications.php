<?php
$crud=[
 'table'=>'notifications',
 'title'=>'Customer Notifications',
 'subtitle'=>'Notification outbox. WhatsApp messages can be opened and sent manually; automatic SMS/WhatsApp/email delivery requires a configured provider.',
 'singular'=>'Notification',
 'permission'=>'notifications.manage',
 'search'=>['recipient','message','status'],
 'fields'=>[
  'customer_id'=>['type'=>'select','options'=>function(){return array_column(all('SELECT id,CONCAT(full_name," — ",COALESCE(phone,"")) label FROM customers WHERE branch_id=? ORDER BY full_name',[current_branch_id()]),'label','id');}],
  'type'=>['type'=>'select','options'=>['sms'=>'SMS','whatsapp'=>'WhatsApp','email'=>'Email','system'=>'System'],'default'=>'whatsapp'],
  'recipient'=>[],
  'subject'=>[],
  'message'=>['type'=>'textarea','full'=>true,'required'=>true],
  'status'=>['type'=>'select','options'=>['queued'=>'Queued','sent'=>'Sent','failed'=>'Failed','cancelled'=>'Cancelled'],'default'=>'queued'],
  'scheduled_at'=>['type'=>'datetime-local']
 ],
 'list'=>['type'=>'Channel','recipient'=>'Recipient','message'=>'Message','status'=>'Status','scheduled_at'=>'Scheduled','sent_at'=>'Sent'],
 'row_actions'=>function($r){
    if(($r['type']??'')==='whatsapp' && !empty($r['recipient'])){
        $href=whatsapp_url($r['recipient'],$r['message']??'');
        return '<a class="btn small success" target="_blank" href="'.e($href).'">Open WhatsApp</a> ';
    }
    return '';
 }
];
require dirname(__DIR__).'/includes/crud.php';
