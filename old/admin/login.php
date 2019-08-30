<?php

session_start();

define('title','Admin:: logout');

include('../const.php');
include('../header/header1.php');

?>

            <div id="header">
                    <div class="menu">
                    <ul>
                    <li><a href="<?php echo base_url();?>" target="_self" >Home</a></li>
                    </ul>
                    </div>

            </div>

<?php
include('../header/header3.php');
?>

<br /> <br />

<?php
if(isset($_SESSION["astridusername"])){
	echo 'reeds ingelogd als '.$_SESSION["astridusername"].'.<br/> Gelieve eerst <a href="'.base_url().'/admin/logout.php">uit te loggen</a> alvorens nogmaals in te loggen. <br/>';
} else {
?>

<?php
//check login:

//valid login info?
$check=1;
if(is_null($_POST['username'])) $check=0;
if($check==1 and $_POST['username']=="") $check=0;
if($check==1 and is_null($_POST['password'])) $check=0;
if($check==1 and $_POST['password']=="") $check=0;

if($check==1){
	//valid login info: check with db

	//connectie db
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);

	//gebruiker?
	$username = mysql_real_escape_string($_POST['username']);
	$result = mysql_query("SELECT COUNT(*) FROM `users` WHERE username='".$username."'")  or die("fout: " . mysql_error());;
	$count=mysql_result($result,0);
	if ($count!=1){
		$check=0;
	} else {
		$result = mysql_query("SELECT active FROM `users` WHERE username='".$username."'")  or die("fout: " . mysql_error());;
		$active = mysql_result($result,0);
		$result = mysql_query("SELECT password FROM `users` WHERE username='".$username."'")  or die("fout: " . mysql_error());;
		$passdb = mysql_result($result,0);
		$password=mysql_real_escape_string($_POST['password']);
		if($active==1 and $passdb==md5("aStRid".$password)){
			$_SESSION["astridusername"]=$username;
			
			$result = mysql_query("SELECT admin FROM `users` WHERE username='".$username."'")  or die("fout: " . mysql_error());;
			$admin = mysql_result($result,0);
			$_SESSION["astridadmin"]=$admin;
			
			$result = mysql_query("SELECT id FROM `users` WHERE username='".$username."'")  or die("fout: " . mysql_error());;
			$userid = mysql_result($result,0);
			$_SESSION["astridid"]=$userid;
			echo 'ingelogd!<br/><HEAD><meta http-equiv="REFRESH" content="0;url='.base_url().'/admin/"></HEAD>';
		} else {
			if($active==0 and $passdb==md5("aStRid".$password)){
				echo 'uw account werd gedeactiveerd. Helaas!';
			} else {
				$check=0;
			}
		}
	}
	mysql_close($con);
}
if($check==0){
?>

<form name="form1" method="post" action="login.php">
<table border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td colspan="2"><strong>Admin Login </strong></td>
</tr>
<tr><td colspan="2"><font color=#FF3333>
<?php
if(!is_null($_POST['username']) and $_POST['username']==""){
	echo 'Gelieve een gebruikersnaam in te vullen';
} else {
	if(!is_null($_POST['username'])) echo 'Verkeerde logincombinatie.';
}
?>
</font></td></tr>
<tr>
<td>Gebruikersnaam:</td>
<?php
if(!is_null($_POST['username']) and $_POST['username']!=""){
echo '<td><input name="username" type="text" id="username" value="'.$_POST['username'].'"></td>';
} else {
echo '<td><input name="username" type="text" id="username"></td>';
}
?>
</tr>
<tr>
<td>Wachtwoord:</td>
<td><input name="password" type="password" id="password"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Login"></td>
</tr>
</table>
</form>



<?php

}
}
include('../footer.php');

?>
