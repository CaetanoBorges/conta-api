<?php
namespace ContaAPI\Classes;

class Recuperar
{
    protected $db;       

    public function __construct($pdo) 
    {
       $this->db = $pdo;
    }

    public function verificaEmail($email)
    {
        $stmt = $this->db->prepare('SELECT COUNT(email) AS email FROM conta WHERE email = ?');
        $stmt->bindValue(1, $email);
        $stmt->execute();
        $res = $stmt -> fetch();
        if($res['email'] > 0){
            return true;
        }else{
            return false;
        }
    }

    public function selecionaNumeroDeRecuperacao($email, $codigo)
    {
        $stmt = $this->db->prepare('UPDATE conta SET codigo_renova = ? WHERE email = ?');
        $stmt->bindValue(1, $codigo);
        $stmt->bindValue(2, $email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function verificaNumeroEEmail($email, $codigo)
    {
        $stmt = $this->db->prepare('SELECT COUNT(email) AS email FROM conta WHERE email = ? and codigo_renova = ?');
        $stmt->bindValue(1, $email);
        $stmt->bindValue(2, $codigo);
        $stmt->execute();
        $res = $stmt->fetch();
        if($res['email'] > 0){
            return true;
        }else{
            return false;
        }
    } 

    public function resetCodigoRenovacao($email, $codigo){
        $stmt = $this->db->prepare('UPDATE conta SET codigo_renova = ? WHERE email = ? and codigo_renova = ?');
        $stmt->bindValue(1, 0);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $codigo);
        $stmt->execute();
    
    }
    public function pegaPalavraPasseEsquecida($email){
        $query = $this->db->prepare("SELECT * FROM conta WHERE email = ?");
        $query->bindValue(1, $email);
        $query->execute();
        $res= $query->fetch();
        return $res['palavra_passe'];
    }
    public function atualizaHistoricoPalavraPasse($user,$passAtual){
        $query = $this->db->prepare("INSERT INTO historicopalavrapasse (chave_user, palavra_passe, quando) VALUES (?, ?, ?)");
        $query->bindValue(1, $user);
        $query->bindValue(2, $passAtual);
        $query->bindValue(3, time());
        $query->execute();
    }
    public function novaPasse($email, $codigo, $palavra_passe)
    {
        $stmt = $this->db->prepare('UPDATE conta SET palavra_passe = ? WHERE email = ? and codigo_renova = ?');
        $stmt->bindValue(1, hash("sha512",$palavra_passe));
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $codigo);
        
       
        if($stmt->execute()){
            $this->resetCodigoRenovacao($email, $codigo);
            return true;
        }else{
            return false;
        }
    }
    
    public function alteraPasse($user, $palavra_passe)
    {
        $stmt = $this->db->prepare('UPDATE conta SET palavra_passe = ? WHERE chave = ?');
        $stmt->bindValue(1, hash("sha512",$palavra_passe));
        $stmt->bindValue(2, $user);
        
       
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

}