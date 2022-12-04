<?php
use ContaAPI\Classes\Criptografia;
use ContaAPI\Classes\Recuperar;
use ContaAPI\Classes\Funcoes;
use ContaAPI\Classes\DB\Selecionar;
use ContaAPI\Classes\DB\AX;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require '../../vendor/autoload.php';

if(isset($_POST['token'])){
    
    $funcoes = new Funcoes();
    $db = new Selecionar($funcoes::conexao()); //Inicializa o QueryBuilder
    $recuperar = new Recuperar($db);

    $TOKEN = $funcoes::substituiEspacoPorMais($_POST['token']);
    
    if($funcoes::tokeniza($TOKEN)){

        

        $conexao = $funcoes::conexao();
        $acesso = $funcoes::valid($TOKEN);

        $passAtual = $recuperar->pegaPalavraPasseEsquecida($acesso['email']);

        $antiga = $funcoes::fazHash($_POST['antiga']);

        $nova = $_POST['nova'];  

        if(strlen($nova) < 6){
            $return['payload'] = "Palavra passe muito curta";
            $return['ok'] = false;

            echo json_encode($return);
            return;
        }
    
        if($passAtual != $antiga){
            $return['payload'] = "A palavra passe atual está errada, confirme a sua identidade para poder alterar";
            $return['ok'] = false;

            echo json_encode($return);
            return;
        }
  
        $verificar = $recuperar->alteraPasse($acesso['user'], $nova);

        if($verificar){

            $recuperar->atualizaHistoricoPalavraPasse($acesso['user'],$passAtual);

            $return['payload'] = "Alterou a palavra passe";
            $return['ok'] = true;

            echo json_encode($return);

        }else{
            $res['ok'] = false;
            $res['payload'] = "Erro, a palavra passe não foi alterada";
            echo json_encode($res);
        }


    }else{
        $return['payload'] = "Erro";
        $return['ok'] = false;

        echo json_encode($return);

    }

}