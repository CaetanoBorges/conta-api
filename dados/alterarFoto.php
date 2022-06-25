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

        /* Pegando o nome do arquivo */
        $nomeDaFoto = time()."-".$_FILES['foto']['name'];
  
        /* Lolização do upload */
        $localizacao = "Foto/".$nomeDaFoto;

        $query = $conexao->prepare("SELECT foto FROM conta WHERE chave = ?");
        $query->bindValue(1, $acesso['user']);
        $query->execute();
        $res = $query->fetch();
        

        $query = $conexao->prepare("UPDATE conta SET foto = ? WHERE chave = ?");
        $query->bindValue(1, $nomeDaFoto);
        $query->bindValue(2, $acesso['user']);
        $query->execute();

        if($res['foto'] != "default.png"){
            unlink("Foto/".$res['foto']);
        }
        move_uploaded_file($_FILES['foto']['tmp_name'], $localizacao);

        $return['payload'] = $nomeDaFoto;
        $return['ok'] = true;

        echo json_encode($return);

    }else{
        $return['payload'] = "Erro";
        $return['ok'] = false;

        echo json_encode($return);

    }

}

?>