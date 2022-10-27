<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1]);
require_once("dbconnection.php");
require_once("_crpt.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;
$success = 0;
$error = [];
$id        = $_SESSION['userid'];
$name      = $_REQUEST['name'];
$email     = $_REQUEST['email'];
$password  = $_REQUEST['password'];

$v->addRuleMessage('unique', 'القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('unique', function($value, $input, $args) {
    $exists = getData($GLOBALS['con'],"SELECT * FROM users WHERE email ='".$value."' and id !='".$GLOBALS['id']."'");
    return  ! (bool) count($exists);
});
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموح بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى ',
    'email'      => 'البريد الالكتروني غيز صحيح',
]);

$v->validate([
    'id'      => [$id,      'required|int'],
    'name'    => [$name,    'required|min(4)|max(200)'],
    'email'   => [$email,   'required|email'],
    'password'=> [$password,"min(6)|max(18)"],
]);

if($v->passes()) {
   if(empty($password)){
   $sql = 'update users set email=? where id=?';
   $result = setData($con,$sql,[$email,$id]);
   }else{
   $password= hashPass($password);
   $sql = 'update users set password=?, email=? where id=?';
   $result = setData($con,$sql,[$password,$email,$id]);
   }
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'name_err'=> implode($v->errors()->get('name')),
           'email_err'=>implode($v->errors()->get('email')),
           'password_err'=>implode($v->errors()->get('password')),
           ];
}
echo json_encode(['success'=>$success, 'error'=>$error,$_POST]);
?>