<?php
namespace ContaAPI;

use ContaAPI\Classes\Recuperar;
use ContaAPI\Classes\Funcoes;
use ContaAPI\Classes\DB\Selecionar;
use ContaAPI\Classes\DB\AX;


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");


require '../vendor/autoload.php';

if(isset($_POST['email'])){

    $funcoes = new Funcoes();
    $db=new Selecionar($funcoes::conexao());

    $recuperar = new Recuperar($db);

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