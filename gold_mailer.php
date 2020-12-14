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
      <td style='text-align:left; border: 0px !important;'> Please find the International price differences of Non-Agri-Gold - NSE with MCX & XAU</td>
  </tr>
</table><br>
<table cellpadding='5' cellspacing='0' border='1' style='width:100%; border: 1px solid black; border-collapse: collapse; text-align: center; color:#222; font-family: Roboto, arial;'>

        <tr>
            <th colspan='9' style='background-color:#D2691E;' >Deviation Between International v/s Domestic future prices</th>            
        </tr>
        <tr style='background-color:#E9967A;'>
            <th>Symbol</th>
            <th>Date</th>
            <th>NSE</th>
            <th>MCX</th>
            <th>XAU</th>
            <th>Difference  between NSE & MCX (in Rs.)</th>
            <th>Difference between NSE & XAU (in Rs.)</th>
            <th>Difference  between NSE & MCX(in %)</th>
            <th>Difference  between NSE & XAU (in %)</th>
            
        </tr>";

    $t=1607538600;
    //$t=strtotime(date(Ymd));
    //$mysqli->where("post_date",$t);
    $mysqli->where("category","1");
    $mysqli->orderBy("raw_date", "desc");
    
    
    
    $gold_price = $mysqli->get("confab_intext_nseit.nse_international_prices","3");
    if(isset($gold_price) && count($gold_price) > 1){
    echo "<pre>";
    print_r ($gold_price);
    echo "</pre>";
    $R1_C1=$gold_price[0]["commodity"];
    $R1_C2=$gold_price[0]["raw_date"];
    $R1_C3=$gold_price[0]["price"];
    $R1_C4=$gold_price[1]["price"];
    $R1_C5=$gold_price[2]["price"];
    $dif_nse_mcx=($R1_C3-$R1_C4);
    $dif_nse_xau=($R1_C3-$R1_C5);
    $per_dif_mcx_nse=(1-$R1_C4/$R1_C3)*100;

    $per_dif_xau_nse=(1-$R1_C5/$R1_C3)*100;

    echo $R1_C1;
    echo $R1_C2;
    echo $R1_C3;
    echo $R1_C4;
    echo $R1_C5;
   //if(isset($gold_price) && count($gold_price) > 1){
     // echo "test";

                    $optHtml = "";

                    $optHtml .= '<tr>';
                    $optHtml .= '<td style="width:80px;">'. $R1_C1.'</td>';
                    $optHtml .= '<td style="width:80px;">'. $R1_C2 .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($R1_C3,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($R1_C4,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($R1_C5,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($dif_nse_mcx,2) .'</td>';
                    $optHtml .= '<td style="width:80px;">'. number_format($dif_nse_xau,2) .'</td>';
                    $color = ($dif_nse_mcx > 0 ) ?  "blue" : (($dif_nse_mcx <  0 )  ?  "red": "black");  
                    $optHtml .= '<td style="width:80px; color:'.$color.';">'. number_format($per_dif_mcx_nse,2) ."%".'</td>';
                     
                    $color = ($dif_nse_xau > 0 ) ?  "blue" : (($dif_nse_xau <  0 )  ?  "red": "black");   
                  
                    $optHtml .= '<td style="width:80px; color:'.$color.';">'. number_format($per_dif_xau_nse,2) ."%".'</td>';
                   
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
      echo $message;
      

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
    $mail->Subject = "International Price difference Non-Agri-Gold - Test";
    



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