<?php
namespace ContaAPI;

use ContaAPI\Classes\Criptografia;
use ContaAPI\Classes\Recuperar;
use ContaAPI\Classes\Entrar;
use ContaAPI\Classes\Funcoes;
use ContaAPI\Classes\DB\Selecionar;
use ContaAPI\Classes\DB\AX;

require '../vendor/autoload.php';

if(isset($_POST['email'])){
    
    $funcoes = new Funcoes();
    $db = new Selecionar($funcoes::conexao()); //Inicializa o QueryBuilder
    $recuperar = new Recuperar($db);

    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $palavra_passe = $_POST['palavra_passe'];
    if(strlen($palavra_passe) < 6){
        $return['payload'] = "Palavra passe muito curta";
        $return['ok'] = false;

        echo json_encode($return);
        return;
    }

    $passAtual = $recuperar->pegaPalavraPasseEsquecida($email);
    $verificar = $recuperar->novaPasse($email,$numero, $palavra_passe);

    if($verificar){

        $init = new Entrar($db, $_POST['email'], $_POST['palavra_passe']);
        if($init->login()){
            $credencial['user']=$init->getUser();
            $credencial['email']=$init->getEmail();


            $recuperar->atualizaHistoricoPalavraPasse($credencial['user'],$passAtual);

            $credencial = json_encode($credencial);
            
            $cript = new Criptografia();
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