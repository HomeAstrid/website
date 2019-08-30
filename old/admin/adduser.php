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
$error="";
$errorfield="";
if(isset($_POST["username"]) and mysql_real_escape_string($_POST["username"])==""){
	$errorfield="username";
	$error="Gebruikersnaam mag niet leeg zijn!";
} else if (isset($_POST["username"]) and mysql_real_escape_string($_POST["password"])==""){
	$errorfield="password";
	$error="Wachtwoord mag niet leeg zijn!";
} else
if(isset($_POST["username"])){
	//connectie db
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);

	$result = mysql_query("SELECT COUNT(*) FROM `users` WHERE `username`='".mysql_real_escape_string($_POST["username"])."'") or die("fout: " . mysql_error());
	$count = mysql_result($result,0);
	if($count==0){

	$query = "INSERT INTO `users` (`id`, `username`, `password`, `e-mail`,`admin`, `active`) VALUES (";
	$result = mysql_query("SELECT COUNT(*) FROM `users`")  or die("fout: " . mysql_error());;
	$id = mysql_result($result,0)+1;
	
	$query = $query."'".$id."', ";
	$query = $query."'".mysql_real_escape_string($_POST["username"])."', ";
	$query = $query."'".md5("aStRid".$_POST["password"])."', ";
	$query = $query."'".mysql_real_escape_string($_SESSION["e-mail"])."', ";
	if($_POST["admin"]=="on") $query = $query."'1',";
	else $query = $query."'0',";
	if($_POST["active"]=="on") $query = $query."'1');";
	else $query = $query."'0');";

	$result = mysql_query($query) or die("fout: " . mysql_error());
	if($result==1)
		echo '<font color=#55ff55>Succesvol toegevoegd</font><br /><br />';

	} else {
		$errorfield="username";
		$error="Gebruikersnaam reeds bezet!";
	}
	mysql_close($con);
}

if(isset($_POST["username"])){
//ingevulde versie

?>

<form method="post" action="adduser.php" name="inputform">
<table>
<?php if($errorfield=="username") echo '<tr><td colspan="2"><font color=#ff5555>'.$error.'</font></td></tr>'; ?>
<tr>
<td>Gebruikersnaam</td>
<td><input type="text" name="username" length="64" value="" /></td></tr>
<tr><td>e-mailadres</td>
<td><input type="text" name="e-mail" length="64" value="" /></td></tr>
<?php if($errorfield=="password") echo '<tr><td colspan="2"><font color=#ff5555>'.$error.'</font></td></tr>'; ?>
<tr><td>Wachtwoord</td>
<td> <input type="password" name="password" length="64" value="" /> </td></tr>
<tr><td>admin</td>
<td><input type="checkbox" name="admin" /></td></tr>
<tr><td>actief</td>
<td><input type="checkbox" name="active" checked="true" /> </td></tr>
<tr> <td></td> <td> <input type="submit" value="Maak gebruiker!" /> </td></tr>
</table>
</form>

<?php

} else {

//niet ingevuld

?>

<form method="post" action="adduser.php" name="inputform">
<table>
<tr>
<td>Gebruikersnaam</td>
<td><input type="text" name="username" length="64" value="" /></td></tr>
<tr><td>e-mailadres</td>
<td><input type="text" name="e-mail" length="64" value="" /></td></tr>
<tr><td>Wachtwoord</td>
<td> <input type="password" name="password" length="64" value="" /> </td></tr>
<tr><td>admin</td>
<td><input type="checkbox" name="admin" /></td></tr>
<tr><td>actief</td>
<td><input type="checkbox" name="active" checked="true" /> </td></tr>
<tr> <td></td> <td> <input type="submit" value="Pas aan!" /> </td></tr>
</table>
</form>


<?php
}
}

include('../footer.php');
?>
