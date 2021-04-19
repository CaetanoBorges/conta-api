<?php
include("classes/cript.class.php");


$c = new criptografia();

$chave = $c-> fazChave();
$cc = $c->criptChave($chave);
$dc = $c->decriptChave($cc);
$sms = "921797626-935803033-_-935803033-921797626";

echo $chave.'<br>';
echo $cc.'<br>';
echo $dc.'<br>';

$res = $c->encrypt($sms, $chave);

echo $res;
//$arr = array($res, $chave);
//echo json_encode($arr);