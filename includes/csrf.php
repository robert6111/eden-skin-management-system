<?php
function csrf_token(): string { if(empty($_SESSION['_csrf']))$_SESSION['_csrf']=bin2hex(random_bytes(32)); return $_SESSION['_csrf']; }
function csrf_field(): string { return '<input type="hidden" name="_csrf" value="'.e(csrf_token()).'">'; }
function verify_csrf(): void { $t=$_POST['_csrf']??($_SERVER['HTTP_X_CSRF_TOKEN']??''); if(!$t || !hash_equals($_SESSION['_csrf']??'', $t)){http_response_code(419); exit('Invalid or expired security token. Go back and retry.');} }
