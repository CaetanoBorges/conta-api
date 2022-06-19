<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

namespace ContaAPI;
require '../vendor/autoload.php';

if(isset($_POST['email'])){
    include('classes/db.php');
    include('classes/recuperar.class.php');

    $recuperar = new Recuperar(conexao());
    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $palavra_passe = $_POST['palavra_passe'];
    if(strlen($palavra_passe) < 6){
        $return['payload'] = "Palavra passe muito curta";
        $return['ok'] = false;

        echo json_encode($return);
        return;
    }
    
    $verificar = $recuperar->novaPasse($email,$numero, $palavra_passe);

    if($verificar){
        include("classes/cript.class.php");
        include("classes/entra.class.php");

        $init = new Entrar(conexao(), $_POST['email'], $_POST['palavra_passe']);
        if($init->login()){
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
        $res['ok'] = false;
        $res['payload'] = "Erro, dados errados";
        echo json_encode($res);
    }

}