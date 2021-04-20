<?php
<?php
include("func.func.php");
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
        $stmt -> bindValue(1, $email);
        $stmt -> execute();
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
        $stmt -> bindValue(1, $codigo);
        $stmt -> bindValue(2, $email);

        if ($stmt ->execute()) {
            return true;
        }
        return false;
    }

}