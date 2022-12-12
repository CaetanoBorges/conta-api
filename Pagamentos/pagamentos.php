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

        $query = $conexao->prepare("SELECT * FROM pagamentos WHERE chave_user = ? and chave_app = ?");
        $query->bindValue(1, $acesso['user']);
        $query->bindValue(2, $_POST['servico']);
        $query->execute();
        $res = $query->fetchAll();

        $return['payload'] = $res;
        $return['ok'] = true;

        echo json_encode($return);

    }else{
        $return['payload'] = "Erro";
        $return['ok'] = false;

        echo json_encode($return);

    }

}

?>