<?php
namespace ContaAPI;

use ContaAPI\Classes\DB\Selecionar;
use ContaAPI\Classes\DB\AX;
use ContaAPI\Classes\Funcoes;

//Load Composer's autoloader
require '../vendor/autoload.php';

$var = (new Selecionar(Funcoes::conexao()))
    ->select()
    ->from("servicos")
    ->pegaResultados();

    $res['ok'] = true;
    $res['payload'] = $var;
    echo json_encode($res);