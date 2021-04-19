<?php
if(isset($_POST['email']) and isset($_POST['pass'])){
    include("classes/login.class.php");

    $init = new UserService($_POST['email'], $_POST['pass']); 
    
//var_dump($init);
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
