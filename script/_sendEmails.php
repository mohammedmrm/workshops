<?php
require '../vendor/autoload.php';
require_once 'dbconnection.php';
header('Content-Type: application/json');  
$id = $_REQUEST['workshop_id'];
$subject = $_REQUEST['sub'];
$body = $_REQUEST['body'];
$success = 0 ;
$error= [] ;
error_reporting(0);
use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;

$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى ',
    'email'      => 'البريد الالكتروني غيز صحيح',
]);
$v->validate([
    'id'      => [$id,     'required|int'],
    'sub'     => [$subject,'required|min(4)|max(200)'],
    'body'    => [$body,   'required|min(4)|max(1000)'],
]);
if($v->passes()) {
  $sql = "select users.email as emails from enrollment inner join users on users.id= enrollment.user_id where workshop_id = ?";
  $emails = getData($con,$sql,[$id]);
  if(count($emails) > 0){
    $res = sendEmails($emails,$subject,$body);
    if($res){
      $success = 1;
    }else{
      $success = 2;
    }
  }
}else {
  $error = [
           'sub_err'=> ($v->errors()->get('sub')),
           'body_err'=>($v->errors()->get('body')),
           'id_err'=>($v->errors()->get('id')),
           ];
}
function sendEmails($to,$sub,$body){
  $mail = new PHPMailer\PHPMailer\PHPMailer();
  $mail->IsSMTP(); // enable SMTP

  $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
  $mail->SMTPAuth = true; // authentication enabled
  $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 465; // or 587

  $mail->Username = "multimediacenter@uobabylon.edu.iq";
  $mail->Password = "!@#ASD123";
  $mail->SetFrom("multimediacenter@uobabylon.edu.iq");
  $mail->Subject = $sub;
  $mail->Body = $body;
  $mail->CharSet = 'UTF-8';
  $mail->IsHTML(true);
  foreach($to as $email){
   $mail->AddAddress($email['emails']);
  }
  if(!$mail->Send()) {
    return false;
  } else {
    return true;
  }
}
echo json_encode(['success'=>$success, 'error'=>$error,$_POST]);
