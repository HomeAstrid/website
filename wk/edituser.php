<?php

session_start();
if(!isset($_SESSION['wkid'])){
	header( 'Location: index.php' );
	exit;
}
if(!isset($_SESSION['wkadmin'])){
	header( 'Location: index.php' );
	exit;
}
if(!isset($_GET['id']) && !isset($_POST['id'])){
	header( 'Location: index.php' );
	exit;
}

define('title','gebruikersbeheerpaneel');
include_once('header.php');

if(isset($_GET['id'])){
	$id = $_GET['id'];
} else {
	$id = $_POST['id'];
}

if(!preg_match('/^[0-9]{1,6}$/', $id)){
	echo $id.' geen geldig id. Sorry.';
	include_once('footer.php');
	exit;
}

include_once('db.php');
db::open_connection();


if(isset($_POST['id'])){ //verwerk input
	if(isset($_POST['username'])){ //1
		
		$goed=1;
	
		$username = mysql_real_escape_string($_POST['username']);
		if(!preg_match('/^[0-9a-zA-Z]{2,32}$/', $username)){
			echo "slecht gevormde gebruikersnaam";
			$goed=0;
		}
		
		$email = mysql_real_escape_string($_POST['email']);
		$email = htmlspecialchars($email);
		
		$usemail2 = mysql_real_escape_string($_POST['usemail']);
		$usemail = 0;
		if($usemail2=="on") $usemail=1;
		
		if($usemail==1 && $email!==''){
			if($goed && !preg_match('/^[0-9a-zA-Z\.\-_]{2,16}@[a-zA-Z0-9\.\-]{2,16}\.[a-zA-Z]{2,4}$/', $email)){
				echo "slecht gevormd emailadres";
				$goed=0;
			}
		}
		
		if($goed && $usemail != 0 && $usemail != 1){
			echo "slecht gevormd usemail";
			$goed=0;
		}
		
		$admin2 = mysql_real_escape_string($_POST['admin']);
		$admin = 0;
		if($admin2=="on") $admin=1;
		
		if($goed && $admin != 0 && $admin != 1){
			echo "slecht gevormd admin";
			$goed=0;
		}
		
		$betaald2 = mysql_real_escape_string($_POST['betaald']);
		$betaald = 0;
		if($betaald2=="on") $betaald=1;
		
		if($goed && $usemail != 0 && $usemail != 1){
			echo "slecht gevormd betaald";
			$goed=0;
		}
		
		if($goed){
			//bouw query
			if($email==='') $email='NULL';
			else $email = "'".$email."'";
			$query = "UPDATE `wk_user` SET `username`='".$username."', `email`=".$email.", `usemail`='".$usemail."', `admin`='".
			$admin."', `betaald`='".$betaald."' WHERE `id`='".$id."';";
			
			//voer query door
			mysql_query($query);
		}
	
	} 
	
	if(isset($_POST['ww1'])){ //2
	
		$goed = 1;
		$ww1 = mysql_real_escape_string($_POST['ww1']);
		$ww2 = mysql_real_escape_string($_POST['ww2']);
		
		if($ww1 !== $ww2){
			echo "wachtwoorden komen niet overeen";
			$goed=0;
		}
		
		if($goed && $ww1===""){
			echo "wachtwoord is leeg";
			$goed =0;
		}
		
		if($goed) {
			$newhash = md5('s33d'.md5('astridwk'.$ww1));
			$query = "UPDATE `wk_user` SET `password`='".$newhash."' WHERE `id`='".$id."';";
			$result1 = mysql_query($query);
			if(mysql_error()){
				echo "databasefout: ".mysql_error();
			}
		}
	
	}
}


$query = "SELECT * FROM `wk_user` WHERE `id`='".$id."';";

$userresult = mysql_query($query);
if(!$userresult){
	echo 'databasefout. :-(';
	include_once('footer.php');
	exit;
}

db::close_connection();

$user=mysql_fetch_array($userresult);

?>

<style type="text/css">
	#usertable td{
		border: 1px solid black;
	}
</style>
<div id="usertable">
<h1>Gebruiker aanpassen</h1>
<form action="edituser.php?id=<?php echo $user["id"]; ?>" method="post">
<input type="hidden" name="id" value="<?php echo $user["id"];?>" />
<table style="border-collapse: collapse; border-size: 2px; border-style: solid;" id="usertable">
<tr><td>id</td><td><?php echo $user['id'];?></td></tr>
<tr><td>gebruikersnaam &nbsp; &nbsp; </td><td><input type="text" name="username" value="<?php echo $user['username'];?>" size="25"/></td></tr>
<tr><td>emailadres</td><td><input type="text" name="email" value="<?php echo $user['email'];?>" size="25"/></td></tr>
<tr><td>email krijgen</td><td><input name="usemail" type="checkbox" <?php 
if ($user['usemail']=='1') echo 'checked="checked"';?> /></td></tr>
<tr><td>admin</td><td><input name="admin" type="checkbox" <?php 
if ($user['admin']=='1') echo 'checked="checked"';?> /></td></tr>
<tr><td>betaald</td><td><input name="betaald" type="checkbox" <?php 
if ($user['betaald']=='1') echo 'checked="checked"';?> /></td></tr>

<tr><td>score</td><td><?php echo $user['score'];?></td></tr>

<tr><td></td><td><input type="submit" name="submit" value="opslaan"/></td></tr>

</table>
</form>

<h1>Wachtwoord wijzigen</h1>
<form action="edituser.php?id=<?php echo $user["id"]; ?>" method="post">
<input type="hidden" name="id" value="<?php echo $user["id"];?>" />
<table style="border-collapse: collapse; border-size: 2px; border-style: solid;">
<tr><td>Nieuw ww</td><td><input type="password" name="ww1" size="22"/></td></tr>
<tr><td>Nieuw ww (2)</td><td><input type="password" name="ww2" size="22"/></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="opslaan"/></td></tr>
</table>
</form>

</div>


<?php

include('footer.php');

?>