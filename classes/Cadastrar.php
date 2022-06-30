<?php

namespace ContaAPI\Classes;

use ContaAPI\Classes\DB\AX;

class Cadastrar
{
    protected $db;       
    protected $array;
    protected $funcoes;

    public function __construct($db, $array, $funcoes) 
    {
        $this->db = $db;
        $this->array = $array;
        $this->funcoes = $funcoes;
    }

    protected function _checkEmail()
    {
        $mail = AX::attr($this->array['email']);

        $res = $this->db->count("email")
        ->from(AX::tb("conta"))
        ->where(["email = $mail"])
        ->pegaResultado();
        if($res['email'] > 0){
            return true;
        }else{
            return false;
        }
        
    }

    public function verificaEmail(){
        $user = $this->_checkEmail();
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
        $res = $this->db->insert("conta",
        ["chave" => AX::attr($this->funcoes::chaveDB()), 
        "nome" => AX::attr($array['nome']),
        "apelido" => AX::attr($array['apelido']),
        "genero" => AX::attr($array['genero']),
        "dia_nascimento" => AX::attr($array['dia']),
        "mes_nascimento" => AX::attr($array['mes']),
        "ano_nascimento" => AX::attr($array['ano']),
        "telefone" => AX::attr($array['telefone']),
        "email" => AX::attr($array['email']),
        "palavra_passe" => AX::attr($this->funcoes::fazHash($array['palavra_passe'])),
        "dia_entrada" => AX::attr(date('d')),
        "mes_entrada" => AX::attr(date('m')),
        "ano_entrada" => AX::attr(date('Y')),
        "codigo_renova" => AX::attr(0),
        "pais" => AX::attr("Angola"),
        "provincia" => AX::attr(" "),
        "municipio" => AX::attr(" "),
        "bairro_rua" => AX::attr(" "),
        "foto" => AX::attr("default.png")])
        ->executaQuery();

        if ($res) {
            return true;
        }
        return false;
    }

}