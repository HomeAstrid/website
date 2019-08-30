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
if(isset($_POST["username"]) and mysql_real_escape_string($_POST["username"]==""))
		echo '<font color=#ff5555><b>Ongeldige gebuikersnaam.</b></font>';
else
if(isset($_POST["id"])){
	//connectie db
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);
	$result = mysql_query("SELECT COUNT(*) FROM `users` WHERE `username`='".mysql_real_escape_string($_POST["username"])."' AND `id`<>".mysql_real_escape_string($_POST["id"])) or die("fout: " . mysql_error());;
	$count = mysql_result($result,0);
	if($count==0){
	

	$query = "UPDATE `users` SET ";
	$query = $query."`username` = '".mysql_real_escape_string($_POST["username"])."', ";
	$query = $query."`e-mail` = '".mysql_real_escape_string($_POST["e-mail"])."', ";
	if($_POST["newpw"]=="on") $query = $query."`password` = '".md5("aStRid".$_POST["password"])."', ";
	$query = $query."`admin` = '";
	if($_POST["admin"]=="on") $query = $query."1";
	else $query=$query."0";
	$query=$query."', `active`='";
	if($_POST["active"]=="on") $query = $query."1";
	else $query=$query."0";
	$query = $query."' WHERE `id` = '".$id."';";

	$result = mysql_query($query) or die("fout: " . mysql_error());
	//echo $result." <br />";
	if($result==1)
		echo '<font color=#55ff55>Update succesvol doorgevoerd</font><br /><br />';
	mysql_close($con);

	} else {
		echo '<font color=#ff5555><b>Gebruikersnaam reeds bezet.</b></font>';
	}
}

//ophalen waardes uit db
//connectie db
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);
	$result = mysql_query("SELECT * FROM `users` WHERE id='".$id."'") or die("fout: " . mysql_error());
	$user = mysql_fetch_array($result);
?>

<form method="post" action="edituser.php?id=<?php echo $id; ?>" name="inputform">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<table>
<tr>
<td>Gebruikersnaam</td> <td></td>
<td><input type="text" name="username" length="64" value="<?php echo $user['username']; ?>" /></td></tr>
<tr><td>e-mailadres</td> <td></td>
<td><input type="text" name="e-mail" length="64" value="<?php echo $user['e-mail']; ?>" /></td></tr>
<tr><td>Wachtwoord</td>
<td><input type="checkbox" name="newpw" /> nieuw</td> 
<td> <input type="password" name="password" length="64" value="" /> </td></tr>
<tr><td>admin</td>
<td colspan="2"><input type="checkbox" name="admin" <?php if($user['admin']==1) echo 'checked="true"'; ?> /> </td></tr>
<tr><td>actief</td>
<td colspan="2"><input type="checkbox" name="active" <?php if($user['active']==1) echo 'checked="true"'; ?> /> </td></tr>
<tr> <td></td> <td></td> <td> <input type="submit" value="Pas aan!" /> </td></tr>
</table>
</form>


<?
mysql_close($con);

}
}

include('../footer.php');
?>
