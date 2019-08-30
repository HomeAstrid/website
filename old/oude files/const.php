<?php

function base_url(){
	return 'http://astrid.ugent.be';
}

function bewlijst_select()
{
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)
	  	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	
	mysql_select_db("astrid",$con);
	$result = mysql_query("SELECT * FROM `tbl_bewlijst` ORDER BY kamernr") or die("fout: " . mysql_error());

	mysql_close($con);

	return $result; 
}

function datum(){

	$date = date("d F o");
	$date = str_replace("January", "januari", $date);
	$date = str_replace("Febuary", "februari", $date);
	$date = str_replace("March", "maart", $date);
	$date = str_replace("April", "april", $date);
	$date = str_replace("May", "mei", $date);
	$date = str_replace("June", "juli", $date);
	$date = str_replace("July", "juli", $date);
	$date = str_replace("August", "augustus", $date);
	$date = str_replace("September", "september", $date);
	$date = str_replace("October", "oktober", $date);
	$date = str_replace("November", "november", $date);
	$date = str_replace("December", "december", $date);
	return $date;

}

?>
