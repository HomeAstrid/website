<?php

define('title','Home Astrid:: Inschrijven pingpong');
include('const.php');
include('header.php');

if(!is_null($_POST['naam'])){

	//connectie db
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);

	$query = "INSERT INTO `pingpong` (`naam`, `kamernr`) VALUES (";
	$query = $query."'".mysql_real_escape_string($_POST["naam"])."', ";
	$query = $query."'".mysql_real_escape_string($_POST["kamernr"])."'); ";
	
	$result = mysql_query($query) or die("fout: " . mysql_error());
	if($result==1)
		echo '<font color=#55ff55><b>Succesvol ingeschreven! Cya @ pingpongtornooi!</b></font><br /><br />';
	else
		echo '<font color=#ff5555><b>Databankfout. Gelieve de ICT-Preases te contacteren.</b></font><br /><br />';	
	mysql_close($con);

} else {

?>

Door je gegevens hier onder in te vullen, schrijf je je in voor het pingpongtornooi. <br /><br />

<form method="post" action="pingpong.php" name="inputform">
<table>
<tr>
<td>Naam</td>
<td><input type="text" name="naam" length="64" value="" /></td></tr>
<tr><td>Kamernummer</td>
<td><input type="text" name="kamernr" length="64" value="" /></td></tr>
<tr> <td colspan="2"> <input type="submit" value="Schrijf je in!" /> </td></tr>
</table>
</form>
	
<?php
}

include('footer.php');
?>
