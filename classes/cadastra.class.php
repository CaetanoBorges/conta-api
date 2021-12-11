<?php
class Cadastrar
{
    protected $db;       
    protected $array;

    public function __construct($db, $array) 
    {
        $this->db = $db;
        $this->array = $array;
    }

    protected function _checkEmail()
    {
        $stmt = $this->db->prepare('SELECT * FROM conta WHERE email = ?');
        $stmt -> bindValue(1, $this->array['email']);
        $stmt ->execute();
        $user = $stmt->fetch();
        
        if ($user) {
            return true;
        }else{
            return false;
        }
        
    }

    public function cadastrar()
    {
        $user = $this->_checkEmail();
        if ($user) {
            return false;
        }else{
            $res = $this->novoUser($this->array);
            return $res;
        }
        
    }

    public function novoUser($array)
    {
        $stmt = $this->db->prepare('INSERT INTO conta (chave, nome, apelido, genero, dia_nascimento, mes_nascimento, ano_nascimento, telefone, email, palavra_passe, dia_entrada, mes_entrada, ano_entrada, codigo_renova, pais, provincia, municipio, bairro_rua) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt -> bindValue(1, chaveDB());
        $stmt -> bindValue(2, $array['nome']);
        $stmt -> bindValue(3, $array['apelido']);
        $stmt -> bindValue(4, $array['genero']);
        $stmt -> bindValue(5, $array['dia']);
        $stmt -> bindValue(6, $array['mes']);
        $stmt -> bindValue(7, $array['ano']);
        $stmt -> bindValue(8, $array['telefone']);
        $stmt -> bindValue(9, $array['email']);
        $stmt -> bindValue(10, hash("sha512",$array['palavra_passe']));
        $stmt -> bindValue(11, date('d'));
        $stmt -> bindValue(12, date('m'));
        $stmt -> bindValue(13, date('Y'));
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