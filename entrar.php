<?php
if(isset($_POST['json'])){
    include("classes/entra.class.php");
    include("classes/db.php");

    $json = (array) json_decode($_POST['json']);
    $email = $json['email'];
    $palavra_passe = $json['palavra_passe'];
    $conexao = conexao();


    $init = new Entrar($conexao, $email, $palavra_passe);
    

    if($init->login()){
        include("classes/cript.class.php");
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

}