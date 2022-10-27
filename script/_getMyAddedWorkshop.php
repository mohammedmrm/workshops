<?php
ob_start(); 
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
//access([1,2,3,4,5,6,7,8,9,10,11,12,15]);
require_once("dbconnection.php");
$limit = 10;
$page = trim($_REQUEST['p']);
if(empty($page) || $page <=0){
  $page =1;
}
try{
  $query = "select workshops.*,offices.name as office from workshops
  left join offices on workshops.office_id = offices.id
  where workshops.user_id = ?";
  $count = "select count(*) as count from workshops where workshops.user_id = ?";

  $res = getData($con,$count,[$_SESSION['userid']]);
  $pages= ceil($res[0]['count'] / $limit);
  $lim = " limit ".(($page-1) * $limit).",".$limit;
  $data = getData($con,$query.$lim,[$_SESSION['userid']]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
ob_end_clean();
echo (json_encode(array("success"=>$success,"data"=>$data,"pages"=>$pages,"page"=>$page)));
?>