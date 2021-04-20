<?php
function valid($token){
    $token = json_decode($token);

    $sms = $token[0];
    $chave_ = $token[1];
    $cript = new criptografia();
    $chave = $cript->decriptChave($chave_);
    $res = $cript->decrypt($sms, $chave);

    if(isset($res)){
        return $res;
    }else{
        return false;
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
