<?php
namespace ContaAPI\Classes;

use ContaAPI\Classes\DB\AX;
use ContaAPI\Classes\Funcoes;

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
       $this->password = Funcoes::fazHash($password);
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
        $pass = AX::attr($this->password);
        $email = AX::attr($this->email);

        $user = $this->db->select()
        ->from(AX::tb("conta"))
        ->where(["email = $email", "palavra_passe = $pass"])
        ->pegaResultado();
        
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