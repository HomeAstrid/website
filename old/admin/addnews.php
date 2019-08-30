<?php

session_start();
include('../const.php');
if(!isset($_SESSION["astridusername"])) header('Location: '.base_url().'/admin/login.php');
define(title,'Admin:: home');
if($_SESSION["astridadmin"]==0){
header('Location: '.base_url());
} else {


include('../header/header1.php');
include('adminmenu.php');
include('../header/header3.php');

/* verwerken geposte gegevens */
if(isset($_POST["title"])){
	//connectie db
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);

	$query = "INSERT INTO `tbl_news` (`id`, `title`, `postdate`, `posterid`, `description`, `start`, `end`, `date`, `img`, `fb`, `visible`) VALUES (";
	$result = mysql_query("SELECT COUNT(*) FROM `tbl_news`")  or die("fout: " . mysql_error());;
	$id = mysql_result($result,0)+1;
	
	$query = $query."'".$id."', ";
	$query = $query."'".mysql_real_escape_string($_POST["title"])."', ";
	$query = $query."'".mysql_real_escape_string($_POST["postdate"])."', ";
	$query = $query."'".mysql_real_escape_string($_SESSION["astridid"])."', ";
	//$query = $query."'".mysql_real_escape_string($_POST["description"])."', ";
	$query = $query."'".$_POST["description"]."', ";
	if($_POST["startnull"]!="on") $query = $query."'".mysql_real_escape_string($_POST["start"])."', ";
	else $query = $query."NULL, ";
	if($_POST["endnull"]!="on") $query = $query."'".mysql_real_escape_string($_POST["end"])."', ";
	else $query = $query."NULL, ";
	if($_POST["datenull"]!="on") $query = $query."'".mysql_real_escape_string($_POST["date"])."', ";
	else $query = $query."NULL, ";
	if($_POST["imgnull"]!="on") $query = $query."'".mysql_real_escape_string($_POST["img"])."', ";
	else $query = $query."NULL, ";
	if($_POST["fbnull"]!="on") $query = $query."'".mysql_real_escape_string($_POST["fb"])."', ";
	else $query = $query."NULL, ";
	if($_POST["visible"]=="on") $query = $query."'1');";
	else $query = $query."'0');";

	$result = mysql_query($query) or die("fout: " . mysql_error());
	if($result==1)
		echo '<font color=#55ff55>Succesvol toegevoegd</font><br /><br />';
	mysql_close($con);
}

?>

<form method="post" action="addnews.php" name="inputform">
<table>
<tr>
<td>Titel</td> <td></td>
<td><input type="text" name="title" length="64" value="" /></td></tr>
<tr><td>Post datum</td> <td></td>
<td><input type="text" name="postdate" length="64" value="<?php echo datum(); ?>" /></td></tr>
<tr><td>Beschrijving</td> <td></td>
<td><textarea rows="5" cols="45" name="description" length="320"></textarea></td></tr>
<tr><td>Start</td>
<td><input type="checkbox" name="startnull" checked="true" /> null</td> 
<td> <input type="text" name="start" length="64" value="" /> </td></tr>
<tr><td>Einde</td>
<td><input type="checkbox" name="endnull" checked="true" /> null</td> 
<td> <input type="text" name="end" length="64" value="" /> </td></tr>
<tr><td>Datum</td>
<td><input type="checkbox" name="datenull" checked="true" /> null</td> 
<td> <input type="text" name="date" length="64" value="" /> </td></tr>
<tr><td>Afbeelding</td>
<td><input type="checkbox" name="imgnull" checked="true" /> null</td> 
<td> <input type="text" name="img" length="64" value="" /> </td></tr>
<tr><td>Facebooklink</td>
<td><input type="checkbox" name="fbnull" checked="true" /> null</td> 
<td> <input type="text" name="fb" length="64" value="" /> </td></tr>
<tr><td>Zichtbaar</td>
<td><input type="checkbox" name="visible" /> </td><td></td></tr>
<tr> <td></td> <td></td> <td> <input type="submit" value="Voeg nieuws toe!" /> </td></tr>
</table>
</form>


<?
}

include('../footer.php');
?>
