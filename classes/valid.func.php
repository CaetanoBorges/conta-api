<?php
function valid($token){
    $token = explode(".",$token);

    $sms = $token[0];
    $chave = $token[1];
    $cript = new criptografia();
    $chave = $cript->decriptChave($chave);
    $res = $cript->decrypt($sms, $chave);

    $r = (array) json_decode($res);
    
    if(count($r) > 1){
        return $r;
    }else{
        return "Erro, token inválido!";
    }
    

}