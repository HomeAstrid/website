<?php

session_start();
if(!isset($_SESSION['wkid'])){
	header( 'Location: index.php' );
	exit;
}

define('title','Mijn Account - EK pronostiek tornooi - Home Astrid');
define('pagina','account');

include('const.php');
include('header.php');


$mailfout=null;
$mailgoed=null;
//email gewijzigd?
if(isset($_POST['submitmail'])){
	include_once('db.php');
	db::open_connection();
	$mails = 0;
	if(isset($_POST['mails'])) $mails=1;
	$email = mysql_real_escape_string($_POST['adres']);
	$email = htmlspecialchars($email);
	
	if($mails==1 && !preg_match('/^[0-9a-zA-Z\.\-_]{2,16}@[a-zA-Z0-9\.\-]{2,16}\.[a-zA-Z]{2,4}$/', $email)){
		$mailfout="slecht gevormd e-mailadres";
	} else {
		if($email==='') $email='NULL';
		else $email = "'".$email."'";
		$query = "UPDATE `wk_user` SET `email`=".$email.", `usemail`='".$mails."' WHERE `id`='".$_SESSION['wkid']."';";
		$goed=1;
		$result1 = mysql_query($query);
		if(mysql_error()){
			$mailfout="databasefout: ".mysql_error();
			$goed=0;
		} else {
			$mailgoed = "e-mail voorkeuren succesvol gewijzigd.";
		}
	}
}


//haal gegevens gebruiker op
include_once('db.php');
db::open_connection();
$query = "SELECT * FROM `wk_user` WHERE `id`='".$_SESSION['wkid']."';";
$result1 = mysql_query($query);
$user = mysql_fetch_array($result1);


$wwfout=null;
$wwgoed=null;
//wachtwoord gewijzigd?
if(isset($_POST['submitww'])){
	$oldww = $user['password'];
	$ww = mysql_real_escape_string($_POST['huidig']);
	$ww = md5('s33d'.md5('astridwk'.$ww));
	
	if($oldww !== $ww){
		$wwfout = "oud wachtwoord verkeerd";
	} else {
		$ww1 = mysql_real_escape_string($_POST['nieuw1']);
		$ww2 = mysql_real_escape_string($_POST['nieuw2']);
		if($ww1 !== $ww2){
			$wwfout= "nieuwe wachtwoorden komen niet overeen";
		} else {
			if($ww1===""){
				$wwfout="nieuw wachtwoord is leeg";
			} else {
				$newhash = md5('s33d'.md5('astridwk'.$ww1));
				$query = "UPDATE `wk_user` SET `password`='".$newhash."' WHERE `id`='".$_SESSION['wkid']."';";
				$goed=1;
				$result1 = mysql_query($query);		
				if(mysql_error()){
					$wwfout="databasefout";
					$goed=0;
				} else {
					$wwgoed = "wachtwoord succesvol gewijzigd.";
				}
			}
		}
	}
}

?>

<article>
	<h1>Mijn account</h1>
	<p class="settings"><label>Gebruikersnaam:</label><input disabled value="<?php echo $user['username'];?>" type="text"></p>
	<form action="account.php" method="post" class="settings">
		<h2>Pas wachtwoord aan:</h2>
		<div><label for="huidig">Huidig wachtwoord:</label><input id="huidig" name="huidig" type="password"></div>
		<div><label for="nieuw1">Nieuw wachtwoord:</label><input id="nieuw1" name="nieuw1" type="password"></div>
		<div><label for="nieuw2">'t Nieuwe nogmaals:</label><input id="nieuw2" name="nieuw2" type="password"></div>
		<?php if(isset($wwfout)){ ?> <div style="color:#ff3333;"><?php echo $wwfout; ?></div> <?php } ?>
		<?php if(isset($wwgoed)){ ?> <div style="color:#00cc00;"><?php echo $wwgoed; ?></div> <?php } ?>
		<input value="wijzigen" id="submitww" name="submitww" type="submit">
	</form>
	<br/> <br/> <br/> 
	<!-- <form action="account.php" method="post" class="settings">
		<h2>E-mail voorkeuren:</h2>
		<?php if(isset($_POST['adres'])){ ?>
			<div><label for="adres">E-mailadres:</label><input size="30" id="adres" name="adres" value="<?php echo $_POST['adres']; ?>" type="text"></div>
		<?php } else { ?>
			<div><label for="adres">E-mailadres:</label><input size="30" id="adres" name="adres" value="<?php echo $user['email']; ?>" type="text"></div>
		<?php } ?>
		<div><label></label><label for="mails">
		<input id="mails" name="mails" type="checkbox"
		<?php if($user['usemail']==1) echo 'checked="checked"'; ?> /> E-mails ontvangen</label></div>
		<?php if(isset($mailfout)){ ?> <div style="color:#ff3333;"><?php echo $mailfout; ?></div> <?php } ?>
		<?php if(isset($mailgoed)){ ?> <div style="color:#00cc00;"><?php echo $mailgoed; ?></div> <?php } ?>
		
		<input value="wijzigen" id="submitmail" name="submitmail" type="submit">
	</form> -->
</article>

<?php

db::close_connection();

include('footer.php');

?>