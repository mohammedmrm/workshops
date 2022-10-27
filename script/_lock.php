<?php
ob_start();
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_access.php");
access([1,2]);
require_once("dbconnection.php");
$workshop_id = $_REQUEST['id'];
try{
  $query = "update workshops set loc=1 where id=? and user_id = ?";
  $data = setData($con,$query,[$workshop_id,$_SESSION['userid']]);
  $success=1;
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
ob_end_clean();
echo (json_encode(array($_REQUEST,"success"=>$success,"data"=>$data)));
?>