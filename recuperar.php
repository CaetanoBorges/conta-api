<?php
use PHPMailer\PHPMailer\PHPMailer;
//Load Composer's autoloader
require '../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");


if(isset($_POST['email'])){
    
    include('classes/db.php');
    include('classes/recuperar.class.php');

    $recuperar = new Recuperar(conexao());
    $email = $_POST['email'];

    $verificar = $recuperar->verificaEmail($email);

    if($verificar){
        require('classes/email.func.php');
        $mailer = new PHPMailer(true);
        $numero = seisDigitos();
        $copy = '&copy;';
        $corp = file_get_contents("emailTemplates/numeroRecuperacao.html");
        $cor=str_replace("--CODIGORENOVACAO--",$numero,$corp);
        $corpo=str_replace("--COPYRIGHT--",$copy." ".date("Y"),$cor);
        $enviar = enviaEmail($mailer, $email, "Recuperação de palavra passe", $corpo);

        if($enviar){
            $recuperar->selecionaNumeroDeRecuperacao($email, $numero);
            $res['ok'] = true;
            $res['payload'] = "Número de verificação enviado";
            echo json_encode($res);
        }else{

            
            $res['ok'] = false;
            $res['payload'] = "Ocorreu um erro inexperado";
            echo json_encode($res);

        }

    }else{
        $res['ok'] = false;
        $res['payload'] = "Esse mail não se encontra na base de dados.";
        echo json_encode($res);
    }

}