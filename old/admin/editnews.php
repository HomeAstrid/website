<?php

session_start();
include('../const.php');
if(!isset($_SESSION["astridusername"])) header('Location: '.base_url().'/admin/login.php');
define(title,'Admin:: home');
if($_SESSION["astridadmin"]==0){
header('Location: '.base_url());
} else {
if(!isset($_GET["id"])){

header('Location: '.base_url().'/admin/listnews.php');

} else {

include('../header/header1.php');
include('adminmenu.php');
include('../header/header3.php');

$id = $_GET["id"];

/* verwerken geposte gegevens */
if(isset($_POST["id"])){
	$query = "UPDATE `tbl_news` SET ";
	$query = $query."`title` = '".mysql_real_escape_string($_POST["title"])."', ";
	$query = $query."`postdate` = '".mysql_real_escape_string($_POST["postdate"])."', ";
	$query = $query."`posterid` = '".mysql_real_escape_string($_SESSION["astridid"])."', ";
	//$query = $query."`description` = '".mysql_real_escape_string($_POST["description"])."', ";
	$query = $query."`description` = '".$_POST["description"]."', ";
	if($_POST["startnull"]!="on") $query = $query."`start` = '".mysql_real_escape_string($_POST["start"])."', ";
	else $query = $query."`start` = NULL, ";
	if($_POST["endnull"]!="on") $query = $query."`end` = '".mysql_real_escape_string($_POST["end"])."', ";
	else $query = $query."`end` = NULL, ";
	if($_POST["datenull"]!="on") $query = $query."`date` = '".mysql_real_escape_string($_POST["date"])."', ";
	else $query = $query."`date` = NULL, ";
	if($_POST["imgnull"]!="on") $query = $query."`img` = '".mysql_real_escape_string($_POST["img"])."', ";
	else $query = $query."`img` = NULL, ";
	if($_POST["fbnull"]!="on") $query = $query."`fb` = '".mysql_real_escape_string($_POST["fb"])."', ";
	else $query = $query."`fb` = NULL, ";
	if($_POST["visible"]=="on") $query = $query."`visible` = '1' ";
	else $query = $query."`visible` = '0' ";
	$query = $query." WHERE `id` = '".$id."';";
	//echo $query." <br />";
	//connectie db
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);
	$result = mysql_query($query) or die("fout: " . mysql_error());
	//echo $result." <br />";
	if($result==1)
		echo '<font color=#55ff55>Update succesvol doorgevoerd</font><br /><br />';
	mysql_close($con);
}

//ophalen waardes uit db
//connectie db
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);
	$result = mysql_query("SELECT * FROM `tbl_news` WHERE id='".$id."'") or die("fout: " . mysql_error());
	$news = mysql_fetch_array($result);
?>

<form method="post" action="editnews.php?id=<?php echo $id; ?>" name="inputform">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<table>
<tr>
<td>Titel</td> <td></td>
<td><input type="text" name="title" length="64" value="<?php echo $news['title']; ?>" /></td></tr>
<tr><td>Post datum</td> <td></td>
<td><input type="text" name="postdate" length="64" value="<?php echo $news['postdate']; ?>" /></td></tr>
<tr><td>Beschrijving</td> <td></td>
<td><textarea rows="5" cols="45" name="description" length="320"><?php echo $news['description']; ?></textarea></td></tr>
<tr><td>Start</td>
<td><input type="checkbox" name="startnull" <?php if($news['start']==null) echo 'checked="true"'; ?> /> null</td> 
<td> <input type="text" name="start" length="64" value="<?php echo $news['start']; ?>" /> </td></tr>
<tr><td>Einde</td>
<td><input type="checkbox" name="endnull" <?php if($news['end']==null) echo 'checked="true"'; ?> /> null</td> 
<td> <input type="text" name="end" length="64" value="<?php echo $news['end']; ?>" /> </td></tr>
<tr><td>Datum</td>
<td><input type="checkbox" name="datenull" <?php if($news['date']==null) echo 'checked="true"'; ?> /> null</td> 
<td> <input type="text" name="date" length="64" value="<?php echo $news['date']; ?>" /> </td></tr>
<tr><td>Afbeelding</td>
<td><input type="checkbox" name="imgnull" <?php if($news['img']==null) echo 'checked="true"'; ?> /> null</td> 
<td> <input type="text" name="img" length="64" value="<?php echo $news['img']; ?>" /> </td></tr>
<tr><td>Facebooklink</td>
<td><input type="checkbox" name="fbnull" <?php if($news['fb']==null) echo 'checked="true"'; ?> /> null</td> 
<td> <input type="text" name="fb" length="64" value="<?php echo $news['fb']; ?>" /> </td></tr>
<tr><td>Zichtbaar</td>
<td><input type="checkbox" name="visible" <?php if($news['visible']==1) echo 'checked="true"'; ?> /> </td><td></td></tr>
<tr> <td></td> <td></td> <td> <input type="submit" value="Pas aan!" /> </td></tr>
</table>
</form>


<?
mysql_close($con);

}
}

include('../footer.php');
?>
