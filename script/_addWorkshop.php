<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("_sendEmail.php");
require_once("_vaildImg.php");

use Violin\Violin;

require_once('../validator/autoload.php');
$v = new Violin;

try {
  $success = 0;
  $error = [];
  $name    = $_REQUEST['name'];
  $sub_office   = $_REQUEST['sub_office'];
  $url   = $_REQUEST['url'];
  $des   = $_REQUEST['desc'];
  $sig1   = $_FILES['sig1'];
  $sig2   = $_FILES['sig2'];
  $cer_bg   = $_FILES['cer_bg'];
  $name1   = $_REQUEST['name1'];
  $name2   = $_REQUEST['name2'];
  $job1   = $_REQUEST['job1'];
  $job2   = $_REQUEST['job2'];

  $space  = $_REQUEST['space'];
  $paddingTop   = $_REQUEST['paddingTop'];
  $textSize  = $_REQUEST['textSize'];


  if (empty($with)) {
    $with = 1;
  }
  $start   = $_REQUEST['start'] . ":00";
  $end   = $_REQUEST['end'] . ":00";
  $seat   = $_REQUEST['seat'];
  if (empty($seat) || $seat == 0) {
    $seat = 1000;
  }
  $cat   = $_REQUEST['cat'];
  $result = 0;
  //------------------==datetime validation-------------------------------
  $now = date("Y-m-d H:i:s");
  function validateDate($date, $format = 'Y-m-d H:i:s')
  {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
  }
  $start_err = "";
  $end_err = "";
  if (!validateDate($start)) {
    $start_err = "الوقت و التاريخ غير صالح";
  }
  if (!validateDate($end)) {
    $end_err = "الوقت و التاريخ غير صالح";
  }

  if ($start_err == "" && $start >= $now) {
    $start_err = "";
  } else {
    $start_err = "الوقت و التاريخ يجب ان يكون بعد الوقت الحالي";
  }
  if ($start_err == "" && $start <= $end) {
    $end_err = "";
  } else {
    $end_err = "تاريخ النهاية يجب ان يكون بعد تاريخ البدأ";
  }
  $v->addRuleMessage('isUrl', 'الرابط المدخل غير صالح');
  $v->addRule('isUrl', function ($value, $input, $args) {
    if (filter_var($value, FILTER_VALIDATE_URL)) {
      $x = 1;
    } else {
      $x = 0;
    }
    return   $x;
  });
  $v->addRuleMessage('isImg', 'صوره غير صالحه');
  $v->addRule('isImg', function ($value, $input, $args) {
    $x = image($value);
    return   $x;
  });
  $v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'كبير جدأً',
    'email'      => 'البريد الالكتروني غيز صحيح',
  ]);

  $v->validate([
    'name'       => [$name,    'required|min(4)|max(1000)'],
    'sub_office' => [$sub_office, 'max(1000)'],
    'des'        => [$des,   'max(3000)'],
    'url'        => [$url,   'isUrl|max(2000)'],
    'seat'       => [$seat,  'int|min(1)|max(4)'],
    'cat'        => [$cat,  'required|int'],
    'with'       => [$with,  'required|int'],
    'name1'      => [$name1,  'min(5|max(100)'],
    'name2'      => [$name2,  'min(5|max(100)'],
    'sig1'       => [$sig1,  'isImg'],
    'sig2'       => [$sig2,  'isImg'],
    'cer_bg'     => [$cer_bg, 'isImg'],
    'job1'       => [$job1,  'min(5)|max(100)'],
    'job2'       => [$job2,  'min(5)|max(100)'],
    'space'      => [$space,  'int'],
    'textSize'   => [$textSize,  'int'],
    'paddingTop' => [$paddingTop,  'int'],
  ]);

  if ($v->passes() && $start_err == "" && $end_err == "") {
    $sql = "select * from users where id=?";
    $res = getData($con, $sql, [$_SESSION['userid']]);
    if ($sig1['size'] !== 0) {
      $id = uniqid() . Date('Y-m-d') . '-sig1';
      mkdir("../img/", 0700);
      $destination = "../img/" . $id . '.' . end((explode(".", $sig1["name"])));
      $sig1Path = $id . '.' . end((explode(".", $sig1["name"])));
      move_uploaded_file($sig1["tmp_name"], $destination);
    } else {
      $sig1Path = "_";
    }
    if ($sig2['size'] !== 0) {
      $id = uniqid() . Date('Y-m-d') . '-sig2';
      $destination = "../img/" . $id . '.' . end((explode(".", $sig2["name"])));
      $sig2Path = $id . '.' . end((explode(".", $sig2["name"])));
      move_uploaded_file($sig2["tmp_name"], $destination);
    } else {
      $sig2Path = "_";
    }
    if ($cer_bg['size'] !== 0) {
      $id = uniqid() . Date('Y-m-d') . '-cer_bg';
      $destination = "../img/" . $id  . '.' . end((explode(".", $cer_bg["name"])));
      $cer_bgPath = $id . '.' . end((explode(".", $cer_bg["name"])));
      move_uploaded_file($cer_bg["tmp_name"], $destination);
    } else {
      $cer_bgPath = "_";
    }
    if (count($res)) {
      $sql = 'insert into workshops (name,sub_office,des,office_id,category_id,
                start_date,end_date,link,seat,user_id,with_office,
                sig1,sig2,name1,name2,job1,job2,cer_bg,
                space,textSize,paddingTop
                ) values
                (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
      $result = setDataWithLastID(
        $con,
        $sql,
        [
          $name, $sub_office, $des, $res[0]['office_id'], $cat,
          $start, $end, $url, $seat, $_SESSION['userid'], $with,
          $sig1Path, $sig2Path, $name1, $name2, $job1, $job2, $cer_bgPath,
          $space, $textSize, $paddingTop
        ]
      );
      $success = 1;
    } else {
      $success = 0;
    }
  } else {
    $error = [
      'name_err' => $v->errors()->get('name'),
      'des_err' => $v->errors()->get('des'),
      'url_err' => $v->errors()->get('url'),
      'cat_err' => $v->errors()->get('cat'),
      'with_err' => $v->errors()->get('with'),
      'sub_office_err' => $v->errors()->get('sub_office'),
      'seat_err' => $v->errors()->get('seat'),
      'sig1_err' => $v->errors()->get('sig1'),
      'sig2_err' => $v->errors()->get('sig2'),
      'name1_err' => $v->errors()->get('name1'),
      'name2_err' => $v->errors()->get('name2'),
      'job1_err' => $v->errors()->get('job1'),
      'job2_err' => $v->errors()->get('job2'),
      'cer_bg_err' => $v->errors()->get('cer_bg'),
      'paddingTop_err' => $v->errors()->get('paddingTop'),
      'space_err' => $v->errors()->get('space'),
      'textSize_err' => $v->errors()->get('textSize'),
      'start_err' => $start_err,
      'end_err' => $end_err,
    ];
  }
} catch (PDOException $ex) {
  $error = $ex;
  $success = 0;
}
ob_end_clean();
echo json_encode([$_REQUEST, $_FILES, 'success' => $success, "workshop" => $result, 'error' => $error]);
