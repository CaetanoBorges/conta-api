<?php
use PHPMailer\PHPMailer\PHPMailer;

function seisDigitos(){
    return mt_rand(100000,999999);
}

function enviaEmail($mail, $email, $titulo, $corpo, $confPath = "email.conf.json"){
    $conf = file_get_contents($confPath);

    $configuracao = (array) json_decode($conf);
    
    // Passing `true` enables exceptions
    //Server settings
    $mail->SMTPDebug = 0;           // Enable verbose debug output
    $mail->isSMTP();  // Set mailer to use SMTP
    $mail->Host = $configuracao['servidor'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;   // Enable SMTP authentication
    $mail->Username = $configuracao['usuario'];         // SMTP username
    $mail->Password = $configuracao['palavra_passe'];           // SMTP password
    $mail->SMTPSecure = $configuracao['seguranca'];// Enable TLS encryption, `ssl` also accepted
    $mail->Port = $configuracao['porta'];// TCP port to connect to

    //Recipients
    $mail->setFrom($configuracao['usuario'], $configuracao['nome']);
    //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress($email);   // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);          // Set email format to HTML
    $mail->Subject = utf8_decode($titulo);
    $mail->Body    = $corpo;
    $mail->AltBody = $corpo;

    
    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}