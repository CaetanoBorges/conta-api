<?php
//echo $_GET['objecto'] ;
if(isset($_GET['objecto'])){

    include("../verifica.script.php");
    
    if(tokeniza($_GET['objecto']) ){
        include("../classes/db.php");

        $conexao = conexao();

        $acesso = valid($_GET['objecto']);
      
        $query = $conexao->prepare("SELECT * FROM conta WHERE chave = ?");
        $query->bindValue(1, $acesso['user']);
        $query->execute();
        $re = $query->fetch();
     
        echo json_encode($re);

    }else{
        echo "Erro";



    }

}