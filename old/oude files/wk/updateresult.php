<?php

session_start();
if(!isset($_SESSION['wkid'])){
	echo '0Sessie vervallen. Refresh eens?';
	exit;
}

if(!isset($_SESSION['wkadmin'])){
	echo '0U bent geen admin. GTFO.';
	exit;
}

//invoer van gewenste formaat?

$matchid=$_GET['matchid'];
if(!preg_match('/^[0-9]{1,6}$/', $matchid)){
	echo '0matchid niet goed gevormd. Refresh?';
	exit;
}

$goals1=$_GET['goals1'];
if(!preg_match('/^[0-9]{1,2}$/', $goals1)){
	echo '0'.$_GET['goals1'].'?! Een getal tussen 0 en 99 aub.';
	exit;
}

$goals2=$_GET['goals2'];
if(!preg_match('/^[0-9]{1,2}$/', $goals2)){
	echo '0'.$_GET['goals2'].'?! Een getal tussen 0 en 99 aub.';
	exit;
}

//bestaat match met matchid?
include_once('db.php');
db::open_connection();

$query = "SELECT * FROM `wk_match` WHERE `id`='".$matchid."';";
$matchresult = mysql_query($query);
if(mysql_error()){
	echo '0databasefout :-(';
	db::close_connection();
	exit;
}
$matchen = mysql_num_rows($matchresult);
if($matchen==0){
	echo '0Fout: match niet teruggevonden.';
	db::close_connection();
	exit;
}
$match = mysql_fetch_array($matchresult);

//is de deadline van die match al verstreken?
if(strtotime($match['deadline']) > strtotime('now') ){
	echo '0De deadline is nog niet verstreken.';
	db::close_connection();
	exit;
}

//voer door naar database
$query="UPDATE `wk_match` SET `goals1`='".$goals1."' , `goals2`='".$goals2."' WHERE `id`='".$matchid."';";
mysql_query($query);
if(mysql_error()){
	echo '0databasefout :-(';
} else {
	echo '1succesvol opgeslagen.';
}
db::close_connection();
exit;


?>