<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("_sendEmail.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;

try{
$success = 0;
$error = [];
$name    = $_REQUEST['name'];
$email   = $_REQUEST['email'];
$password   = $_REQUEST['password'];
$role   = $_REQUEST['role'];
if(empty($role) || $_SESSION['role_id'] != 1){
  $role = 0;
}
$office  = $_REQUEST['office'];
if(empty($office) || $_SESSION['role_id'] != 1){
  $office = 0;
}


$v->addRuleMessage('isPhoneNumber', ' رقم هاتف غير صحيح  ');

$v->addRule('isPhoneNumber', function($value, $input, $args) {
    return   (bool) preg_match("/^[0-9]{10,15}$/",$value);
});
$v->addRuleMessage('unique', 'القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('unique', function($value, $input, $args) {

    $value  = trim($value);
    $exists = getData($GLOBALS['con'],"SELECT * FROM users WHERE email  ='".$value."'");
    return ! (bool) count($exists);
});
$v->addRuleMessage('isPrice', 'المبلغ غير صحيح');

$v->addRule('isPrice', function($value, $input, $args) {
  if(preg_match("/^(0|\d*)(\.\d{2})?$/",$value)){
    $x=(bool) 1;
  }
  return   $x;
});
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى ',
    'email'      => 'البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'name'    => [$name,    'required|min(4)|max(50)'],
    'email'   => [$email,   'required|unique|email'],
    'password'=> [$password,'required|min(8)|max(20)'],
]);

if($v->passes() && $img_err == "") {
  $activation = sha1(uniqid());
  $pass = hashPass($password);
  $sql = 'insert into users (name,email,password,role_id,office_id,activation_code) values
                             (?,?,?,?,?,?)';
  $result = setDataWithLastID($con,$sql,[$name,$email,$pass,$role,$office,$activation]);
  $success = 1;
  if($success){
    $sql = "select * from users  where id=? ";
    $res = getData($con,$sql,[$result]);
    $sub = "تأكيد البريد الالكتروني";
    $body  = "<p dir='rtl'>السلام عليكم,<br /> يرجى الضغط على الرابط المرسل ادناه لتأكيد حسابك على المنصه. اذا لم تقم بالستجيل يرجى اهمال هذا البريد";
    $body .= '<br /><a href="http://'.$_SERVER['HTTP_HOST'].'/workshops/verfiyEmail.php?token='.$res[0]['activation_code'].'&id='.$res[0]['id'].'">http://'.$_SERVER['HTTP_HOST'].'/workshops/verfiyEmail.php?token='.$res[0]['activation_code'].'&id='.$res[0]['id'].'</a>';
    $body .="<br /><br /><br /> <i>جامعه بابل - مركز الوسائط المتعددة و التعليم الالكتروني</i></p>";
    $body .="<br /> <i>University of Babylon - Multimedia Center and e-Learning</i>" ;
    sendEmail($res[0]['email'],$sub,$body);

  }
}else{
  $error = [
           'name_err'=> implode($v->errors()->get('name')),
           'email_err'=>implode($v->errors()->get('email')),
           'password_err'=>implode($v->errors()->get('password')),
           ];
}
}catch(PDOException $ex){
   $error = $ex;
   $success=0;
}
ob_end_clean();
echo json_encode(['success'=>$success, 'error'=>$error]);
?>