<?php
function session_cookie_path(): string {
    $base=rtrim((string)(app_config()['app']['base_url'] ?? ''),'/');
    return $base===''?'/':$base.'/';
}
function start_secure_session(): void {
    if(session_status()===PHP_SESSION_NONE){
        @ini_set('session.use_strict_mode','1');
        @ini_set('session.cookie_httponly','1');
        @ini_set('session.cookie_samesite','Lax');
        // Other applications deployed under the same host (e.g. sibling projects in
        // htdocs) share the default PHPSESSID cookie on path "/". Their session data
        // leaks in here and a foreign user_id makes this system believe someone is
        // signed in with no branch selected. Give this app its own cookie name/path.
        session_name('SALONSPASESSID');
        session_set_cookie_params(['path'=>session_cookie_path(),'httponly'=>true,'samesite'=>'Lax','secure'=>(!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')]);
        session_start();
    }
}
function is_logged_in(): bool { return !empty($_SESSION['user_id']); }
function default_branch_id(): int { try { return (int)(scalar('SELECT id FROM branches WHERE status="active" ORDER BY id LIMIT 1') ?: 0); } catch(Throwable){ return 0; } }
function login_user(array $user): void { session_regenerate_id(true); $_SESSION['user_id']=(int)$user['id']; $_SESSION['branch_id']=(int)($user['branch_id']??0) ?: default_branch_id(); $_SESSION['last_activity']=time(); }
function logout_user(): void { $_SESSION=[]; if(ini_get('session.use_cookies')){ $p=session_get_cookie_params(); setcookie(session_name(),'',time()-42000,$p['path'],$p['domain'],$p['secure'],$p['httponly']); } session_destroy(); }
function require_login(): void {
    if(!is_logged_in()) redirect('login.php');
    if(!current_user()){ logout_user(); redirect('login.php'); }
    if(current_branch_id()===null){ logout_user(); redirect('login.php?nobranch=1'); }
    $timeout=(int)(setting('auto_logout_minutes',0) ?: 0); $timeout=$timeout>0?$timeout*60:(int)(app_config()['app']['session_timeout']??3600);
    if(!empty($_SESSION['last_activity']) && time()-$_SESSION['last_activity']>$timeout){ logout_user(); redirect('login.php?expired=1'); }
    $_SESSION['last_activity']=time();
}
function current_user(): ?array { static $u; if(!is_logged_in())return null; if(!$u)$u=one('SELECT u.*,r.name role_name,s.full_name staff_name,b.name branch_name FROM users u JOIN roles r ON r.id=u.role_id LEFT JOIN staff s ON s.id=u.staff_id LEFT JOIN branches b ON b.id=u.branch_id WHERE u.id=?',[$_SESSION['user_id']]); return $u; }
function current_branch_id(): ?int {
    if(isset($_SESSION['branch_id']) && (int)$_SESSION['branch_id']>0) return (int)$_SESSION['branch_id'];
    $u=current_user();
    if($u){ $b=(int)($u['branch_id']??0) ?: default_branch_id(); if($b>0){ $_SESSION['branch_id']=$b; return $b; } }
    return null;
}
function permissions(): array { static $p; if($p!==null)return $p; if(!is_logged_in())return []; $p=q('SELECT p.code FROM permissions p JOIN role_permissions rp ON rp.permission_id=p.id JOIN users u ON u.role_id=rp.role_id WHERE u.id=?',[$_SESSION['user_id']])->fetchAll(PDO::FETCH_COLUMN); return $p; }
function can(string $code): bool { $u=current_user(); return $u && ($u['role_name']==='Owner' || in_array($code,permissions(),true)); }
function require_permission(string $code): void { require_login(); if(!can($code)){http_response_code(403); include dirname(__DIR__).'/403.php'; exit;} }
