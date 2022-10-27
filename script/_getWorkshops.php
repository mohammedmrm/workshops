<?php
ob_start();
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
error_reporting(0);
require_once("_access.php");
require_once("dbconnection.php");
$name = $_REQUEST['name'];
$office = $_REQUEST['office'];
$cat = $_REQUEST['cat'];
$date = $_REQUEST['date'];
$limit = 9;
$page = trim($_REQUEST['p']);
if(empty($page) || $page <=0){
  $page =1;
}
try{
  $query = "select workshops.*,
           DATE_FORMAT(start_date, '%m/%d %H:%i') as start,
           DATE_FORMAT(end_date, '%m/%d %H:%i') as end,
           if(a.enrolled is null,0, a.enrolled) as enrolled,
           offices.name as office from workshops
           inner join offices on workshops.office_id = offices.id
           left join(
            SELECT COUNT(*) as enrolled, workshop_id from enrollment GROUP by enrollment.workshop_id
           ) a on a.workshop_id = workshops.id
           ";

  $count = "select count(*) as count from workshops inner
  join offices on workshops.office_id = offices.id";
  $where = " where ";
  $f = "";
  if(!empty($name)){
     $f .= " and workshops.name like '%".$name."%'";
  }
  if(!empty($office) && $office > 0 ){
     $f .= " and workshops.office_id =".$office;
  }
  if(!empty($cat) && $cat > 0 ){
     $f .= " and workshops.category_id =".$cat;
  }
  if(!empty($date)){
     $f .= " and workshops.start_date >= ".$date;
  }
  if($f != ""){
    $f = preg_replace('/^ and/', '', $f);
    $f = $where." ".$f;
    $query .= " ".$f;
    $count .= " ".$f;
  }
  $query .=  " order by workshops.id DESC";
  $res = getData($con,$count);
  $pages= ceil($res[0]['count'] / $limit);
  $lim = " limit ".(($page-1) * $limit).",".$limit;
  $data = getData($con,$query.$lim);
  $success="1";
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
ob_end_clean();
echo (json_encode(array("success"=>$success,"data"=>$data,"pages"=>$pages,"page"=>$page)));
?>