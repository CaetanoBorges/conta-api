<?php

if(isset($_POST['email']) and isset($_POST['pass'])){
    include("classes/entra.class.php");
    include("classes/cript.class.php");
    include("classes/func.func.php");

    $entra = new Entrar(conexao()); 
    
    $entrar = $entra->verificaCredencial($_POST['email'], $_POST['pass']);
    
    if($entrar){

        $cript = new criptografia();
        $chave_sms_real = $cript->fazChave();
        $chave_sms = $cript->criptChave($chave_sms_real);

        $sms = $cript->encrypt($entrar ,$chave_sms_real);

        $res = array($sms, $chave_sms);
        echo json_encode($res);

    }else{
        echo 0;
    }
    
}else{

}
