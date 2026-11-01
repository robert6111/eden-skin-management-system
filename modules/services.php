<?php
require_once dirname(__DIR__).'/includes/bootstrap.php';
require_permission('services.manage');
ensure_continuation_schema();
$crud=[
 'table'=>'services',
 'title'=>'Services Management',
 'subtitle'=>'Create services, prices, durations, commission rules and continuation follow-up rules.',
 'singular'=>'Service',
 'permission'=>'services.manage',
 'search'=>['name','description'],
 'fields'=>[
  'category_id'=>[
   'label'=>'Category','type'=>'select','required'=>true,
   'options'=>function(){
    $rows=all('SELECT id,name label FROM service_categories WHERE (branch_id=? OR branch_id IS NULL) AND status="active" ORDER BY name',[current_branch_id()]);
    $out=[]; foreach($rows as $r){ $out[$r['id']]=$r['label']; } return $out;
   }
  ],
  'name'=>['required'=>true],
  'description'=>['type'=>'textarea','full'=>true],
  'duration_minutes'=>['label'=>'Duration (minutes)','type'=>'number','min'=>1,'required'=>true,'default'=>30],
  'price'=>['type'=>'number','step'=>'0.01','min'=>0,'required'=>true],
  'commission_type'=>['type'=>'select','options'=>['none'=>'None','percentage'=>'Percentage','fixed'=>'Fixed Amount'],'default'=>'percentage'],
  'commission_value'=>['type'=>'number','step'=>'0.01','default'=>0],
  'status'=>['type'=>'select','options'=>['active'=>'Active','inactive'=>'Inactive'],'default'=>'active'],
  'continuation_required'=>['label'=>'Needs continuation visit','type'=>'checkbox','check_label'=>'Create follow-up automatically after this service is paid'],
  'continuation_after_days'=>['label'=>'Continuation after days','type'=>'number','min'=>0,'default'=>0],
  'continuation_service_id'=>[
   'label'=>'Continuation service','type'=>'select','nullable'=>true,
   'options'=>function(){
    $rows=all('SELECT id,name label FROM services WHERE branch_id=? AND status="active" ORDER BY name',[current_branch_id()]);
    $out=[]; foreach($rows as $r){ $out[$r['id']]=$r['label']; } return $out;
   }
  ],
  'continuation_message'=>['label'=>'Continuation note / message','type'=>'textarea','full'=>true],
 ],
 'before_save'=>function($d,$id){
    $d['continuation_required']=(int)($d['continuation_required'] ?? 0);
    $d['continuation_after_days']=max(0,(int)($d['continuation_after_days'] ?? 0));
    if(!$d['continuation_required']){
        $d['continuation_after_days']=0;
        $d['continuation_service_id']=null;
        $d['continuation_message']=null;
    }
    if(($d['continuation_service_id'] ?? null)==='') $d['continuation_service_id']=null;
    $d['updated_at']=now();
    return $d;
 },
 'list_sql'=>function($qterm=null){
    $where='WHERE s.branch_id=?';
    if(trim((string)$qterm)!=='') $where.=' AND (s.name LIKE ? OR s.description LIKE ? OR sc.name LIKE ? OR cs.name LIKE ?)';
    return 'SELECT s.*,sc.name category_name,COALESCE(cs.name,s.name) continuation_service_name FROM services s LEFT JOIN service_categories sc ON sc.id=s.category_id LEFT JOIN services cs ON cs.id=s.continuation_service_id '.$where.' ORDER BY s.id DESC';
 },
 'list_params'=>function($qterm=null){ $params=[current_branch_id()]; if(trim((string)$qterm)!==''){ $like='%'.trim((string)$qterm).'%'; array_push($params,$like,$like,$like,$like); } return $params; },
 'list'=>['name'=>'Service','category_name'=>'Category','duration_minutes'=>'Minutes','price'=>'Price','commission_type'=>'Commission Type','continuation_required'=>'Continuation','continuation_after_days'=>'After Days','status'=>'Status'],
 'format'=>[
    'continuation_required'=>fn($v,$r)=>$v?'Yes':'No',
    'continuation_after_days'=>fn($v,$r)=>$r['continuation_required'] ? ($v.' days') : '—'
 ],
 'extra_toolbar'=>'<a class="btn secondary" href="service_categories.php">Categories</a> <a class="btn secondary" href="service_consumption.php">Product Consumption</a> <a class="btn secondary" href="continuations.php">Service Continuations</a>'
];
require dirname(__DIR__).'/includes/crud.php';
