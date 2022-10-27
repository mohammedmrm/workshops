<?php
ob_start(); 
session_start();
header('Content-Type: application/json');
require_once("_access.php");
//access([1,2,3,4,5,6,7,8,9,10,11,12,15]);
$id = $_REQUEST['id'];
require_once("dbconnection.php");
try{
  if($id > 0){
  $query = "select workshops.*,if(a.enrolled is null,0, a.enrolled) as enrolled,
    offices.name as office,with_office.name as with_name
    from workshops
   inner join offices on offices.id = workshops.office_id
   left join offices with_office on with_office.id = workshops.with_office
   left join(
    SELECT COUNT(*) as enrolled, workshop_id from enrollment GROUP by enrollment.workshop_id
   ) a on a.workshop_id = workshops.id
   where workshops.id=?
   ";
  $data = getData($con,$query,[$id]);
  $success="1";
  }
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
ob_end_clean();
echo (json_encode(array("success"=>$success,"data"=>$data)));
?>