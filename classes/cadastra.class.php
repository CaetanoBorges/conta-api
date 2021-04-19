<?php
include("func.func.php");
class Cadastrar
{
    protected $db;       

    public function __construct($pdo) 
    {
       $this->db = $pdo;
    }

    public function verificaEmail($email)
    {
        $stmt = $this->db->prepare('SELECT COUNT(email) AS email FROM conta WHERE email = ?');
        $stmt -> bindValue(1, $email);
        $stmt -> execute();
        $res = $stmt -> fetch();
        if($res['email'] > 0){
            return true;
        }else{
            return false;
        }
    }

    protected function adicionarUser($array)
    {
        $stmt = $this->db->prepare('INSERT INTO conta (chave, nome, apelido, genero, dia_nascimento, mes_nascimento, ano_nascimento, telefone, email, palavra_passe, dia_entrada, mes_entrada, ano_entrada, codigo_renova, pais, provincia, municipio, bairro_rua) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt -> bindValue(1, chaveDB());
        $stmt -> bindValue(2, $array['nome']);
        $stmt -> bindValue(3, $array['apelido']);
        $stmt -> bindValue(4, $array['genero']);
        $stmt -> bindValue(5, $array['dia']);
        $stmt -> bindValue(6, $array['mes']);
        $stmt -> bindValue(7, $array['ano']);
        $stmt -> bindValue(8, $telefone);
        $stmt -> bindValue(9, $array['email']);
        $stmt -> bindValue(10, $this->hash("sha512",$array['password']));
        $stmt -> bindValue(11, date('d'));
        $stmt -> bindValue(12, date('m'));
        $stmt -> bindValue(13, date('ano'));
        $stmt -> bindValue(14, 0);
        $stmt -> bindValue(15, "");
        $stmt -> bindValue(16, "");
        $stmt -> bindValue(17, "");
        $stmt -> bindValue(18, "");
        
        
        if ($stmt ->execute()) {
            return true;
        }
        return false;
    }

}