<?php

session_start();

if(!isset($_GET['cronpass'])) {

if(!isset($_SESSION['wkid'])){
	header( 'Location: index.php' );
	exit;
}
if(!isset($_SESSION['wkadmin'])){
	header( 'Location: index.php' );
	exit;
}

$cron=0;
} else {
	$cronpass = $_GET['cronpass'];
	if($cronpass!=='kBBFYXoIO4636BVG'){
		echo 'fuck off';
		exit;
	}
	$cron=1;
}

setlocale(LC_TIME, 'Dutch'); 
define('title','mail');

if($cron==0){ //cron = no html output
	include('const.php');
	include('header.php');
}

$mailfout=null;
$mailgoed=null;
$count=0;

if($cron==1 || !is_null($_POST['mail'])){
	include_once('db.php');
	db::open_connection();

	$nbmatchen=0;
	
	$date=date("Y-m-d");
	$query = "SELECT * FROM `wk_match` WHERE `deadline` BETWEEN \"".$date." 00:00:00\" AND \"".$date
		." 23:59:59\" ORDER BY `deadline` ASC;";
		//echo $query;
	$result=mysql_query($query);
	
	if(mysql_error()){
		$mailfout="databasefout :-(";
		echo mysql_error();
	}
	
	if(!isset($mailfout)){
		$query="SELECT `username`,`email` FROM `wk_user` WHERE `usemail`='1'";
		$users = mysql_query($query);
		if(mysql_error()){
			$mailfout="databasefout :-(";
			echo mysql_error();
		}
	}
	
	$aantalmatchen=0;
	while($match=mysql_fetch_array($result)) {
		$aantalmatchen = $aantalmatchen+1;
	}
	if(mysql_num_rows($result)>=1) mysql_data_seek($result,0);
	
	if(!isset($mailfout) && $aantalmatchen>0){
		$onderwerp="WK-pronostiek: dagmail van ".strtolower(nlDate("l j F Y"));
		$van = "WK Pronostiek Home Astrid <wkpronostiek@pieterreuse.be>";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: '.$van . "\r\n" .
			'Reply-To: '.$van . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$mail="Hoi %naam%,\r\n\r\nHier zijn we weer met de dag-wk-mail van <b>".
		//strftime("%A %e %B %Y", mktime(0,0,0,date("n")+0,date("j")+0,date("Y")+0)).
		//strftime("%A %e %B %Y").
		strtolower(nlDate("l j F Y")).
		"</b>.\r\nVandaag vallen de deadlines voor de pronostieken van deze matchen:\r\n\r\n";
		while($match=mysql_fetch_array($result)) {
			//$mail=$mail.'<tr><td>';
			//$mail=$mail. $match['deadline'].'</td><td>'.$match['played'].'</td><td>'.utf8_encode($match['team1']).'</td><td>'.
			//	utf8_encode($match['team2']).'</td><td>'.$match['score-winner'].'</td><td>'.$match['score-goals'];
			//$mail=$mail.'</td></tr>';
			$mail=$mail.'Op '.str_replace("|","om",strtolower(nlDate("l j F | G:i",strtotime($match['played'])))).
					' spelen <b>'.utf8_encode($match['team1']).'</b> en <b>'.utf8_encode($match['team2']).'</b> tegen elkaar.'.
					' Je pronostiek invullen of aanpassen kan tot en met <b>'.
					str_replace("|","om",strtolower(nlDate("l j F | G:i",strtotime($match['deadline'])))).
					'</b>.'.
					' Met deze match zijn '.$match['score-winner'].' punten te verdienen als je de juiste winnaar kan raden en '.$match['score-goals'].
					' punten als je de juiste eindstand hebt kunnen voorspellen.'.
					"\r\n\r\n";
		}
		if(mysql_num_rows($result)>=1) mysql_data_seek($result,0);
		$mail=$mail.'Inloggen en pronostikeren kan <a href="http://astrid.ugent.be/wk/">op de site</a>.'."\r\n\r\nMet vriendelijke groeten,\r\n".
			"Pieter Reuse\r\nICT-verantwoordelijke Home Astrid\r\nNamens de Homeraad van Home Astrid";
		$mail=$mail."\r\n\r\n".'<p style="font-size:80%;">PS: wilt u deze e-mails niet meer ontvangen? Vink \'E-mails ontvangen\''.
		' uit op je <a href="http://astrid.ugent.be/wk/account.php">account-pagina</a>.</p>';
		$mail = str_replace("\r\n","<br/>",$mail);
		//echo str_replace("\r\n","<br/>",$mail);
		
		while($user=mysql_fetch_array($users)) {
			if(isset($user['email'])){
				//echo str_replace("\r\n","<br/>",str_replace("%naam%",$user['username'],$mail));
				$mailtekst=str_replace("%naam%",$user['username'],$mail);
				$verstuurd = mail($user['email'],$onderwerp,$mailtekst,$headers);
				if($verstuurd) $count=$count+1;
			}
		}
		if(mysql_num_rows($users)>=1) mysql_data_seek($users,0);
		$mailgoed=$count." mails succesvol verstuurd.";
	}
	
	db::close_connection();

}

if($cron==0){

?>

<h1>Mails versturen</h1><br/>
<p> Automatische dagmail: </p><br/>
<form action="mail.php" method="post">
<input id="mail" type="submit" name="mail" value="Stuur de mail." /><br/>
	<?php if(isset($mailfout)){ ?> <p style="color:#ff3333;"><?php echo $mailfout; ?></p> <?php } ?>
	<?php if(isset($mailgoed)){ ?> <p style="color:#00cc00;"><?php echo $mailgoed; ?></p> <?php } ?>
<br/><br/>
</form>

<?php

} //if not cron
else { //else only the feedback

	if(isset($mailfout)){ echo $mailfout; }
	if(isset($mailgoed)){ echo $mailgoed; }
	echo "\r\n";

}

function nlDate($parameters, $timestamp=null){

if(!isset($timestamp)) $timestamp=time();

// AM of PM doen we niet aan
$parameters = str_replace("A", "", $parameters);
$parameters = str_replace("a", "", $parameters);

$datum = date($parameters,$timestamp);

// Vervang de maand, klein
$datum = str_replace("january", "januari", $datum);
$datum = str_replace("february", "februari", $datum);
$datum = str_replace("march", "maart", $datum);
$datum = str_replace("april", "april", $datum);
$datum = str_replace("may", "mei", $datum);
$datum = str_replace("june", "juni", $datum);
$datum = str_replace("july", "juli", $datum);
$datum = str_replace("august", "augustus", $datum);
$datum = str_replace("september", "september", $datum);
$datum = str_replace("october", "oktober", $datum);
$datum = str_replace("november", "november", $datum);
$datum = str_replace("december", "december", $datum);

// Vervang de maand, hoofdletters
$datum = str_replace("January", "Januari", $datum);
$datum = str_replace("February", "Februari", $datum);
$datum = str_replace("March", "Maart", $datum);
$datum = str_replace("April", "April", $datum);
$datum = str_replace("May", "Mei", $datum);
$datum = str_replace("June", "Juni", $datum);
$datum = str_replace("July", "Juli", $datum);
$datum = str_replace("August", "Augustus", $datum);
$datum = str_replace("September", "September", $datum);
$datum = str_replace("October", "Oktober", $datum);
$datum = str_replace("November", "November", $datum);
$datum = str_replace("December", "December", $datum);

// Vervang de maand, kort
$datum = str_replace("Jan", "Jan", $datum);
$datum = str_replace("Feb", "Feb", $datum);
$datum = str_replace("Mar", "Maa", $datum);
$datum = str_replace("Apr", "Apr", $datum);
$datum = str_replace("May", "Mei", $datum);
$datum = str_replace("Jun", "Jun", $datum);
$datum = str_replace("Jul", "Jul", $datum);
$datum = str_replace("Aug", "Aug", $datum);
$datum = str_replace("Sep", "Sep", $datum);
$datum = str_replace("Oct", "Ok", $datum);
$datum = str_replace("Nov", "Nov", $datum);
$datum = str_replace("Dec", "Dec", $datum);

// Vervang de dag, klein
$datum = str_replace("monday", "maandag", $datum);
$datum = str_replace("tuesday", "dinsdag", $datum);
$datum = str_replace("wednesday", "woensdag", $datum);
$datum = str_replace("thursday", "donderdag", $datum);
$datum = str_replace("friday", "vrijdag", $datum);
$datum = str_replace("saturday", "zaterdag", $datum);
$datum = str_replace("sunday", "zondag", $datum);

// Vervang de dag, hoofdletters
$datum = str_replace("Monday", "Maandag", $datum);
$datum = str_replace("Tuesday", "Dinsdag", $datum);
$datum = str_replace("Wednesday", "Woensdag", $datum);
$datum = str_replace("Thursday", "Donderdag", $datum);
$datum = str_replace("Friday", "Vrijdag", $datum);
$datum = str_replace("Saturday", "Zaterdag", $datum);
$datum = str_replace("Sunday", "Zondag", $datum);

// Vervang de verkorting van de dag, hoofdletters
$datum = str_replace("Mon", "Maa", $datum);
$datum = str_replace("Tue", "Din", $datum);
$datum = str_replace("Wed", "Woe", $datum);
$datum = str_replace("Thu", "Don", $datum);
$datum = str_replace("Fri", "Vri", $datum);
$datum = str_replace("Sat", "Zat", $datum);
$datum = str_replace("Sun", "Zon", $datum);

return $datum;

}

if($cron==0){ //cron = no html
	include('footer.php');
}
?>