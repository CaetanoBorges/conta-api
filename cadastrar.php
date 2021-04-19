<?php
include("classes/cadastra.class.php");
include("classes/entra.class.php");

$cadastro = new Cadastrar(conexao()); 

if(isset($_POST['json'])){

    $array = json_decode($_POST['json']);
    $adicionar = $cadastro->adicionarUser($array);

    if($adicionar){
        $entrar = new Entrar(conexao());
        $credencial = $entrar->verificaCredencial($array['email'], $array['password']);
    }else{

    }

}else if(isset($_POST['email'])){

    $verificar = $cadastro->verificaEmail($_POST['email']);

    if($verificar){
        echo 'Sim';
    }else{
        echo 'Nao';
    }

}
