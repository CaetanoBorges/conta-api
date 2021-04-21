<?php
if(isset($_POST['email'])){
    include('classes/recuperar.class.php');

    $recuperar = new Recuperar(conexao());
    $email = $_POST['email'];

    $verificar = $Recuperar->verificaEmail($email);

    if($verificar){
        require('classes/_email/PHPMailerAutoload.php');
        $mailer = new PHPMailer();
        $numero = seisDigitos();

        $enviar = enviaNumeroDeRecuperacao($mailer, $numero, $email);

        if($enviar){
            $recuperar->selecionaNumeroDeRecuperacao($email, $numero);
            echo 1;

        }else{

            echo 0;

        }

    }

}