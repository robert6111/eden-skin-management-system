<?php
function branches_default_business_id(): int {
    $id=(int)(scalar('SELECT id FROM businesses ORDER BY id LIMIT 1') ?: 0);
    if($id>0) return $id;
    q('INSERT INTO businesses(name,phone,email,address,currency,timezone) VALUES(?,?,?,?,?,?)',[
        'Eden Skin',
        '+255 700 000 000',
        'info@example.co.tz',
        'Mwanza, Tanzania',
        'TZS',
        'Africa/Dar_es_Salaam'
    ]);
    return (int)db()->lastInsertId();
}
$crud=[
    'table'=>'branches',
    'title'=>'Branch Management',
    'singular'=>'Branch',
    'permission'=>'branches.manage',
    'branch_scoped'=>false,
    'search'=>['name','code','address'],
    'fields'=>[
        'business_id'=>['form'=>false,'save'=>false],
        'name'=>['required'=>true],
        'code'=>['required'=>true],
        'phone'=>[],
        'email'=>['type'=>'email'],
        'address'=>[],
        'opening_time'=>['type'=>'time'],
        'closing_time'=>['type'=>'time'],
        'status'=>['type'=>'select','options'=>['active'=>'Active','inactive'=>'Inactive'],'default'=>'active']
    ],
    'defaults'=>['business_id'=>'branches_default_business_id'],
    'list'=>['code'=>'Code','name'=>'Branch','phone'=>'Phone','address'=>'Address','status'=>'Status']
];
require dirname(__DIR__).'/includes/crud.php';
