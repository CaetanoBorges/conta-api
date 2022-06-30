<?php
namespace ContaAPI;

use ContaAPI\Classes\DB\Selecionar;
use ContaAPI\Classes\DB\AX;
use ContaAPI\Classes\Funcoes;

//Load Composer's autoloader
require '../vendor/autoload.php';

$tabela = AX::tb(time());
$pass = AX::attr("ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413");
$email = AX::attr("são lubas");

$var = (new Selecionar(Funcoes::conexao()))
    ->insert("historicopalavrapasse",["chave_user" => $email, "palavra_passe" => $pass, "quando" => $tabela])
    ->executaQuery();

echo $var;