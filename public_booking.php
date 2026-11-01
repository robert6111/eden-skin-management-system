<?php
require __DIR__.'/includes/bootstrap.php';

function public_booking_form_token(int $branchId): string {
    if(empty($_SESSION['_public_booking_tokens'][$branchId])){
        $_SESSION['_public_booking_tokens'][$branchId]=bin2hex(random_bytes(32));
    }
    return (string)$_SESSION['_public_booking_tokens'][$branchId];
}
function public_booking_fingerprint(int $branchId,string $token,string $phone,string $date,string $time,?int $staffId,array $serviceIds): string {
    sort($serviceIds,SORT_NUMERIC);
    return hash('sha256',json_encode([$branchId,$token,$phone,$date,$time,$staffId,$serviceIds],JSON_UNESCAPED_SLASHES));
}
function finish_public_booking(int $branchId,string $appointmentNo,string $message): never {
    $_SESSION['_public_booking_done_no']=$appointmentNo;
    $_SESSION['_public_booking_done_message']=$message;
    unset($_SESSION['_public_booking_tokens'][$branchId]);
    header('Location: public_booking_done.php?branch='.(int)$branchId,true,303);
    exit;
}

$branchId=(int)($_GET['branch']??$_POST['branch_id']??1);
$branch=one('SELECT b.*,bs.name business_name FROM branches b JOIN businesses bs ON bs.id=b.business_id WHERE b.id=? AND b.status="active"',[$branchId]);
if(!$branch){ http_response_code(404); exit('Booking branch not found.'); }
$error='';
$formToken=public_booking_form_token($branchId);

if($_SERVER['REQUEST_METHOD']==='POST'){
    try{
        verify_csrf();
        $postedToken=trim((string)($_POST['submission_token']??''));
        if($postedToken==='' || !hash_equals($formToken,$postedToken)) throw new RuntimeException('This booking form has expired. Refresh the page and submit again.');

        $name=trim($_POST['full_name']??''); $phone=trim($_POST['phone']??''); $email=trim($_POST['email']??''); $gender=$_POST['gender']??null;
        $date=$_POST['appointment_date']??''; $time=$_POST['start_time']??''; $staffId=(int)($_POST['staff_id']??0) ?: null;
        $serviceIds=array_values(array_unique(array_filter(array_map('intval',$_POST['service_id']??[]))));
        if($name==='') throw new RuntimeException('Please enter your full name.');
        if($phone==='') throw new RuntimeException('Please enter your phone number.');
        if(!$serviceIds) throw new RuntimeException('Please select at least one service.');
        if(!valid_date($date) || $date<today()) throw new RuntimeException('Please select today or a future date.');
        if(!preg_match('/^\d{2}:\d{2}$/',$time)) throw new RuntimeException('Please select a valid time.');
        if($staffId && !scalar('SELECT id FROM staff WHERE id=? AND branch_id=? AND status="active"',[$staffId,$branchId])) throw new RuntimeException('The selected staff member is not available.');

        $placeholders=implode(',',array_fill(0,count($serviceIds),'?'));
        $services=all('SELECT id,name,price,duration_minutes FROM services WHERE branch_id=? AND status="active" AND id IN ('.$placeholders.')',array_merge([$branchId],$serviceIds));
        if(count($services)!==count($serviceIds)) throw new RuntimeException('One selected service is not available. Please refresh and try again.');
        $duration=0; foreach($services as $svc) $duration+=(int)$svc['duration_minutes']; if($duration<=0)$duration=30;
        $start=new DateTime($date.' '.$time); $end=(clone $start)->modify('+'.$duration.' minutes'); $endTime=$end->format('H:i:s');
        if($staffId){
            $over=(int)scalar('SELECT COUNT(*) FROM appointments WHERE branch_id=? AND staff_id=? AND appointment_date=? AND status NOT IN("cancelled","no_show","completed") AND start_time < ? AND end_time > ?',[$branchId,$staffId,$date,$endTime,$time]);
            if($over>0) throw new RuntimeException('That staff member is already booked at that time. Please choose another time or leave staff unassigned.');
        }

        $countryCode=(string)setting('whatsapp_country_code','255',$branchId);
        $normalized=normalize_phone($phone,$countryCode ?: '255');
        if($normalized==='') throw new RuntimeException('Please enter a valid phone number.');
        $fingerprint=public_booking_fingerprint($branchId,$postedToken,$normalized,$date,$time,$staffId,$serviceIds);

        db()->beginTransaction();
        try{
            q('INSERT INTO public_booking_submissions(branch_id,submission_token,booking_fingerprint,customer_phone,status,created_at) VALUES(?,?,?,? ,"started",NOW())',[$branchId,$postedToken,$fingerprint,$normalized]);
        }catch(PDOException $duplicate){
            $existing=one('SELECT appointment_no,status FROM public_booking_submissions WHERE submission_token=? OR booking_fingerprint=? LIMIT 1',[$postedToken,$fingerprint]);
            if($existing && ($existing['status']??'')==='completed' && !empty($existing['appointment_no'])){
                db()->rollBack();
                finish_public_booking($branchId,(string)$existing['appointment_no'],'Your booking has already been received.');
            }
            throw new RuntimeException('This booking is already being processed. Please do not submit it again.');
        }

        $customerId=(int)(scalar('SELECT id FROM customers WHERE branch_id=? AND phone=? LIMIT 1',[$branchId,$normalized]) ?: 0);
        if(!$customerId){
            $no='CUS-'.date('ymd').'-'.str_pad((string)((int)scalar('SELECT COUNT(*)+1 FROM customers')),4,'0',STR_PAD_LEFT);
            q('INSERT INTO customers(branch_id,customer_no,full_name,phone,email,gender,status,created_at) VALUES(?,?,?,?,?,?,"active",NOW())',[$branchId,$no,$name,$normalized,$email?:null,$gender?:null]);
            $customerId=(int)db()->lastInsertId();
            q('INSERT IGNORE INTO loyalty_accounts(customer_id,points_balance,lifetime_points,updated_at) VALUES(?,0,0,NOW())',[$customerId]);
        } else {
            q('UPDATE customers SET full_name=?,email=COALESCE(NULLIF(?,""),email),gender=COALESCE(NULLIF(?,""),gender),updated_at=NOW() WHERE id=? AND branch_id=?',[$name,$email,$gender,$customerId,$branchId]);
        }

        $appointmentNo=next_code('APT','appointments','appointment_no');
        q('INSERT INTO appointments(branch_id,customer_id,appointment_no,public_booking_fingerprint,appointment_date,start_time,end_time,staff_id,status,source,notes,created_by,created_at) VALUES(?,?,?,?,?,?,?,? ,"booked","website",?,NULL,NOW())',[$branchId,$customerId,$appointmentNo,$fingerprint,$date,$time,$endTime,$staffId,trim($_POST['notes']??'')]);
        $appointmentId=(int)db()->lastInsertId();
        foreach($services as $svc) q('INSERT INTO appointment_services(appointment_id,service_id,price,duration_minutes,staff_id) VALUES(?,?,?,?,?)',[$appointmentId,$svc['id'],$svc['price'],$svc['duration_minutes'],$staffId]);
        q('UPDATE public_booking_submissions SET appointment_id=?,appointment_no=?,status="completed",updated_at=NOW() WHERE submission_token=?',[$appointmentId,$appointmentNo,$postedToken]);
        post_notification($customerId,'whatsapp',$normalized,'Hello '.$name.', your appointment request '.$appointmentNo.' is booked for '.$date.' at '.$time,$branchId);
        log_activity('Public booking created: '.$appointmentNo,'appointment',$branchId);
        db()->commit();
        finish_public_booking($branchId,$appointmentNo,'Your booking has been received.');
    }catch(Throwable $e){
        if(db()->inTransaction()) db()->rollBack();
        $error=$e->getMessage();
    }
}
$services=all('SELECT id,name,duration_minutes,price FROM services WHERE branch_id=? AND status="active" ORDER BY name',[$branchId]);
$staff=all('SELECT id,full_name,role_title FROM staff WHERE branch_id=? AND status="active" ORDER BY full_name',[$branchId]);
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Book Appointment — <?=e($branch['business_name'])?></title><link rel="icon" type="image/png" href="assets/img/favicon.png"><link rel="shortcut icon" type="image/png" href="assets/img/favicon.png"><link rel="stylesheet" href="assets/css/app.css"></head><body class="login-page"><div class="login-card" style="width:min(920px,95vw)"><h1><?=e($branch['business_name'])?></h1><p class="muted">Skin Beauty Aesthetics • Book appointment at <?=e($branch['name'])?></p><?php if($error):?><div class="alert error"><?=e($error)?></div><?php endif;?><form method="post"><?=csrf_field()?><input type="hidden" name="branch_id" value="<?=e($branchId)?>"><input type="hidden" name="submission_token" value="<?=e($formToken)?>"><div class="form-grid"><div class="form-group"><label>Full Name *</label><input name="full_name" required value="<?=e($_POST['full_name']??'')?>"></div><div class="form-group"><label>Phone Number *</label><input name="phone" required placeholder="07xx xxx xxx" value="<?=e($_POST['phone']??'')?>"></div><div class="form-group"><label>Email Optional</label><input type="email" name="email" value="<?=e($_POST['email']??'')?>"></div><div class="form-group"><label>Gender Optional</label><select name="gender"><option value="">Prefer not to say</option><?php foreach(['Female','Male','Other'] as $g):?><option value="<?=e($g)?>"<?=selected($_POST['gender']??'',$g)?>><?=e($g)?></option><?php endforeach;?></select></div><div class="form-group"><label>Date *</label><input type="date" name="appointment_date" min="<?=e(today())?>" required value="<?=e($_POST['appointment_date']??today())?>"></div><div class="form-group"><label>Time *</label><input type="time" name="start_time" required value="<?=e($_POST['start_time']??'09:00')?>"></div><div class="form-group"><label>Preferred Staff Optional</label><select name="staff_id"><option value="">Any available staff</option><?php foreach($staff as $s):?><option value="<?=e($s['id'])?>"<?=selected($_POST['staff_id']??'',$s['id'])?>><?=e($s['full_name'])?><?= $s['role_title']?' — '.e($s['role_title']):'' ?></option><?php endforeach;?></select></div><div class="form-group full"><label>Services *</label><div class="grid cols-3"><?php foreach($services as $svc):?><label><input type="checkbox" name="service_id[]" value="<?=e($svc['id'])?>" <?=in_array((string)$svc['id'],array_map('strval',$_POST['service_id']??[]),true)?'checked':''?>> <?=e($svc['name'])?> <small><?=e($svc['duration_minutes'])?> min • <?=money($svc['price'])?></small></label><?php endforeach;?></div></div><div class="form-group full"><label>Notes Optional</label><textarea name="notes" placeholder="Example: I prefer afternoon, bridal makeup, sensitive skin, etc."><?=e($_POST['notes']??'')?></textarea></div></div><button class="btn" style="width:100%;margin-top:16px">Submit Booking</button></form><p class="muted" style="margin-top:16px">For urgent changes, please contact <?=e($branch['phone']??'the salon')?>.</p></div></body></html>
