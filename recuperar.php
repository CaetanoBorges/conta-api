<?php
require('classes/_email/PHPMailerAutoload.php');

$mail = new PHPMailer();
$enviar = enviaNumeroDeRecuperacao($mail, $numero);
if($enviar){
    echo 1;
}else{
    echo 0;
}