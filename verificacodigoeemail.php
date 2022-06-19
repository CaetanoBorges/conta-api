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

    $verificar = $recuperar->verificaNumeroEEmail($email,$numero);

    if($verificar){
        $res['ok'] = true;
        $res['payload'] = "Número de verificação correto";
        echo json_encode($res);

    }else{
        $res['ok'] = false;
        $res['payload'] = "Erro, dados errados";
        echo json_encode($res);
    }

}