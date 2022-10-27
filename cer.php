<?php
ob_start();
session_start();
//error_reporting(0);
require_once("script/_access.php");
require_once("script/dbconnection.php");


$workshop_id = $_REQUEST['workshop'];
$title = $_REQUEST['title'];
$sql = "select * from enrollment where user_id=? and workshop_id=?";
$res = getData($con, $sql, [$_SESSION['userid'], $workshop_id]);
if ($res[0]['download_cer'] != 1) {
  die("لا يمكن تحميل الشهادة");
}
$style = '
  <style>
    td,th{
      text-align:center;
      vertical-align: middle;
      white-space: nowrap;
    }
    .head-tr {
     background-color: #FFCCFF;
     color:#111;
    }
  .bg{
     direction: rtl !important;
     text-align: center;
  }
  </style>';

$sql = "select workshops.*,users.*,categories.id as cat_id, offices.name as office ,workshops.name as workshop,categories.name as cat,
         DATE_FORMAT(workshops.start_date, '%Y-%m-%d') as start_date,
         DATE_FORMAT(workshops.end_date, '%Y-%m-%d') as end_date,with_office.name as with_name
        from workshops
        inner join offices on workshops.office_id = offices.id
        inner join enrollment on enrollment.workshop_id = workshops.id
        inner join users on enrollment.user_id = users.id
        left join offices with_office on with_office.id = workshops.with_office
        inner join categories on workshops.category_id = categories.id
        where enrollment.user_id=? and workshops.id = ? limit 1";
$data = getData($con, $sql, [$_SESSION['userid'], $workshop_id]);
require_once("tcpdf/tcpdf.php");
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{
  //Page header
  public function Header()
  {
    $data = $GLOBALS['data'];
    // get the current page break margin
    $bMargin = $this->getBreakMargin();
    // get current auto-page-break mode
    $auto_page_break = $this->AutoPageBreak;
    // disable auto-page-break
    $this->SetAutoPageBreak(false, 0);
    // set bacground image
    if ($data[0]['cat_id']  == 1) {
      $img_file = $data[0]['cer_bg'] !== "_" ? 'img/' . $data[0]['cer_bg'] : 'assets/images/border2.png';
    } else {
      $img_file = $data[0]['cer_bg'] !== "_" ? 'img/' . $data[0]['cer_bg'] : 'assets/images/border1.png';
    }
    $this->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
    // restore auto-page-break status
    $this->SetAutoPageBreak($auto_page_break, $bMargin);
    // set the starting point for the page content
    $this->setPageMark();
  }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($data[0]['office']);
$pdf->SetTitle($data[0]['name']);
$pdf->SetSubject($data[0]['workshop']);
$pdf->SetKeywords('Certifcate');

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


// set margins
$pdf->SetMargins(20, PDF_MARGIN_TOP, 15);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
$lg = array();
$lg['a_meta_charset'] = 'UTF-8';
//$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'ar';
$lg['w_page'] = 'page';

// set some language-dependent strings (optional)
$pdf->setLanguageArray($lg);
// set font


// add a page
$pdf->AddPage("L", "A4");

$name1 = $data[0]['name1'] ? $data[0]['name1'] : "أ.د محمد منصور كاظم";
$name2 = $data[0]['name2'] ? $data[0]['name2'] : "";
$job1 = $data[0]['job1'] ? $data[0]['job1'] : "مساعد رئيس الجامعة للشوؤن العلمية";
$job2 = $data[0]['job2'] ? $data[0]['job2'] : "";
$sig1 = $data[0]['sig1'] !== "_" ? $data[0]['sig1'] : "../assets/images/esam.png";
$sig2 = $data[0]['sig2'] !== "_" ? $data[0]['sig2'] : "";
$space = $data[0]['space'] > 0  ? $data[0]['sig2'] : 300;
$paddingtop = $data[0]['space'] > 0  ? $data[0]['paddingtop'] : 150;
$textSize = $data[0]['textSize'] > 0  ? $data[0]['textSize'] : 160;
$header = '<table>
             <tr style="text-align:left;">
                    <td  width="200" style="width="200"text-align:left;">
                    </td>
                    <td width="500" style="text-align:center;height:' . $paddingtop . ';"></td>
                    <td width="200" style="text-align:center;">
                    </td>
             </tr>
            </table>';
$footer =
  '<table>
        <tr>
                <td style="text-align:center;height:50px !important;" height="50">
                  <img src = "img/' . $sig1 . '" width="150"  height="50">
                  <br /> ' . $name1 . ' <br />' . $job1 . '
                </td>
                <td rowspan="2" width="' . $space . '"></td>
                <td style="text-align:center;height:50px!important;"  height="50">
                  <img src = "img/' . $sig2 . '" width="150"  height="50px"> 
                  <br /> ' . $name2 . ' <br /> ' . $job2 . '
                </td>
        </tr>
      </table>
';
if ($data[0]['cat_id']  == 1) {
  $pdf->SetFont('aealarabiya', '', 30);
  $pdf->writeHTML($style . $header, true, false, true, false, 'J');
  $htmlpersian .= '<div class="bg"><table ><tr><td width="890" height="' . $textSize . '">';
  $htmlpersian .= '<center>';
  $htmlpersian .= 'نؤيد لكم  اجتياز ' . $title . " " . $data['0']['name'] . "    " . $data[0]['cat'] . " " . $data[0]['workshop'] .
    " المقامة في " . $data['0']['office'] . " بالتعاون مع " . $data['0']['with_name'];
  $htmlpersian .= " للفترة من " . $data[0]['start_date'] . " الى " . $data[0]['end_date'];
  $htmlpersian .= "</center>";
  $htmlpersian .= '</td></tr></table>';
  $htmlpersian .= '</div>';
  $pdf->SetFont('aefurat', '', 20);
  $pdf->writeHTML($style . $htmlpersian, true, false, true, false, 'J');
  $pdf->SetFont('aefurat', '', 18);
  $pdf->writeHTML($style . $footer, true, false, true, false, 'J');
} else {
  $pdf->SetFont('aealarabiya', '', 30);
  $pdf->writeHTML($style . $header, true, false, true, false, 'J');
  $htmlpersian .= '<div class="bg"><table ><tr><td width="890" height="160">';
  $htmlpersian .= '<center>';
  $htmlpersian .= 'نؤيد لكم  مشاركة ' . $title . " " . $data['0']['name'] . "  في  " . $data[0]['cat'] . "  " . $data[0]['workshop'] .
    " المقامة في " . $data['0']['office'] . " بالتعاون مع " . $data['0']['with_name'];
  $htmlpersian .= " بتاريخ " . $data[0]['start_date'];
  $htmlpersian .= "</center>";
  $htmlpersian .= '</td></tr></table>';
  $htmlpersian .= '</div>';
  $pdf->SetFont('aefurat', '', 20);
  $pdf->writeHTML($style . $htmlpersian, true, false, true, false, 'J');
  $pdf->SetFont('aefurat', '', 18);
  $pdf->writeHTML($style . $footer, true, false, true, false, 'J');
}


// --- example with background set on page ---

// remove default header
$pdf->setPrintHeader(false);

// ---------------------------------------------------------

//Close and output PDF document
//$pdf->Output('example_051.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
//Close and output PDF document
ob_clean();
$pdf->Output('cer' . date('Y-m-d h:i:s') . '.pdf', 'I');
