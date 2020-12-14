<?php

include 'includes/MysqliDb.php';
include 'includes/common.php';
include 'includes/class.phpmailer.php';

$mysqli = new Mysqlidb ("localhost", "root", "", "confab_intext_nseit");

DEFINE("SOYBEAN_PRICES", "confab_intext_nseit.nse_international_prices");

$message="
<!DOCTYPE html>
<html>
<head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
table, th, td {
  border-collapse: collapse;
  text-align: center;
  padding: 5px;
  font-family: 'Roboto', arial !important;
  font-size:12px;

}
th{
    background-color: #E9967A;
}

</style>
</head>
<body>
<table cellpadding='5' cellspacing='0' border='0' style='width:100% !important; border: 0px; border-collapse: collapse; text-align: left; color:#222; font-family: Roboto, arial;'>
  <tr>
      <td style='text-align:left; border: 0px !important;' >Dear Sir,</td>
  </tr>
  <tr>
      <td style='text-align:left; border: 0px !important;'>Please find the International price differences of Agri-Soybean Oil - NSE with NCDEX - Refined & CBOT</td>
  </tr>
</table><br>
<table cellpadding='5' cellspacing='0' border='1' style='width:100%; border: 1px solid black; border-collapse: collapse; text-align: center; color:#222; font-family: Roboto, arial;'>

        <tr>
            <th colspan='7' style='background-color:#D2691E;' >Agri- Soybean Oil</th>            
        </tr>
        <tr style='background-color:#E9967A;'>
            <th>Date</th>
            <th>NSE</th>
            <th>NCDEX - Refined</th>
            <th>CBOT</th>
            <th>NSE (% time return)</th>
            <th>NCDEX - Refined  (% time return)</th>
            <th>CBOT  (% time return)</th>
        </tr>";

    $t=1607538600;
    //$t=strtotime(date(Ymd));
    //$mysqli->where("post_date",$t);
    $mysqli->where("category","2");
    $mysqli->orderBy("raw_date", "desc");
    
    
    
    $soybean_oil_price = $mysqli->get("confab_intext_nseit.nse_international_prices","9");
    if(isset($soybean_oil_price) && count($soybean_oil_price) > 1){
    echo "<pre>";
    print_r ($soybean_oil_price);
    echo "</pre>";
    //row 1
    $date_R1_C1_date=$soybean_oil_price[6]["raw_date"];
    $price_R1_C2_nse=$soybean_oil_price[8]["price"];
    $price_R1_C3_ncdex=$soybean_oil_price[7]["price"];
    $price_R1_C4_cbot=$soybean_oil_price[6]["price"];
    echo $date_R1_C1_date;
    echo $price_R1_C2_nse;
    echo $price_R1_C3_ncdex;
    echo $price_R1_C4_cbot;
    echo "<br>";
    //row 2
    $date_R2_C1_date=$soybean_oil_price[3]["raw_date"];
    $price_R2_C2_nse=$soybean_oil_price[5]["price"];
    $price_R2_C3_ncdex=$soybean_oil_price[4]["price"];
    $price_R2_C4_cbot=$soybean_oil_price[3]["price"];
    
    echo $date_R2_C1_date;
    echo $price_R2_C2_nse;
    echo $price_R2_C3_ncdex;
    echo $price_R2_C4_cbot;
    echo "<br>";
    //row 3
    $date_R3_C1_date=$soybean_oil_price[0]["raw_date"];
    $price_R3_C2_nse=$soybean_oil_price[2]["price"];
    $price_R3_C3_ncdex=$soybean_oil_price[1]["price"];
    $price_R3_C4_cbot=$soybean_oil_price[0]["price"];
    echo $date_R3_C1_date;
    echo $price_R3_C2_nse;
    echo $price_R3_C3_ncdex;
    echo $price_R3_C4_cbot;
   //
   $nse_per_R2_C5=($price_R2_C2_nse-$price_R1_C2_nse)/$price_R1_C2_nse;
   $nse_per_R3_C5=($price_R3_C2_nse-$price_R2_C2_nse)/$price_R2_C2_nse;
   $ncdex_per_R2_C6=($price_R2_C3_ncdex-$price_R1_C3_ncdex)/$price_R1_C3_ncdex;
   $ncdex_per_R3_C6=($price_R3_C3_ncdex-$price_R2_C3_ncdex)/$price_R2_C3_ncdex;
   $cbot_per_R2_C7=($price_R2_C4_cbot-$price_R1_C4_cbot)/$price_R1_C4_cbot;
   $cbot_per_R3_C7=($price_R3_C4_cbot-$price_R2_C4_cbot)/$price_R2_C4_cbot;
   //if(isset($soybean_oil_price) && count($soybean_oil_price) > 1){
     // echo "test";

                    $optHtml = "";
                    $optHtml .= '<tr style="display:none;">';
                    $optHtml .= '<td style="width:80px;">'. $date_R1_C1_date.'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($price_R1_C2_nse,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($price_R1_C3_ncdex,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($price_R1_C4_cbot,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. "-" .'</td>';
                    $optHtml .= '<td style="width:80px;">'."-".'</td>';
                    $optHtml .= '<td style="width:80px;">'."-".'</td>';
                    $optHtml .= '</tr>';
                    $optHtml .= '<tr>';
                    $optHtml .= '<td style="width:80px;">'. $date_R2_C1_date.'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($price_R2_C2_nse,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($price_R2_C3_ncdex,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($price_R2_C4_cbot,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($nse_per_R2_C5,2)."%".'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($ncdex_per_R2_C6,2)."%".'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($cbot_per_R2_C7,2) ."%".'</td>';
                    $optHtml .= '</tr>';
                    $optHtml .= '<tr>';
                    $optHtml .= '<td style="width:80px;">'. $date_R3_C1_date.'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($price_R3_C2_nse,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($price_R3_C3_ncdex,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($price_R3_C4_cbot,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($nse_per_R3_C5,2)."%".'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($ncdex_per_R3_C6,2)."%".'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($cbot_per_R3_C7,2)."%".'</td>';
                    $optHtml .= '</tr>';

                    $message.=$optHtml;

               
                    
            
          

     $message.="</table>
        <br><br>
        <table cellpadding='5' cellspacing='0' border='0' style='width:100% !important; border: 0px; border-collapse: collapse; text-align: left; color:#222; font-family: Roboto, arial;'>
        <tr>
            <td style='text-align:left; border: 0px !important;' >Warm regards</td>
        </tr>
      </table>
      </body>
      </html>";

    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->Mailer = PHPMAILER_PROTOCOL;
    $mail->SMTPDebug = 0; // debugging: 0 =  off errors, 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = PHPMAILER_SSL; // secure transfer enabled REQUIRED for GMail
    $mail->Host = PHPMAILER_HOST;
    $mail->Port = PHPMAILER_PORT; // or 587
    $mail->IsHTML(true);
    $mail->Username = PHPMAILER_EMAILID;
    $mail->Password = PHPMAILER_EMAILID_PASS;
    $mail->SetFrom(PHPMAILER_FROM, PHPMAILER_FROM_NAME, true);
    $mail->Subject = "International Price difference Agri-Soybean Oil - Test";
    

    $mail->AddAddress('apandit@nse.co.in');
    
    $mail->AddCC('dl-surv-all@nse.co.in');
    $mail->AddCC('anshul.singh@pinstorm.com');
    $mail->AddCC('nitin.jadhav@pinstorm.com');
    $mail->AddCC('jayesh@pinstorm.com');
    $mail->AddCC('carlyle.oliver@pinstorm.com');
    $mail->AddCC('nikhil@pinstorm.com');
    

   


    $mail->MsgHTML($message);
   }
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent.';

    }

?>