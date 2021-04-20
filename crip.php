<?php
include("classes/cript.class.php");
include("classes/func.func.php");


$c = new criptografia();

$chave = $c-> fazChave();
$cc = $c->criptChave($chave);
$dc = $c->decriptChave($cc);
$sms = "921797626-935803033-_-935803033-921797626";

//echo $chave.'<br>';
//echo $cc.'<br>';
//echo $dc.'<br>';

$res = $c->encrypt($sms, $chave);

//echo $res;
$arr = array($res, $cc);
//echo json_encode($arr);

echo valid('["xq+Y92FcvGKx4DfHQTRSS+G9TmoAXCjlO8kH31\/3uPPAvT66AV\/tDo68KoFcsAT9YbaGvD7WRSAT","NTA2MTc4NWE0OTRjNGU2NjU0MzY3MDc3NGUzODZkNjU3NTYxNzQ2ZTVhNDUzNTU5NWE1OTc5NmU3NTdhNDUzNDQ1NzMzMDQ5MzA1MjQyNDE="]');