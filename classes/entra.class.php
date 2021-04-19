<?php

class Entrar
{
    protected $db;       

    public function __construct($pdo)
    {
       $this->db = $pdo;
    }

    public function verificaCredencial($email, $password)
    {
        $stmt = $this->db->prepare('SELECT chave FROM conta WHERE email = ? AND palavra_passe = ? ');
        $stmt -> bindValue(1, $email);
        $stmt -> bindValue(2, hash("sha512",$password));
        $stmt ->execute();
        $chave = $stmt->fetch();

        $res = $chave['chave'];
        if(isset($res) AND !empty($res)){
            return $res;
        }else{
            return false;
        }

    }

}