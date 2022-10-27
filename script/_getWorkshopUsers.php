<?php
ob_start(); 
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
//access([1,2,3,4,5,6,7,8,9,10,11,12,15]);
require_once("dbconnection.php");
$id = $_REQUEST["id"];
$name = $_REQUEST["name"];
$page = trim($_REQUEST['p']);
if(empty($page) || $page <=0){
  $page =1;
}
try{
  $query = "select users.*,enrollment.download_cer from users
  inner join enrollment on enrollment.user_id = users.id
  where enrollment.workshop_id=?
  ";
  $f = "";
  if(!empty($name)){
     $f .= " and users.name like '%".$name."%' ";
  }
  if($f != ""){
    $query .= " ".$f;
  }
  $data = getData($con,$query,[$id]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
ob_end_clean();
echo (json_encode(array($id,"success"=>$success,"data"=>$data)));
?>