<?php

define('title','EK pronostiek tornooi - Home Astrid');

$debug = 0;
if($debug != 1){
	exit;
}
$passcheck1 = md5('s33d'.md5('astridwk'.'smurfen'));
echo $passcheck1;

?>