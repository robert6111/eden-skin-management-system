<?php
if(!isset($crud)) exit('CRUD configuration missing.');
require_once dirname(__DIR__).'/includes/bootstrap.php';
$viewPerm=$crud['view_permission']??$crud['permission']; require_permission($viewPerm);
$table=$crud['table']; $bid=current_branch_id(); $branchScoped=$crud['branch_scoped']??true; $pk=$crud['pk']??'id';
$fields=$crud['fields']; $isReadOnly=$crud['readonly']??false;
function crud_options(array $f): array { if(isset($f['options'])) return is_callable($f['options'])?($f['options'])():$f['options']; if(isset($f['options_sql'])){ $rows=all($f['options_sql'][0],$f['options_sql'][1]??[]); $out=[]; foreach($rows as $r)$out[$r['id']]=$r['label']; return $out;} return []; }
function crud_current_path(): string {
 $script=str_replace('\\','/',$_SERVER['SCRIPT_NAME']??'');
 $base=(string)(app_config()['app']['base_url']??'');
 if(preg_match('~^https?://~i',$base)) $base=(string)(parse_url($base,PHP_URL_PATH)??'');
 $base=rtrim(str_replace('\\','/',$base),'/');
 if($base!=='' && str_starts_with($script,$base.'/')) $script=substr($script,strlen($base)+1);
 elseif($base!=='' && $script===$base) $script='';
 return ltrim($script,'/');
}
$crudPath=crud_current_path();
if($_SERVER['REQUEST_METHOD']==='POST'){
 require_permission($crud['permission']); verify_csrf();
 $action=$_POST['_action']??'save';
 if($action==='delete'){
  if($isReadOnly) throw new RuntimeException('Read only.'); $id=(int)($_POST['id']??0); $where="$pk=?"; $params=[$id]; if($branchScoped&&!can('branches.view_all')){$where.=' AND branch_id=?';$params[]=$bid;}
  q("DELETE FROM `$table` WHERE $where",$params); audit('delete',$table,$id); flash('success',$crud['singular'].' deleted.'); redirect($crudPath);
 }
 if($isReadOnly) throw new RuntimeException('Read only.');
 $id=(int)($_POST[$pk]??0); $data=[];
 foreach($fields as $name=>$f){
  if(($f['readonly']??false) || ($f['form']??true)===false || ($f['save']??true)===false) continue;
  if(($f['type']??'text')==='checkbox') $val=isset($_POST[$name])?1:0; else $val=$_POST[$name]??null;
  if(is_string($val))$val=trim($val); if($val==='' && ($f['nullable']??true))$val=null;
  if(($f['required']??false) && ($val===null||$val==='')){flash('error',($f['label']??$name).' is required.'); redirect($id ? $crudPath.'?edit='.$id : $crudPath.'?new=1');}
  if(($f['type']??'')==='password'){ if(!$val)continue; $val=password_hash($val,PASSWORD_DEFAULT); }
  $data[$name]=$val;
 }
 if(isset($crud['before_save'])) $data=($crud['before_save'])($data,$id);
 if(!$id){ if($branchScoped && !array_key_exists('branch_id',$data))$data['branch_id']=$bid; if(isset($crud['defaults']))foreach($crud['defaults'] as $k=>$v)if(!array_key_exists($k,$data))$data[$k]=is_callable($v)?$v():$v;
  $cols=array_keys($data);$marks=array_fill(0,count($cols),'?'); q('INSERT INTO `'.$table.'` (`'.implode('`,`',$cols).'`) VALUES('.implode(',',$marks).')',array_values($data));$id=(int)db()->lastInsertId();audit('create',$table,$id,$data);
 } else { $set=[];$params=[];foreach($data as $k=>$v){$set[]="`$k`=?";$params[]=$v;}$where="$pk=?";$params[]=$id;if($branchScoped&&!can('branches.view_all')){$where.=' AND branch_id=?';$params[]=$bid;}q('UPDATE `'.$table.'` SET '.implode(',',$set)." WHERE $where",$params);audit('update',$table,$id,$data); }
 if(isset($crud['after_save'])) ($crud['after_save'])($id,$data); flash('success',$crud['singular'].' saved successfully.');redirect($crudPath);
}
$edit=null;if(!empty($_GET['edit'])){$id=(int)$_GET['edit'];$where="$pk=?";$p=[$id];if($branchScoped&&!can('branches.view_all')){$where.=' AND branch_id=?';$p[]=$bid;}$edit=one("SELECT * FROM `$table` WHERE $where",$p);}
$qterm=trim($_GET['q']??''); $where=[];$params=[];if($branchScoped&&!can('branches.view_all')){$where[]='branch_id=?';$params[]=$bid;}if($qterm && !empty($crud['search'])){$parts=[];foreach($crud['search'] as $col){$parts[]="`$col` LIKE ?";$params[]="%$qterm%";}$where[]='('.implode(' OR ',$parts).')';}
if(isset($crud['list_sql'])){
    $sql=is_callable($crud['list_sql'])?($crud['list_sql'])($qterm):$crud['list_sql'];
    $params=is_callable($crud['list_params']??null)?($crud['list_params'])($qterm):($crud['list_params']??[]);
} else {
    $sql="SELECT * FROM `$table`".($where?' WHERE '.implode(' AND ',$where):'')." ORDER BY `$pk` DESC";
}
$rows=all($sql,$params);
/* Safety net: custom list_sql pages must also search. If a module forgot to wire the
   SQL search, this filters the already-loaded rows so the visible search bar still works. */
if(isset($crud['list_sql']) && $qterm!==''){
    $needle=mb_strtolower($qterm);
    $rows=array_values(array_filter($rows,function($row) use ($needle){
        foreach($row as $value){
            if($value!==null && mb_stripos((string)$value,$needle)!==false) return true;
        }
        return false;
    }));
}
$title=$crud['title'];$subtitle=$crud['subtitle']??'';include dirname(__DIR__).'/includes/header.php';
?>
<div class="toolbar"><form><input name="q" value="<?=e($qterm)?>" placeholder="Search…"><button class="btn light">Search</button></form><span class="spacer"></span><?php if(!$isReadOnly&&can($crud['permission'])):?><a class="btn" href="?new=1">+ Add <?=e($crud['singular'])?></a><?php endif;?><?php if(!empty($crud['extra_toolbar'])) echo $crud['extra_toolbar']; ?></div>
<?php if(($edit||isset($_GET['new']))&&!$isReadOnly):?><section class="card" style="margin-bottom:16px"><h2><?=$edit?'Edit':'Add'?> <?=e($crud['singular'])?></h2><form method="post" enctype="multipart/form-data"><?=csrf_field()?><input type="hidden" name="<?=$pk?>" value="<?=e($edit[$pk]??'')?>"><div class="form-grid"><?php foreach($fields as $name=>$f): if(($f['form']??true)===false)continue;$type=$f['type']??'text';$val=$edit[$name]??($f['default']??'');?><div class="form-group <?=($f['full']??false)?'full':''?>"><label><?=e($f['label']??ucwords(str_replace('_',' ',$name)))?><?=($f['required']??false)?' *':''?></label><?php if($type==='textarea'):?><textarea name="<?=e($name)?>" <?=($f['required']??false)?'required':''?>><?=e($val)?></textarea><?php elseif($type==='select'):?><select name="<?=e($name)?>" <?=($f['required']??false)?'required':''?>><option value="">— Select —</option><?php foreach(crud_options($f) as $ov=>$ol):?><option value="<?=e($ov)?>"<?=selected($val,$ov)?>><?=e($ol)?></option><?php endforeach;?></select><?php elseif($type==='checkbox'):?><label><input type="checkbox" name="<?=e($name)?>" value="1"<?=checked($val)?>> <?=e($f['check_label']??'Yes')?></label><?php else:?><input type="<?=e($type)?>" name="<?=e($name)?>" value="<?=e($type==='password'?'':$val)?>" <?=isset($f['step'])?'step="'.e($f['step']).'"':''?> <?=isset($f['min'])?'min="'.e($f['min']).'"':''?> <?=($f['required']??false)&&!($edit&&$type==='password')?'required':''?>><?php endif;?></div><?php endforeach;?></div><div class="toolbar" style="margin-top:15px"><button class="btn">Save <?=e($crud['singular'])?></button><a class="btn light" href="<?=e(url($crudPath))?>">Cancel</a></div></form></section><?php endif;?>
<div class="table-wrap"><table><thead><tr><?php foreach($crud['list'] as $col=>$label):?><th><?=e($label)?></th><?php endforeach;?><th>Actions</th></tr></thead><tbody><?php foreach($rows as $r):?><tr><?php foreach($crud['list'] as $col=>$label):$v=$r[$col]??'';$f=$fields[$col]??null;if(isset($crud['format'][$col]))$v=($crud['format'][$col])($v,$r);elseif($f&&($f['type']??'')==='select')$v=crud_options($f)[$v]??$v;elseif(((($f['type']??'')==='number') && str_contains($col,'price')) || str_contains($col,'amount') || $col==='salary')$v=money($v);?><td><?=($crud['raw'][$col]??false)?$v:e($v)?></td><?php endforeach;?><td><?php if(!empty($crud['row_actions'])) echo ($crud['row_actions'])($r); ?><?php if(!$isReadOnly&&can($crud['permission'])):?><a class="btn small light" href="?edit=<?=e($r[$pk])?>">Edit</a> <form method="post" style="display:inline"><?=csrf_field()?><input type="hidden" name="_action" value="delete"><input type="hidden" name="id" value="<?=e($r[$pk])?>"><button class="btn small danger" data-confirm="Delete this record?">Delete</button></form><?php endif;?></td></tr><?php endforeach;?><?php if(!$rows):?><tr><td colspan="<?=count($crud['list'])+1?>" class="text-center muted">No records found.</td></tr><?php endif;?></tbody></table></div>
<?php include dirname(__DIR__).'/includes/footer.php'; ?>
