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
$success = 0;
$error = [];
$name    = $_REQUEST['name'];
$email   = $_REQUEST['email'];
$password   = $_REQUEST['password'];
$type   = $_REQUEST['type'];
$office   = $_REQUEST['office'];
$v->addRuleMessage('unique', 'القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('unique', function($value, $input, $args) {
    $value  = trim($value);
    $exists = getData($GLOBALS['con'],"SELECT * FROM users WHERE email  = ?",[$value]);
    return ! (bool) count($exists);
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
    'email'   => [$email,   'required|unique|email'],
    'name'    => [$name,   'required|min(4)|max(200)'],
    'password'=> [$password,'required|min(8)|max(20)'],
    'type'    => [$type,'required|int|max(1)'],
    'office'  => [$office,'required|int']
]);
try{
if($v->passes()) {
  $pass = hashPass($password);
  $sql = 'insert into users (name,email,password,role_id,office_id,active) values
                             (?,?,?,?,?,?)';
  $result = setData($con,$sql,[$name,$email,$pass,$type,$office,1]);
  $success = 1;

}else{
  $error = [
           'name_err'=> $v->errors()->get('name'),
           'email_err'=>($v->errors()->get('email')),
           'password_err'=>($v->errors()->get('password')),
           'type_err'=>($v->errors()->get('type')),
           'office_err'=>($v->errors()->get('office'))
           ];
}
}catch(PDOException $ex){
   $error = $ex;
   $success=0;
}
ob_end_clean();
echo json_encode(['success'=>$success, 'error'=>$error]);
