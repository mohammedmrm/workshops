<?php
ob_start();
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_access.php");
//access([1,2,3,4,5,6,7,8,9,10,11,12,15]);
$id = $_REQUEST['id'];
require_once("dbconnection.php");
try{
  if($id > 0){
  $query = "select workshops.*,if(a.enrolled is null,0, a.enrolled) as enrolled, offices.name as office from workshops
   inner join offices on offices.id = workshops.office_id
   left join(
    SELECT COUNT(*) as enrolled, workshop_id from enrollment GROUP by enrollment.workshop_id
   ) a on a.workshop_id = workshops.id
   where workshops.id=?
   ";
  $data = getData($con,$query,[$id]);
  if($data[0]['seat'] > $data[0]['enrolled'] && $data[0]['loc'] != 1 /*&& $data[0]['start_date'] >= date('Y-m-d h:i:s')*/){
    $sql = "select * from enrollment where user_id=? and workshop_id=?";
    $data = getData($con,$sql,[$_SESSION['userid'],$id]);
    if(count($data) == 0){
      $sql = "insert into enrollment (workshop_id,user_id) values (?,?)";
      $res = setData($con,$sql,[$id,$_SESSION['userid']]);
       $success="1";
       $msg = "تم التسجيل بنجاح";
    }else{
      $msg = "انت مسجل مسبقاً ضمن هذا النشاط";
    }
  }else{
     $msg = "لا يمكن التسجيل على هذا النشاط";
  }

  }
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
   $msg = "حدث خطأ حاول مرة اخرى لاحقاً";
}
ob_end_clean();
echo (json_encode(array($sql,"success"=>$success,'msg'=>$msg,"data"=>$data)));
?>