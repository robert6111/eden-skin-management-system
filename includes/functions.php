<?php

function send_security_headers(): void {
    if(headers_sent()) return;
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    header('X-Permitted-Cross-Domain-Policies: none');
    if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'){
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
}

function app_config(): array {
    static $config;
    if (!$config) {
        $file=dirname(__DIR__).'/config.php';
        if (!is_file($file)) { if (basename($_SERVER['SCRIPT_NAME'] ?? '') !== 'install.php') { header('Location: install.php'); exit; } return []; }
        $config=require $file;
    }
    return $config;
}
function e(mixed $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function url(string $path=''): string { $base=rtrim(app_config()['app']['base_url'] ?? '', '/'); return $base.'/'.ltrim($path,'/'); }
function redirect(string $path): never { header('Location: '.(preg_match('~^https?://~',$path)?$path:url($path))); exit; }
function money(float|int|string|null $n): string { return 'TZS '.number_format((float)$n,0,'.',','); }
function flash(string $key, ?string $value=null): ?string { if ($value!==null){$_SESSION['_flash'][$key]=$value; return null;} $v=$_SESSION['_flash'][$key]??null; unset($_SESSION['_flash'][$key]); return $v; }
function now(): string { return date('Y-m-d H:i:s'); }
function today(): string { return date('Y-m-d'); }
function uuidish(): string { return strtoupper(date('ymd').'-'.bin2hex(random_bytes(3))); }
function selected(mixed $a,mixed $b): string { return (string)$a===(string)$b?' selected':''; }
function checked(mixed $v): string { return $v?' checked':''; }
function json_response(array $data,int $status=200): never { http_response_code($status); header('Content-Type: application/json'); echo json_encode($data); exit; }
function request_json(): array { $d=json_decode(file_get_contents('php://input'),true); return is_array($d)?$d:[]; }
function setting(string $key,mixed $default=null,?int $branchId=null): mixed {
    try { $branchId=$branchId??current_branch_id(); $r=one('SELECT setting_value FROM settings WHERE setting_key=? AND (branch_id=? OR branch_id IS NULL) ORDER BY branch_id IS NOT NULL DESC LIMIT 1',[$key,$branchId]); return $r ? $r['setting_value'] : $default; } catch(Throwable){ return $default; }
}
function audit(string $action,string $entity='',?int $entityId=null,array $details=[]): void {
    try { q('INSERT INTO audit_logs(user_id,branch_id,action,entity_type,entity_id,details,ip_address,user_agent,created_at) VALUES(?,?,?,?,?,?,?,?,NOW())',[
        $_SESSION['user_id']??null,current_branch_id(),$action,$entity,$entityId,json_encode($details,JSON_UNESCAPED_UNICODE),$_SERVER['REMOTE_ADDR']??'',substr($_SERVER['HTTP_USER_AGENT']??'',0,250)
    ]); } catch(Throwable){}
}
function log_activity(string $message,string $type='info',?int $branchId=null): void {
    try { q('INSERT INTO system_activities(branch_id,user_id,activity_type,message,created_at) VALUES(?,?,?,?,NOW())',[$branchId??current_branch_id(),$_SESSION['user_id']??null,$type,$message]); } catch(Throwable){}
}
function branch_filter(string $alias=''): array {
    $prefix=$alias?trim($alias,'.').'.':'';
    if (can('branches.view_all')) return ['1=1',[]];
    return ["{$prefix}branch_id=?",[current_branch_id()]];
}
function csv_download(string $filename,array $headers,array $rows): never {
    header('Content-Type: text/csv; charset=UTF-8'); header('Content-Disposition: attachment; filename="'.$filename.'"');
    $out=fopen('php://output','w'); fwrite($out,"\xEF\xBB\xBF"); fputcsv($out,$headers); foreach($rows as $r) fputcsv($out,$r); fclose($out); exit;
}
function normalize_phone(string $phone, string $countryCode='255'): string {
    $p=preg_replace('/\D+/','',$phone);
    if($p==='') return '';
    if(str_starts_with($p,'00')) $p=substr($p,2);
    if(str_starts_with($p,'0')) $p=$countryCode.substr($p,1);
    if(strlen($p)===9) $p=$countryCode.$p;
    return $p;
}
function active_membership_discount(?int $customerId): float {
    if(!$customerId) return 0;
    return (float)(scalar('SELECT COALESCE(MAX(m.discount_percent),0) FROM customer_memberships cm JOIN memberships m ON m.id=cm.membership_id WHERE cm.customer_id=? AND cm.status="active" AND cm.start_date<=CURDATE() AND cm.end_date>=CURDATE()',[$customerId])?:0);
}
function loyalty_balance(?int $customerId): int { if(!$customerId)return 0; return (int)(scalar('SELECT points_balance FROM loyalty_accounts WHERE customer_id=?',[$customerId])?:0); }
function ensure_loyalty_account(int $customerId): int { $id=scalar('SELECT id FROM loyalty_accounts WHERE customer_id=?',[$customerId]); if($id)return (int)$id; q('INSERT INTO loyalty_accounts(customer_id,points_balance,lifetime_points,updated_at) VALUES(?,0,0,NOW())',[$customerId]); return (int)db()->lastInsertId(); }
function post_notification(?int $customerId,string $type,string $recipient,string $message,?int $branchId=null): void { q('INSERT INTO notifications(branch_id,customer_id,type,recipient,message,status,scheduled_at,created_at) VALUES(?,?,?,?,?,"queued",NOW(),NOW())',[$branchId??current_branch_id(),$customerId,$type,$recipient,$message]); }
function valid_date(?string $d): bool { if(!$d)return false; $x=DateTime::createFromFormat('Y-m-d',$d); return $x && $x->format('Y-m-d')===$d; }

function whatsapp_number(string $phone, string $countryCode='255'): string {
    return normalize_phone($phone, $countryCode);
}
function whatsapp_url(string $phone,string $message): string {
    $countryCode=(string)setting('whatsapp_country_code','255');
    $p=whatsapp_number($phone,$countryCode ?: '255');
    if($p==='') return '#';
    return 'https://wa.me/'.rawurlencode($p).'?text='.rawurlencode($message);
}
function is_local_web_host(string $host): bool {
    $host=strtolower(trim($host, "[] \t\n\r\0\x0B"));
    return in_array($host,['localhost','127.0.0.1','::1','0.0.0.0'],true);
}
function valid_lan_ipv4(string $ip): bool {
    if(!filter_var($ip,FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)) return false;
    if(str_starts_with($ip,'127.') || str_starts_with($ip,'169.254.')) return false;
    return true;
}
function detect_lan_ipv4(): string {
    $candidates=[];
    foreach([$_SERVER['SERVER_ADDR']??'', gethostbyname(gethostname() ?: '')] as $ip){
        if(is_string($ip) && valid_lan_ipv4($ip)) $candidates[]=$ip;
    }
    $out='';
    if(PHP_OS_FAMILY==='Windows'){
        $out=(string)@shell_exec('ipconfig');
        if($out && preg_match_all('/IPv4[^:\r\n]*:\s*([0-9]{1,3}(?:\.[0-9]{1,3}){3})/i',$out,$m)){
            foreach($m[1] as $ip) if(valid_lan_ipv4($ip)) $candidates[]=$ip;
        }
    } else {
        $out=(string)@shell_exec('hostname -I 2>/dev/null');
        foreach(preg_split('/\s+/',trim($out)) as $ip) if(valid_lan_ipv4($ip)) $candidates[]=$ip;
    }
    foreach($candidates as $ip){
        if(preg_match('/^(10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.|192\.168\.)/',$ip)) return $ip;
    }
    return $candidates[0] ?? ($_SERVER['HTTP_HOST'] ?? 'localhost');
}

function quick_http_get(string $url, int $timeoutMs=700): string {
    if(function_exists('curl_init')){
        $ch=curl_init($url);
        curl_setopt_array($ch,[
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_CONNECTTIMEOUT_MS=>min($timeoutMs,400),
            CURLOPT_TIMEOUT_MS=>$timeoutMs,
            CURLOPT_FOLLOWLOCATION=>false,
        ]);
        $body=(string)curl_exec($ch);
        $code=(int)curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($code>=200 && $code<300) ? $body : '';
    }
    $ctx=stream_context_create(['http'=>['timeout'=>max(1,$timeoutMs/1000),'ignore_errors'=>true]]);
    $body=@file_get_contents($url,false,$ctx);
    return is_string($body) ? $body : '';
}
function detect_ngrok_public_url(): string {
    // Ngrok exposes the active tunnel list on the local inspector API when `ngrok http 80` is running.
    foreach(['http://127.0.0.1:4040/api/tunnels','http://localhost:4040/api/tunnels'] as $endpoint){
        $raw=quick_http_get($endpoint,700);
        if($raw==='') continue;
        $data=json_decode($raw,true);
        if(!is_array($data) || empty($data['tunnels']) || !is_array($data['tunnels'])) continue;
        $fallback='';
        foreach($data['tunnels'] as $t){
            $public=(string)($t['public_url'] ?? '');
            $proto=(string)($t['proto'] ?? '');
            if(!preg_match('~^https?://~i',$public)) continue;
            if(str_starts_with(strtolower($public),'https://')) return rtrim($public,'/');
            if($fallback==='' && ($proto==='' || $proto==='http')) $fallback=rtrim($public,'/');
        }
        if($fallback!=='') return $fallback;
    }
    return '';
}
function app_relative_base_path(): string {
    $base=(string)(app_config()['app']['base_url'] ?? '');
    if(preg_match('~^https?://~i',$base)){
        $path=(string)(parse_url($base,PHP_URL_PATH) ?? '');
    } else {
        $path=$base;
    }
    $path=rtrim('/'.ltrim($path,'/'),'/');
    if($path==='' || $path==='/'){
        $script=str_replace('\\','/',$_SERVER['SCRIPT_NAME'] ?? '');
        $dir=rtrim(dirname($script),'/');
        if(basename($dir)==='modules') $dir=rtrim(dirname($dir),'/');
        $path=$dir==='/'?'':$dir;
    }
    return $path==='/'?'':rtrim($path,'/');
}

function public_web_base_url(?int $branchId=null): string {
    $branchId=$branchId??current_branch_id();
    $configured=trim((string)setting('public_booking_base_url','',$branchId));
    if($configured!=='') return rtrim($configured,'/');

    $ngrok=detect_ngrok_public_url();
    if($ngrok!=='') return rtrim($ngrok.app_relative_base_path(),'/');

    $scheme=(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off')?'https':'http';
    $hostHeader=(string)($_SERVER['HTTP_HOST'] ?? 'localhost');
    $hostOnly=$hostHeader; $port='';
    if(str_contains($hostHeader,':') && !str_starts_with($hostHeader,'[')){
        [$hostOnly,$portPart]=explode(':',$hostHeader,2);
        $port=$portPart!==''?':'.$portPart:'';
    }
    $host=is_local_web_host($hostOnly) ? detect_lan_ipv4() : $hostOnly;

    $base=(string)(app_config()['app']['base_url'] ?? '');
    if(preg_match('~^https?://~i',$base)){
        $parts=parse_url($base);
        $path=rtrim($parts['path'] ?? '', '/');
        $scheme=$parts['scheme'] ?? $scheme;
        $cfgHost=$parts['host'] ?? $host;
        if(!is_local_web_host($cfgHost)) $host=$cfgHost;
        if(isset($parts['port'])) $port=':'.$parts['port'];
        return rtrim($scheme.'://'.$host.$port.$path,'/');
    }
    $path=app_relative_base_path();
    return rtrim($scheme.'://'.$host.$port.$path,'/');
}
function public_booking_link(int $branchId): string {
    return public_web_base_url($branchId).'/public_booking.php?branch='.(int)$branchId;
}
