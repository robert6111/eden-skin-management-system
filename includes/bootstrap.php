<?php
require __DIR__.'/functions.php';
send_security_headers();
if(!is_file(dirname(__DIR__).'/config.php') && basename($_SERVER['SCRIPT_NAME']??'')!=='install.php'){header('Location: install.php');exit;}
if(is_file(dirname(__DIR__).'/config.php')){
    $cfg=app_config(); date_default_timezone_set($cfg['app']['timezone']??'Africa/Dar_es_Salaam');
}
require __DIR__.'/db.php';
require __DIR__.'/auth.php';
require __DIR__.'/csrf.php';
start_secure_session();

require __DIR__.'/business.php';
