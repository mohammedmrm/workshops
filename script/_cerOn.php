<?php
ob_start(); 
session_start();
header('Content-Type: application/json');
//error_reporting(0);
require_once("_access.php");
//access([1,2,3,4,5,6,7,8,9,10,11,12,15]);
require_once("dbconnection.php");
$ids = $_REQUEST['ids'];
$workshop_id = $_REQUEST['id'];
try{
  $f=0;
  foreach ($ids as $id){
    if($id > 1){
      $f .= ' or enrollment.user_id = '.$id.' ';
    }
  }
  $f = ' ('.preg_replace('/^ or/', '', $f).') ';

  $query = "update enrollment set download_cer=1 where workshop_id=? and ".$f;
  $data = setData($con,$query,[$workshop_id]);
  $success=1;
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
ob_end_clean();
echo (json_encode(array($_REQUEST,"success"=>$success,"data"=>$data)));
?>