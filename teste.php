<?php
namespace ContaAPI;

use ContaAPI\Classes\DB\Selecionar;
use ContaAPI\Classes\Funcoes;

//Load Composer's autoloader
require '../vendor/autoload.php';

$var = (new Selecionar(Funcoes::conexao()))
    ->select()
    ->from("conta")
    ->pegaResultados();

echo "<pre>";
print_r($var);
echo "</pre>";