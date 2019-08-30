<?php

define('title','EK pronostiek tornooi - Home Astrid');

session_start();
if(isset($_SESSION['wkid'])){
	header( 'Location: pronostiek.php' );
	exit;
}


$fout=null;

if(!is_null($_POST['submit'])){
    $username = $_POST['username'];
    mysql_real_escape_string($username);
    htmlspecialchars($username);
	$password = $_POST['password'];
    mysql_real_escape_string($password);
    htmlspecialchars($password);
	
	$goed=1;
	if($username==""){
		$fout="geen gebruikersnaam ingevuld.";
		$goed=0;
	}
	if($goed && $password==""){
		$fout="geen wachtwoord ingevuld.";
		$goed=0;
	}
	if($goed){
		include_once('db.php');
		db::open_connection();
		$query = "SELECT `id`,`password`,`admin` FROM `wk_user` WHERE `username`='".$username."';";
		$result1 = mysql_query($query);
		$num=mysql_num_rows($result1);
		db::close_connection();
		
		if($num==0){
			$goed=0;
			$fout="geen gebruiker met die naam gevonden.";
		} else {
			$passcheck2 = mysql_result($result1,0,'password');
			$passcheck1 = md5('s33d'.md5('astridwk'.$password));
			if($passcheck1!==$passcheck2){
				$goed=0;
				$fout="verkeerd wachtwoord.";
			} else {
				$id = mysql_result($result1,0,'id');
				$admin = mysql_result($result1,0,'admin');
				$_SESSION['wkid']=$id;
				if($admin==='1') $_SESSION['wkadmin']=1;
				header('Location: pronostiek.php');
				exit;
			}
		}
	}
}


define('bodyclass','frontpage');
include('const.php');
include('header.php');

?>

		<div class="column left-column">
			<p>Dit is het EK 2016 pronostiek tornooi van Home Astrid.</p>
			<p>Inloggen kun je hiernaast.</p>
			<p>Indien je nog geen login hebt, maar er eentje wil, contacteer dan <a href="https://www.facebook.com/eline.thielemans" target="_blank">Eline</a>.</p>
			<p>Voor alle andere functionaliteiten dient u ingelogd te zijn.</p>
		</div>
		<div class="column right-column">
			<fieldset id="loginform">
				<legend>Inloggen</legend>
				<form action="index.php" method="post">
					<input id="username" type="text" name="username" placeholder="Gebruiker" size="20" value="<?php 
						if(!is_null($_POST['username'])) echo $_POST['username'];?>"/>
					<input id="password" type="password" name="password" placeholder="Wachtwoord" size="20" value=""/>
					<input id="submit" type="submit" name="submit" value="login"/>
					<?php if(isset($fout) && !is_null($fout)) echo '<p style="color: #ff3333;">'.$fout.'</p>'; ?>
				</form>
			</fieldset>
		</div>

<?php

include('footer.php');

?>