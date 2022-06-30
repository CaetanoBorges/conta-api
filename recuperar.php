<?php
namespace ContaAPI;

use PHPMailer\PHPMailer\PHPMailer;
use ContaAPI\Classes\Criptografia;
use ContaAPI\Classes\Recuperar;
use ContaAPI\Classes\Entrar;
use ContaAPI\Classes\Funcoes;
use ContaAPI\Classes\DB\Selecionar;
use ContaAPI\Classes\DB\AX;

require '../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");


if(isset($_POST['email'])){

    $funcoes = new Funcoes();
    $db=new Selecionar($funcoes::conexao());

    $recuperar = new Recuperar($db);
    $email = $_POST['email'];

    $verificar = $recuperar->verificaEmail($email);

    if($verificar){
        $mailer = new PHPMailer(true);
        $numero = $funcoes::seisDigitos();
        $copy = '&copy;';
        $corp = file_get_contents("emailTemplates/numeroRecuperacao.html");
        $cor=str_replace("--CODIGORENOVACAO--",$numero,$corp);
        $corpo=str_replace("--COPYRIGHT--",$copy." ".date("Y"),$cor);
        $enviar = $funcoes::enviaEmail($mailer, $email, "Recuperação de palavra passe", $corpo);

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