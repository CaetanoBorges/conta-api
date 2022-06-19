<?php
namespace ContaAPI;

use PHPMailer\PHPMailer\PHPMailer;

use ContaAPI\Classes\Criptografia;
use ContaAPI\Classes\Cadastrar;
use ContaAPI\Classes\Funcoes;

//Load Composer's autoloader
require '../vendor/autoload.php';


if(isset($_POST["json"])){
    $funcoes = new Funcoes();
    $conexao = $funcoes::conexao();
    $json = $_POST["json"];
    $array = (array) json_decode($json);
    /* ARRAY FIELDS
    $array['nome'] = $_POST['nome'];
    $array['email'] = $_POST['email'];
    $array['apelido'] = $_POST['apelido'];
    $array['dia'] = $_POST['dia'];
    $array['mes'] = $_POST['mes'];
    $array['ano'] = $_POST['ano'];
    $array['palavra_passe'] = $_POST['palavra_passe'];
    $array['genero'] = $_POST['genero'];
    $array['telefone'] = $_POST['telefone'];
    */
    #var_dump($array);
    $init = new Cadastrar($conexao,$array);
    

    if($init->verificaEmail()){
        
        $return['payload'] = "Erro, já existe um usuário com esse email";
        $return['ok'] = true;

        echo json_encode($return);
    }else{
        $return['payload'] = "";
        $return['ok'] = false;

        echo json_encode($return);
    }
    
}else{

}
