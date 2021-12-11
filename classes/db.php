<?php 
function conexao(){
    return new PDO("mysql:host=127.0.0.1;dbname=conta", "root", "");
}
