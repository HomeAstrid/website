<?php

define('title','inloggen');

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


include('const.php');
include('header.php');

?>

<h1>Inloggen</h1><br/>
<!--<p> Hier kun je je inloggen: </p><br/>-->
<form action="login.php" method="post">
<table style="border:0;"><tr><td>
<label for="username">Gebruiker:</label></td><td> <input id="username" type="text" name="username" size="20" value="<?php if(!is_null($_POST['username'])) echo $_POST['username'];?>"/> </td></tr><tr><td>
<label for="password">Wachtwoord:</label></td><td> <input id="password" type="password" name="password" size="20" value=""/> </td></tr><tr><td></td><td>
<input id="submit" type="submit" name="submit" value="login"/></td></tr>
<? if(!is_null($fout)) echo '<tr><td></td><td><p style="color: #ff3333;">'.$fout.'</p></td></tr>'; ?>
</table>
<br/><br/>
</form>
<p> Indien je nog geen login hebt, maar er eentje wil, contacteer dan <a href="https://facebook.com/pieterreuse" target="_blank">Pieter</a>.</p>
<p> Wachtwoord kwijt? Dan geldt hetzelfde!</p>

<?php

include('footer.php');

?>