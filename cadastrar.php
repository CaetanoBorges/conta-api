<?php
include("classes/cadastra.class.php");
include("classes/entra.class.php");
include("classes/cript.class.php");

$cadastro = new Cadastrar(conexao()); 

if(isset($_POST['json'])){

    $array = json_decode($_POST['json']);
    $adicionar = $cadastro->adicionarUser($array);

    if($adicionar){
        $entra = new Entrar(conexao());
        $entrar = $entra->verificaCredencial($array['email'], $array['password']);
        if($entrar){

            $cript = new criptografia();
            $chave_sms_real = $cript->fazChave();
            $chave_sms = $cript->criptChave($chave_sms_real);

            $sms = $cript->encrypt($entrar ,$chave_sms_real);

            $res = array($sms, $chave_sms);
            echo json_encode($res);

        }
    }else{

    }

}else if(isset($_POST['email'])){

    $verificar = $cadastro->verificaEmail($_POST['email']);

    if($verificar){
        echo 'Sim';
    }else{
        echo 'Nao';
    }

}
