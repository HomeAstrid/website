<?php

session_start();
if(!isset($_SESSION['wkid'])){
	echo '0Sessie vervallen. Refresh eens?';
	exit;
}

//invoer van gewenste formaat?

$matchid=$_GET['matchid'];
if(!preg_match('/^[0-9]{1,2}$/', $matchid)){
	echo '0Foutje. Kun je eens refreshen?';
	exit;
}

if($matchid!=65){

$goals1=$_GET['goals1'];
if(!preg_match('/^[0-9]{1,2}$/', $goals1)){
	echo '0'.$_GET['goals1'].'?! Een getal tussen 0 en 99 aub.';
	exit;
}

}

$goals2=$_GET['goals2'];
if($matchid!=65){
if(!preg_match('/^[0-9]{1,2}$/', $goals2)){
	echo '0'.$_GET['goals2'].'?! Een getal tussen 0 en 99 aub.';
	exit;
}
} else {
if(!preg_match('/^[0-9]{1,3}$/', $goals2)){
	echo '0'.$_GET['goals2'].'?! Een getal tussen 0 en 999 aub.';
	exit;
}
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
	echo '0Fout. Kun je eens refreshen?';
	db::close_connection();
	exit;
}
$match = mysql_fetch_array($matchresult);

//is de deadline van die match nog niet verstreken?
if(strtotime($match['deadline']) <= strtotime('now')){
	echo '0Deadline verstreken. Refresh eens?;)';
	db::close_connection();
	exit;
}

//voer door naar database
$query = "SELECT * FROM `wk_guess` WHERE `userid`='".$_SESSION['wkid']."' AND `matchid`='".$matchid."';";
$result = mysql_query($query);
if(mysql_error()){
	echo '0databasefout :-(';
	db::close_connection();
	exit;
}
$bestaat = mysql_num_rows($result);

if($bestaat){
	if($matchid!=65){
	$query="UPDATE `wk_guess` SET `goals1`='".$goals1."' , `goals2`='".$goals2."' WHERE `userid`='".$_SESSION['wkid'].
			"' AND `matchid`='".$matchid."';";
			} else {
	$query="UPDATE `wk_guess` SET `goals2`='".$goals2."' WHERE `userid`='".$_SESSION['wkid'].
			"' AND `matchid`='".$matchid."';";			
			}
	mysql_query($query);
	if(mysql_error()){
		echo '0databasefout :-(';
	} else {
		echo '1succesvol opgeslagen.';
	}
	db::close_connection();
	exit;
} else {
	if($matchid!=65){
	$query="INSERT INTO `wk_guess` (`userid`,`matchid`, `goals1`, `goals2`) VALUES ".
	"('".$_SESSION['wkid']."','".$matchid."','".$goals1."','".$goals2."'); ";
	} else {
	$query="INSERT INTO `wk_guess` (`userid`,`matchid`, `goals1`, `goals2`) VALUES ".
	"('".$_SESSION['wkid']."','".$matchid."',0,'".$goals2."'); ";
	}
	mysql_query($query);
	if(mysql_error()){
		echo '0databasefout :-( ';
	} else {
		echo '1succesvol opgeslagen.';
	}
	db::close_connection();
	exit;
}

db::close_connection(); //komt normaal niet voor tot hier


?>