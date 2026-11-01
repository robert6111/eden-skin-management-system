<?php
require __DIR__.'/includes/bootstrap.php';
$branchId=(int)($_GET['branch']??1);
$appointmentNo=trim((string)($_GET['booked']??($_SESSION['_public_booking_done_no']??'')));
$message=(string)($_SESSION['_public_booking_done_message']??'Your booking has been received.');
unset($_SESSION['_public_booking_done_message'],$_SESSION['_public_booking_done_no']);
$branch=one('SELECT b.*,bs.name business_name FROM branches b JOIN businesses bs ON bs.id=b.business_id WHERE b.id=?',[$branchId]);
if(!$branch){ http_response_code(404); exit('Booking branch not found.'); }
if(!headers_sent()){
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
}
$googleUrl='https://www.google.com/';
?><!doctype html>
<html lang="en">
<head><link rel="icon" type="image/png" href="assets/img/favicon.png"><link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <meta http-equiv="refresh" content="0;url=<?=e($googleUrl)?>">
 <title>Booking Received — <?=e($branch['business_name'])?></title>
 <link rel="stylesheet" href="assets/css/app.css">
 <script>
  // Remove the success page from browser history and leave the booking site.
  // Refreshing this page cannot submit the form because this page is reached by GET only.
  window.location.replace(<?=json_encode($googleUrl)?>);
 </script>
</head>
<body class="login-page">
 <div class="login-card" style="width:min(620px,95vw);text-align:center">
  <h1>Booking Received</h1>
  <div class="alert success">
   <?=e($message)?>
   <?php if($appointmentNo!==''):?><br>Your appointment number is <strong><?=e($appointmentNo)?></strong>.<?php endif;?>
  </div>
  <p class="muted">Redirecting to Google now.</p>
  <p class="muted">Do not press back or refresh. The booking has already been saved.</p>
  <a class="btn" href="<?=e($googleUrl)?>">Go to Google Now</a>
 </div>
</body>
</html>
