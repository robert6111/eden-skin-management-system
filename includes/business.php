<?php
function option_rows(string $table,string $labelCol='name',string $where='status="active"'): array {
    $sql="SELECT id, $labelCol label FROM `$table`";
    $params=[];
    if($where){ $sql.=" WHERE $where"; }
    if(str_contains($where,'branch_id=?')) $params[] = current_branch_id();
    $sql.=" ORDER BY label";
    $out=[]; foreach(all($sql,$params) as $r){ $out[$r['id']]=$r['label']; } return $out;
}
function customers_options(bool $includeBlank=true): array { $rows=all('SELECT id, CONCAT(full_name," — ",COALESCE(phone,"")) label FROM customers WHERE branch_id=? AND status="active" ORDER BY full_name',[current_branch_id()]); $o=[]; foreach($rows as $r)$o[$r['id']]=$r['label']; return $o; }
function staff_options(): array { $rows=all('SELECT id, CONCAT(full_name," — ",COALESCE(role_title,"Staff")) label FROM staff WHERE branch_id=? AND status="active" ORDER BY full_name',[current_branch_id()]); $o=[]; foreach($rows as $r)$o[$r['id']]=$r['label']; return $o; }
function service_options(): array { $rows=all('SELECT id, CONCAT(name," — TZS ",FORMAT(price,0)) label FROM services WHERE branch_id=? AND status="active" ORDER BY name',[current_branch_id()]); $o=[]; foreach($rows as $r)$o[$r['id']]=$r['label']; return $o; }
function product_options(): array { $rows=all('SELECT p.id, CONCAT(p.name," — ",COALESCE(sl.quantity,0)," ",COALESCE(p.unit,"")) label FROM products p LEFT JOIN stock_levels sl ON sl.product_id=p.id AND sl.branch_id=p.branch_id WHERE p.branch_id=? AND p.status="active" ORDER BY p.name',[current_branch_id()]); $o=[]; foreach($rows as $r)$o[$r['id']]=$r['label']; return $o; }
function package_options(): array { $rows=all('SELECT id, CONCAT(name," — TZS ",FORMAT(package_price,0)) label FROM packages WHERE branch_id=? AND status="active" ORDER BY name',[current_branch_id()]); $o=[]; foreach($rows as $r)$o[$r['id']]=$r['label']; return $o; }
function supplier_options(): array { $rows=all('SELECT id,name label FROM suppliers WHERE branch_id=? AND status="active" ORDER BY name',[current_branch_id()]); $o=[]; foreach($rows as $r)$o[$r['id']]=$r['label']; return $o; }
function payment_methods(): array { return ['cash'=>'Cash','mpesa'=>'M-Pesa','airtel_money'=>'Airtel Money','tigo_pesa'=>'Tigo Pesa','halopesa'=>'HaloPesa','bank'=>'Bank','card'=>'Card','gift_card'=>'Gift Card','other'=>'Other']; }
function stock_balance(int $branchId,int $productId): float { return (float)(scalar('SELECT quantity FROM stock_levels WHERE branch_id=? AND product_id=?',[$branchId,$productId]) ?: 0); }
function ensure_stock_level(int $branchId,int $productId): void { q('INSERT IGNORE INTO stock_levels(branch_id,product_id,quantity) VALUES(?,?,0)',[$branchId,$productId]); }
function product_tracks_stock(int $branchId,int $productId): bool { return (int)(scalar('SELECT COALESCE(track_stock,1) FROM products WHERE id=? AND branch_id=?',[$productId,$branchId]) ?? 1) === 1; }
function product_stock_label(int $branchId,int $productId): string {
    $p=one('SELECT name,brand,unit FROM products WHERE id=? AND branch_id=?',[$productId,$branchId]);
    if(!$p) return 'Product #'.$productId;
    return trim($p['name'].(!empty($p['brand'])?' ('.$p['brand'].')':'').(!empty($p['unit'])?' ['.$p['unit'].']':''));
}
function stock_move(int $branchId,int $productId,float $delta,string $type,string $refType='',?int $refId=null,string $notes=''): float {
    ensure_stock_level($branchId,$productId);
    if($delta < 0 && in_array($type,['sale','service_use','transfer_out'],true) && product_tracks_stock($branchId,$productId)){
        $current=stock_balance($branchId,$productId);
        if($current + $delta < -0.0005){
            throw new RuntimeException('Insufficient stock for '.product_stock_label($branchId,$productId).'. Available: '.number_format($current,3).', required: '.number_format(abs($delta),3).'.');
        }
    }
    q('UPDATE stock_levels SET quantity=quantity+? WHERE branch_id=? AND product_id=?',[$delta,$branchId,$productId]);
    $bal=stock_balance($branchId,$productId);
    q('INSERT INTO stock_movements(branch_id,product_id,movement_type,quantity,balance_after,reference_type,reference_id,notes,created_by,created_at) VALUES(?,?,?,?,?,?,?,?,?,NOW())',[$branchId,$productId,$type,$delta,$bal,$refType,$refId,$notes,$_SESSION['user_id']??null]);
    return $bal;
}
function add_required_stock(array &$required,int $productId,float $qty): void {
    if($productId<=0 || $qty<=0) return;
    if(!isset($required[$productId])) $required[$productId]=0.0;
    $required[$productId]+=$qty;
}
function add_service_required_stock(array &$required,int $serviceId,float $serviceQty): void {
    if($serviceId<=0 || $serviceQty<=0) return;
    foreach(all('SELECT product_id,quantity_used FROM service_products WHERE service_id=?',[$serviceId]) as $row){
        add_required_stock($required,(int)$row['product_id'],(float)$row['quantity_used']*$serviceQty);
    }
}
function validate_sale_stock_availability(int $branchId,array $items): void {
    $required=[];
    foreach($items as $it){
        $type=(string)($it['type'] ?? '');
        $qty=max(0,(float)($it['qty'] ?? 0));
        $itemId=(int)($it['id'] ?? 0);
        if($qty<=0 || $itemId<=0) continue;
        if($type==='product' && !empty($it['track_stock'])){
            add_required_stock($required,$itemId,$qty);
        } elseif($type==='service'){
            add_service_required_stock($required,$itemId,$qty);
        } elseif($type==='package'){
            foreach(all('SELECT service_id,quantity FROM package_services WHERE package_id=?',[$itemId]) as $ps){
                add_service_required_stock($required,(int)$ps['service_id'],$qty*max(1,(float)$ps['quantity']));
            }
        }
    }
    $errors=[];
    foreach($required as $productId=>$needed){
        if(!product_tracks_stock($branchId,(int)$productId)) continue;
        $available=stock_balance($branchId,(int)$productId);
        if($available + 0.0005 < $needed){
            $errors[] = product_stock_label($branchId,(int)$productId).' — available '.number_format($available,3).', required '.number_format($needed,3);
        }
    }
    if($errors){
        throw new RuntimeException('Sale stopped. Some products are not available in stock: '.implode('; ',$errors).'. Please restock or change the service/product before completing the sale.');
    }
}
function next_code(string $prefix,string $table,string $column): string { return $prefix.'-'.date('ymd').'-'.str_pad((string)(((int)scalar("SELECT COUNT(*)+1 FROM `$table` WHERE DATE(created_at)=CURDATE()")) ?: 1),4,'0',STR_PAD_LEFT); }
function next_queue_no(int $branchId): int { return (int)scalar('SELECT COALESCE(MAX(queue_number),0)+1 FROM queues WHERE branch_id=? AND queue_date=CURDATE()',[$branchId]); }
function create_customer_quick(string $name,string $phone=''): int { $name=trim($name) ?: 'Walk-in Customer'; $phone=normalize_phone($phone); $no='CUS-'.date('ymd').'-'.str_pad((string)((int)scalar('SELECT COUNT(*)+1 FROM customers')),4,'0',STR_PAD_LEFT); q('INSERT INTO customers(branch_id,customer_no,full_name,phone,status,created_at) VALUES(?,?,?,?,"active",NOW())',[current_branch_id(),$no,$name,$phone]); $id=(int)db()->lastInsertId(); ensure_loyalty_account($id); audit('create','customers',$id,['quick'=>true]); return $id; }
function promotion_discount(?int $promoId,?int $customerId,float $subtotal,array $serviceIds=[]): float {
    if(!$promoId) return 0; $bid=current_branch_id();
    $p=one('SELECT * FROM promotions WHERE id=? AND branch_id=? AND status="active" AND NOW() BETWEEN start_at AND end_at',[$promoId,$bid]); if(!$p) return 0;
    if((float)$p['min_spend']>$subtotal) return 0;
    if(!empty($p['day_of_week'])){ $allowed=array_map('trim',explode(',',$p['day_of_week'])); if(!in_array(date('l'),$allowed,true)) return 0; }
    if($p['start_time'] && date('H:i:s')<$p['start_time']) return 0; if($p['end_time'] && date('H:i:s')>$p['end_time']) return 0;
    if($p['customer_scope']==='specific' && $customerId){ if(!scalar('SELECT 1 FROM promotion_customers WHERE promotion_id=? AND customer_id=?',[$promoId,$customerId])) return 0; }
    if($p['customer_scope']==='members' && $customerId){ if(!active_membership_discount($customerId)) return 0; }
    if($p['customer_scope']==='new' && $customerId){ if((int)scalar('SELECT COUNT(*) FROM sales WHERE customer_id=?',[$customerId])>0) return 0; }
    if($p['customer_scope']==='returning' && $customerId){ if((int)scalar('SELECT COUNT(*) FROM sales WHERE customer_id=?',[$customerId])<1) return 0; }
    $limited=all('SELECT service_id FROM promotion_services WHERE promotion_id=?',[$promoId]); if($limited && !$serviceIds) return 0; if($limited){ $ok=false; $ids=array_column($limited,'service_id'); foreach($serviceIds as $sid) if(in_array($sid,$ids)){ $ok=true; break; } if(!$ok) return 0; }
    if($p['discount_type']==='fixed') return min($subtotal,(float)$p['discount_value']);
    if($p['discount_type']==='bogo') return 0; // marked and visible, but manual line discounts should be used for exact BOGO item choice.
    return round($subtotal*((float)$p['discount_value']/100),2);
}
function make_commission(int $branchId,int $saleId,int $saleItemId,int $staffId,int $serviceId,float $base): void {
    if(!$staffId || !$serviceId || $base<=0) return;
    $rule=one('SELECT * FROM commission_rules WHERE branch_id=? AND status="active" AND (staff_id=? OR staff_id IS NULL) AND (service_id=? OR service_id IS NULL) ORDER BY staff_id IS NULL ASC, service_id IS NULL ASC LIMIT 1',[$branchId,$staffId,$serviceId]);
    if($rule){ $type=$rule['commission_type']; $val=(float)$rule['commission_value']; }
    else { $svc=one('SELECT commission_type,commission_value FROM services WHERE id=?',[$serviceId]); if(!$svc || $svc['commission_type']==='none') return; $type=$svc['commission_type']; $val=(float)$svc['commission_value']; }
    $amt=$type==='percentage' ? round($base*$val/100,2) : $val;
    if($amt>0) q('INSERT INTO commissions(branch_id,sale_id,sale_item_id,staff_id,service_id,base_amount,commission_type,commission_value,commission_amount,status,created_at) VALUES(?,?,?,?,?,?,?,?,?,"unpaid",NOW())',[$branchId,$saleId,$saleItemId,$staffId,$serviceId,$base,$type,$val,$amt]);
}
function consume_service_products(int $branchId,int $serviceId,float $qty,string $refType,int $refId): void {
    $items=all('SELECT product_id,quantity_used FROM service_products WHERE service_id=?',[$serviceId]);
    foreach($items as $it){ $amount=-1*((float)$it['quantity_used']*$qty); stock_move($branchId,(int)$it['product_id'],$amount,'service_use',$refType,$refId,'Automatic service consumption'); }
}
function sale_balance_and_status(int $saleId): void {
    $s=one('SELECT total_amount,paid_amount FROM sales WHERE id=?',[$saleId]); if(!$s)return; $balance=max(0,(float)$s['total_amount']-(float)$s['paid_amount']); $status=$balance>0?'partial':'paid'; q('UPDATE sales SET balance_amount=?,status=? WHERE id=?',[$balance,$status,$saleId]);
}
function amount_refunded_for_item(int $saleItemId): float { return (float)(scalar('SELECT COALESCE(SUM(quantity),0) FROM refund_items ri JOIN refunds r ON r.id=ri.refund_id WHERE ri.sale_item_id=? AND r.status IN("pending","approved")',[$saleItemId])?:0); }
function safe_upload(string $field,string $subdir='documents'): ?array {
    if(empty($_FILES[$field]) || ($_FILES[$field]['error']??UPLOAD_ERR_NO_FILE)===UPLOAD_ERR_NO_FILE) return null;
    if($_FILES[$field]['error']!==UPLOAD_ERR_OK) throw new RuntimeException('Upload failed.');
    $allowed=['image/jpeg','image/png','application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    $mime=mime_content_type($_FILES[$field]['tmp_name']) ?: 'application/octet-stream'; if(!in_array($mime,$allowed,true)) throw new RuntimeException('Unsupported file type.');
    $dir=dirname(__DIR__).'/storage/uploads/'.$subdir.'/'.date('Y/m'); if(!is_dir($dir)) mkdir($dir,0775,true);
    $ext=pathinfo($_FILES[$field]['name'],PATHINFO_EXTENSION); $name=bin2hex(random_bytes(8)).($ext?'.'.$ext:''); $path=$dir.'/'.$name;
    if(!move_uploaded_file($_FILES[$field]['tmp_name'],$path)) throw new RuntimeException('Could not save uploaded file.');
    return ['path'=>str_replace(dirname(__DIR__).'/', '', $path),'original'=>$_FILES[$field]['name'],'mime'=>$mime];
}

function table_exists(string $table): bool {
    try { return (bool)scalar('SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=?', [$table]); } catch (Throwable) { return false; }
}
function column_exists(string $table,string $column): bool {
    try { return (bool)scalar('SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=? AND COLUMN_NAME=?', [$table,$column]); } catch (Throwable) { return false; }
}
function ensure_continuation_schema(): void {
    static $done=false; if($done) return; $done=true;
    try {
        if(!column_exists('services','continuation_required')) q('ALTER TABLE services ADD COLUMN continuation_required TINYINT(1) NOT NULL DEFAULT 0 AFTER status');
        if(!column_exists('services','continuation_after_days')) q('ALTER TABLE services ADD COLUMN continuation_after_days INT NOT NULL DEFAULT 0 AFTER continuation_required');
        if(!column_exists('services','continuation_service_id')) q('ALTER TABLE services ADD COLUMN continuation_service_id INT NULL AFTER continuation_after_days');
        if(!column_exists('services','continuation_message')) q('ALTER TABLE services ADD COLUMN continuation_message TEXT NULL AFTER continuation_service_id');
        q('CREATE TABLE IF NOT EXISTS customer_service_continuations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            branch_id INT NOT NULL,
            customer_id INT NOT NULL,
            sale_id INT NULL,
            sale_item_id INT NULL,
            service_id INT NOT NULL,
            continuation_service_id INT NULL,
            staff_id INT NULL,
            original_service_date DATE NOT NULL,
            due_date DATE NOT NULL,
            preferred_time TIME NULL,
            status ENUM("planned","reminded","booked","completed","cancelled","missed") DEFAULT "planned",
            appointment_id INT NULL,
            reminder_sent_at DATETIME NULL,
            notes TEXT,
            created_by INT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL,
            UNIQUE KEY uniq_continuation_sale_service (sale_item_id, service_id),
            INDEX continuation_due_idx (branch_id,due_date,status),
            INDEX continuation_customer_idx (customer_id,due_date),
            FOREIGN KEY(branch_id) REFERENCES branches(id),
            FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE CASCADE,
            FOREIGN KEY(sale_id) REFERENCES sales(id) ON DELETE SET NULL,
            FOREIGN KEY(sale_item_id) REFERENCES sale_items(id) ON DELETE SET NULL,
            FOREIGN KEY(service_id) REFERENCES services(id),
            FOREIGN KEY(continuation_service_id) REFERENCES services(id) ON DELETE SET NULL,
            FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE SET NULL,
            FOREIGN KEY(appointment_id) REFERENCES appointments(id) ON DELETE SET NULL,
            FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB');
    } catch (Throwable $e) {
        // Never break existing sale/booking flow if an old database still needs migration.
    }
}
function continuation_service_config(int $serviceId,int $branchId): ?array {
    ensure_continuation_schema();
    try {
        $svc=one('SELECT id,name,continuation_required,continuation_after_days,continuation_service_id,continuation_message FROM services WHERE id=? AND branch_id=?',[$serviceId,$branchId]);
        if(!$svc || (int)($svc['continuation_required']??0)!==1 || (int)($svc['continuation_after_days']??0)<=0) return null;
        return $svc;
    } catch (Throwable) { return null; }
}
function create_customer_continuation(int $branchId,int $customerId,int $saleId,int $saleItemId,int $serviceId,?int $staffId=null,float $qty=1): ?int {
    if(!$customerId || !$serviceId) return null;
    ensure_continuation_schema();
    $cfg=continuation_service_config($serviceId,$branchId);
    if(!$cfg) return null;
    try {
        $days=max(1,(int)$cfg['continuation_after_days']);
        $due=date('Y-m-d',strtotime('+'.$days.' days'));
        $contServiceId=(int)($cfg['continuation_service_id'] ?: 0) ?: $serviceId;
        $defaultMsg=trim((string)($cfg['continuation_message'] ?? ''));
        $notes=$defaultMsg!=='' ? $defaultMsg : 'Continuation visit after '.$cfg['name'];
        q('INSERT IGNORE INTO customer_service_continuations(branch_id,customer_id,sale_id,sale_item_id,service_id,continuation_service_id,staff_id,original_service_date,due_date,preferred_time,status,notes,created_by,created_at)
           VALUES(?,?,?,?,?,?,?,?,?,NULL,"planned",?,?,NOW())',[$branchId,$customerId,$saleId,$saleItemId,$serviceId,$contServiceId,$staffId,today(),$due,$notes,$_SESSION['user_id']??null]);
        $id=(int)db()->lastInsertId();
        if($id>0){
            $c=one('SELECT full_name,phone FROM customers WHERE id=?',[$customerId]);
            if($c && !empty($c['phone'])){
                $msg='Hello '.$c['full_name'].', reminder: your continuation visit for '.$cfg['name'].' is due on '.$due.'. Please reply to confirm your preferred time.';
                $lead=max(0,(int)setting('continuation_reminder_days',1,$branchId));
                $scheduled=date('Y-m-d 09:00:00',strtotime($due.' -'.$lead.' days'));
                if($scheduled<now()) $scheduled=now();
                q('INSERT INTO notifications(branch_id,customer_id,type,recipient,message,status,scheduled_at,created_at) VALUES(?,?,?,?,?,"queued",?,NOW())',[$branchId,$customerId,'whatsapp',$c['phone'],$msg,$scheduled]);
            }
            audit('create','customer_service_continuations',$id,['sale_id'=>$saleId,'service_id'=>$serviceId,'due_date'=>$due]);
            log_activity('Continuation planned for customer #'.$customerId.' on '.$due,'continuation',$branchId);
            return $id;
        }
    } catch (Throwable) {}
    return null;
}
function continuation_badge(string $status): string {
    return match($status){
        'planned'=>'badge purple','reminded'=>'badge orange','booked'=>'badge green','completed'=>'badge green','cancelled'=>'badge red','missed'=>'badge red',default=>'badge'
    };
}
function continuation_due_counts(?int $branchId): array {
    if(!$branchId) return ['today'=>0,'overdue'=>0,'upcoming'=>0];
    ensure_continuation_schema();
    try {
        return [
            'today'=>(int)scalar('SELECT COUNT(*) FROM customer_service_continuations WHERE branch_id=? AND due_date=CURDATE() AND status IN("planned","reminded")',[$branchId]),
            'overdue'=>(int)scalar('SELECT COUNT(*) FROM customer_service_continuations WHERE branch_id=? AND due_date<CURDATE() AND status IN("planned","reminded")',[$branchId]),
            'upcoming'=>(int)scalar('SELECT COUNT(*) FROM customer_service_continuations WHERE branch_id=? AND due_date>CURDATE() AND due_date<=DATE_ADD(CURDATE(),INTERVAL 7 DAY) AND status IN("planned","reminded","booked")',[$branchId])
        ];
    } catch(Throwable){ return ['today'=>0,'overdue'=>0,'upcoming'=>0]; }
}

?>