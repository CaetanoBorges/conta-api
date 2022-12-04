<?php
use ContaAPI\Classes\Criptografia;
use ContaAPI\Classes\Funcoes;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require '../../vendor/autoload.php';

if(isset($_POST['token'])){
    
    $funcoes = new Funcoes();

    $TOKEN = $funcoes::substituiEspacoPorMais($_POST['token']);
    
    if($funcoes::tokeniza($TOKEN)){

        $conexao = $funcoes::conexao();

        $acesso = $funcoes::valid($TOKEN);

        $query = $conexao->prepare("UPDATE conta SET genero = ?, dia_nascimento = ?, mes_nascimento = ?, ano_nascimento = ? WHERE chave = ?");
        $query->bindValue(1, $_POST['genero']);
        $query->bindValue(2, $_POST['dia']);
        $query->bindValue(3, $_POST['mes']);
        $query->bindValue(4, $_POST['ano']);
        $query->bindValue(5, $acesso['user']);
        $query->execute();

        $return['payload'] = "Alterou o genero e o nascimento";
        $return['ok'] = true;

        echo json_encode($return);

    }else{
        $return['payload'] = "Erro";
        $return['ok'] = false;

        echo json_encode($return);

    }

}

?>