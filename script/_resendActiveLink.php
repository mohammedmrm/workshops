<?php
header('Content-type:application/json');
error_reporting(0);
require_once("dbconnection.php");
require_once("_sendEmail.php");
$email = $_REQUEST['email'];
$sql = "select * from users  where email=? and active=0";
$res = getData($con,$sql,[$email]);
if(count($res) == 1){
  $sub = "تأكيد البريد الالكتروني";
  $body  = "<p dir='rtl'>السلام عليكم,<br /> يرجى الضغط على الرابط المرسل ادناه لتأكيد حسابك على المنصه. اذا لم تقم بالستجيل يرجى اهمال هذا البريد";
  $body .= '<br /><a href="http://'.$_SERVER['HTTP_HOST'].'/workshops/verfiyEmail.php?token='.$res[0]['activation_code'].'&id='.$res[0]['id'].'">http://'.$_SERVER['HTTP_HOST'].'/workshops/verfiyEmail.php?token='.$res[0]['activation_code'].'&id='.$res[0]['id'].'</a>';
  $body .="<br /><br /><br /> <i>جامعه بابل - مركز الوسائط المتعددة و التعليم الالكتروني</i></p>";
  $body .="<br /> <i>University of Babylon - Multimedia Center and e-Learning</i>" ;
  $sent = sendEmail($res[0]['email'],$sub,$body);
  if($sent){
    $success = 1;
  }else{
    $success = 0;
  }
}else{
  $success = 0;
}
ob_end_clean();
echo json_encode(['success'=>$success]);
?>