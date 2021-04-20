<?php



function enviaNumeroDeRecuperacao($mail, $numero){

    $corpo=`

    `;

    // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 0;           // Enable verbose debug output
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;   // Enable SMTP authentication
        $mail->Username = "debliw.ao@gmail.com";         // SMTP username
        $mail->Password = "antesdemimDeus";           // SMTP password
        $mail->SMTPSecure = 'ssl';// Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;// TCP port to connect to

        //Recipients
        $mail->setFrom("debliw.ao@gmail.com", "www.com");
        //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addAddress($email_cliente);   // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);          // Set email format to HTML
        $mail->Subject = "Código para recuperar palavra-passe";
        $mail->Body    = $corpo;
        $mail->AltBody = $corpo;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}