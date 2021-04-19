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

function chaveDB(){
    return hash("sha512", time() * (time() * time()) );
}

function data(){
    $data['dia'] = date('d');
    $data['mes'] = date('m');
    $data['ano'] = date('y');
    return $data;
}

function conexao(){
    return new PDO("mysql:host=127.0.0.1;dbname=conta", "root", "");
}
