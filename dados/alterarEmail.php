<?php
use ContaAPI\Classes\Criptografia;
use ContaAPI\Classes\Funcoes;

require '../../vendor/autoload.php';

if(isset($_POST['token'])){
    
    $funcoes = new Funcoes();

    $TOKEN = $funcoes::substituiEspacoPorMais($_POST['token']);
    
    if($funcoes::tokeniza($TOKEN)){

        $conexao = $funcoes::conexao();

        $acesso = $funcoes::valid($TOKEN);

        $query = $conexao->prepare("UPDATE conta SET email = ? WHERE chave = ?");
        $query->bindValue(1, $_POST['email']);
        $query->bindValue(2, $acesso['user']);
        $query->execute();

        $return['payload'] = "Alterou o email";
        $return['ok'] = true;

        echo json_encode($return);

    }else{
        $return['payload'] = "Erro";
        $return['ok'] = false;

        echo json_encode($return);

    }

}

?>