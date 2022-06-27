<?php
use ContaAPI\Classes\Criptografia;
use ContaAPI\Classes\Recuperar;
use ContaAPI\Classes\Funcoes;

require '../../vendor/autoload.php';

if(isset($_POST['token'])){
    
    $funcoes = new Funcoes();
    $recuperar = new Recuperar($funcoes::conexao());

    $TOKEN = $funcoes::substituiEspacoPorMais($_POST['token']);
    
    if($funcoes::tokeniza($TOKEN)){

        

        $conexao = $funcoes::conexao();
        $acesso = $funcoes::valid($TOKEN);

        $query = $conexao->prepare("SELECT * FROM conta WHERE chave = ?");
        $query->bindValue(1, $acesso['user']);
        $query->execute();
        $res= $query->fetch();
        $passAtual = $res['palavra_passe'];
        $antiga = hash("sha512",$_POST['antiga']);

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

            $query = $conexao->prepare("INSERT INTO historicopalavrapasse (chave_user, palavra_passe, quando) VALUES (?, ?, ?)");
            $query->bindValue(1, $acesso['user']);
            $query->bindValue(2, $passAtual);
            $query->bindValue(3, time());
            $query->execute();

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