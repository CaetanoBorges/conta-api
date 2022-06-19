<?php

namespace ContaAPI;
require '../vendor/autoload.php';

include("classes/cript.class.php");
include("classes/valid.func.php");


function Tokeniza ( $str){
    $res = valid($str);
    if(gettype($res) == "array"){
        return true;
    }else{
        return false;
    }
}