<?php require __DIR__.'/includes/bootstrap.php'; if(is_logged_in())audit('logout','user',$_SESSION['user_id']); logout_user(); redirect('login.php');
