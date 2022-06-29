<?php
namespace ContaAPI;

use ContaAPI\Classes\DB\Selecionar;
use ContaAPI\Classes\DB\AX;
use ContaAPI\Classes\Funcoes;

//Load Composer's autoloader
require '../vendor/autoload.php';

$tabela = AX::tb("conta");
$pass = AX::attr("48ecf6bdee06f82fb24cd70e23c0b4def3f9aed7c59c87ece93c4e698ac2de0956a253d55b3ab36d150d5859f3944a978012fd633d665a0fdaa6795513cb849d");
$email = AX::attr("cbcaetanoborges@gmail.com");

$var = (new Selecionar(Funcoes::conexao()))
    ->select()
    ->from($tabela)
    ->where(["email = $email", "palavra_passe = $pass"])
    ->pegaResultados();

echo "<pre>";
print_r($var);
echo "</pre>";