<?php
use PHPMailer\PHPMailer\PHPMailer;
//Load Composer's autoloader
require '../vendor/autoload.php';


if(isset($_POST["json"])){
    
    include("classes/cript.class.php");
    include("classes/cadastra.class.php");
    include("classes/db.php");

    $conexao = conexao();
    $json = $_POST["json"];
    $array = (array) json_decode($json);
    /* ARRAY FIELDS
    $array['nome'] = $_POST['nome'];
    $array['email'] = $_POST['email'];
    $array['apelido'] = $_POST['apelido'];
    $array['dia'] = $_POST['dia'];
    $array['mes'] = $_POST['mes'];
    $array['ano'] = $_POST['ano'];
    $array['palavra_passe'] = $_POST['palavra_passe'];
    $array['genero'] = $_POST['genero'];
    $array['telefone'] = $_POST['telefone'];
    */
    #var_dump($array);
    $init = new Cadastrar($conexao,$array);
    

    if($init->cadastrar()){
        include("classes/entra.class.php");

        $init = new Entrar($conexao, $array['email'], $array['palavra_passe']);
        if($init->login()){
            require('classes/email.func.php');
            $mailer = new PHPMailer(true);
            $copy = '&copy;';
            $corp = file_get_contents("emailTemplates/boasVindas.html");
            $corpo=str_replace("--COPYRIGHT--",$copy." ".date("Y"),$corp);
            $enviar = enviaEmail($mailer, $array['email'], "Seja benvindo/a, Binga.", $corpo);


            $credencial['user']=$init->getUser();
            $credencial['email']=$init->getEmail();

            $credencial = json_encode($credencial);
            
            $cript = new criptografia();
            $chave_sms_real = $cript->fazChave();
            $chave_sms = $cript->criptChave($chave_sms_real);

            $sms = $cript->encrypt($credencial,$chave_sms_real);

            $return['payload'] = $sms.'.'.$chave_sms;
            $return['ok'] = true;



            echo json_encode($return);

            

            //echo $sms.'.'.$chave_sms;
        }else{
            $return['payload'] = "Erro, credenciais errados";
            $return['ok'] = false;

            echo json_encode($return);
        }

    }else{
        $return['payload'] = "Erro, já existe um usuário com esse email";
        $return['ok'] = false;

        echo json_encode($return);
    }
    
}else{

}
