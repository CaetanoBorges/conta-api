<?php

class Entrar
{
    protected $email;    
    protected $password; 

    protected $db;       
    protected $user;     

    public function __construct($db, $email, $password) 
    {
       $this->db = $db;
       $this->email = $email;
       $this->password = hash("sha512",$password);
    }

    public function login()
    {
        $user = $this->_checkCredentials();
        if ($user) {
            return $user;
        }
        return false;
    }

    protected function _checkCredentials()
    {
        $stmt = $this->db->prepare('SELECT * FROM conta WHERE email = ? AND palavra_passe = ? ');
        $stmt -> bindValue(1, $this->email);
        $stmt -> bindValue(2, $this->password);
        $stmt ->execute();
        $user = $stmt->fetch();
        if($user){
            if (count($user) > 1) {
                $this->user = $user;
                return true;
            }
        }
        return false;
    }

    public function getUser()
    {
        return $this->user['chave'];
    }
    public function getEmail()
    {
        return $this->user['email'];
    }
}