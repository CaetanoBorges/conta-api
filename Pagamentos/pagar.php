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

        /* Pegando o nome do arquivo */
        $comprovativo = time()."-".$_FILES['comprovativo']['name'];
  
        /* Lolização do upload */
        $localizacao = "Comprovativo/".$comprovativo;

        $chave = Funcoes::chaveDB();
        $chaveApp = $_POST['app'];
        $tipo = $_POST['tipo'];
        $quando = time();
        
        $query = $conexao->prepare("INSERT INTO pagamentos (chave, chave_user, chave_app, tipo, quando, comprovativo) VALUES(?, ?, ?, ?, ?, ?)");
        $query->bindValue(1, $chave);
        $query->bindValue(2, $acesso['user']);
        $query->bindValue(3, $chaveApp);
        $query->bindValue(4, $tipo);
        $query->bindValue(5, $quando);
        $query->bindValue(6, $comprovativo);
        $query->execute();

        move_uploaded_file($_FILES['comprovativo']['tmp_name'], $localizacao);

        $return['payload'] = $comprovativo;
        $return['ok'] = true;

        echo json_encode($return);

    }else{
        $return['payload'] = "Erro";
        $return['ok'] = false;

        echo json_encode($return);

    }

}

?>