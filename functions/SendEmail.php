<?php
// Establish Connection to Database
function SEND_MAIL($useremail,$value) {

    require("PHPMailer-master/PHPMailerAutoload.php"); //or select the proper destination for this file if your page is in some   //other folder
    ini_set("SMTP","ssl://smtp.gmail.com"); 
    ini_set("smtp_port","465"); //No further need to edit your configuration files.
    $mail = new PHPMailer();
    $mail->isSMTP();  // telling the class to use SMTP
    $mail->SMTPAuth = true;
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->SMTPSecure = "ssl";
    $mail->Username = "Husen.dict19@sot.pdpu.ac.in"; //account with which you want to send mail. Or use this account. i dont care :-P
    $mail->Password = "I Can't Tell You ,Sorry"; //this account's password.
    $mail->Port = "465";
    $rec1=$useremail; //receiver. email addresses to which u want to send the mail.
    $mail->AddAddress($rec1);
    $mail->Subject  = "PHP Thankyou :)";
    $mail->Body     = "Your Social Book Pin is This:".$value." \n Thanks For Making Account :)";
    $mail->WordWrap = 200;

    $mail->Send();
}

?>