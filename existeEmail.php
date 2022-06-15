<?php
use PHPMailer\PHPMailer\PHPMailer;
//Load Composer's autoloader
require '../vendor/autoload.php';


if(isset($_POST["json"])){
    
    include("classes/cript.class.php");
    include("classes/cadastra.class.php");
    include("classes/db.php");

    $conexao = conexao();
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
