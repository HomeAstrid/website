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

define('title','administratie paneel');
define('script',"<script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script><script>var output;
function geklikt(index){
	goals1=document.getElementById('match'+index+'-goals1').value;
	goals2=document.getElementById('match'+index+'-goals2').value;
	GET2('updateresult.php?matchid='+index+'&goals1='+goals1+'&goals2='+goals2);
	firstchar = output.substring(0,1);
	if(firstchar==='0'){
		inner = '<p style=\"color:#dd5555; font-size:85%;\">';
		inner = inner+output.substring(1);
		//inner = inner+'</p>';
		document.getElementById('response'+index).innerHTML=inner;
	} else {
		inner = '<div id=fade'+index+'><p style=\"color:#33cc33; font-size:85%;\">';
		inner = inner+output.substring(1);
		//inner = inner+'</p></div>';
		document.getElementById('response'+index).innerHTML=inner;
		document.getElementById('button'+index).setAttribute('disabled','disabled');
		//setTimeout(function(){document.getElementById('response'+index).innerHTML=''},3000);
		setTimeout(function(){\$(\"#fade\"+index).fadeOut(1500)},2500);
	}
}
function GET2(url2){
output = $.ajax({ type: 'GET',
         url: url2,   
         async: false}).responseText;
}</script>
<script type='text/javascript' src='sortable.js'></script>");

include('const.php');
include('header.php');

include_once('db.php');
db::open_connection();

$query = "SELECT * FROM `wk_match` ORDER BY `deadline` DESC;";
$result_match_desc = mysql_query($query);


//verwerk eventuele user input
$userfout=null;
$usergoed=null;
if(isset($_POST['toevoegen'])){
	
	$username = mysql_real_escape_string($_POST['username']);
	if(!preg_match('/^[0-9a-zA-Z]{2,32}$/', $username)){
		$userfout="slecht gevormde gebruikersnaam";
	} else {
		$ww1 = mysql_real_escape_string($_POST['password1']);
		$ww2 = mysql_real_escape_string($_POST['password2']);
		if($ww1 !== $ww2){
			$userfout= "wachtwoorden komen niet overeen";
		} else {
			if($ww1===""){
				$userfout="wachtwoord is leeg";
			} else {
				$newhash = md5('s33d'.md5('astridwk'.$ww1));
				$query = "INSERT INTO `astrid`.`wk_user` (`username`,`password`,`email`,`usemail`,`admin`,`score`) VALUES (".
							"'".$username."', '".$newhash."', NULL, '0', '0', '0');";
				$goed=1;
				$result1 = mysql_query($query);		
				if(mysql_error()){
					$userfout="databasefout: ".mysql_error();
					$goed=0;
				} else {
					$usergoed = "gebruiker succesvol toegevoegd.";
				}
			}
		}
	}
}


//update scores?
$updatefout=null;
$updategoed=null;
$goed=1;
if(isset($_POST['update'])){

	//update totaal aantal goals
	
	$query = "SELECT SUM(`goals1`)+SUM(`goals2`) FROM  `wk_match` WHERE `id`!=65; ";
	$totaal = mysql_query($query);
	$goals = mysql_result($totaal,0);
	$query = "UPDATE `wk_match` set `goals2`= '".$goals."' WHERE `id`=65;";
	$update = mysql_query($query);
	

	$query = "SELECT `id`, `score-winner`, `score-goals`, `goals1`, `goals2` FROM `wk_match`";
	$matchen = mysql_query($query);
	
	if(mysql_error()){
		$updatefout = "databasefout :(";
		$goed=0;
	}
	
	if($goed){
		$query = "SELECT * FROM `wk_guess`";
		$guesses = mysql_query($query);
		if(mysql_error()){
			$updatefout = "databasefout :(";
			$goed=0;
		}
	}
	
	//updaten scores van alle guesses
	if($goed){
		while($guess=mysql_fetch_array($guesses)) {
			while($match=mysql_fetch_array($matchen)) {
				if($match['id']===$guess['matchid']){
					if($match['id']!=65){
						$punten=0;
						if(!isset($match['goals1'])){
							$punten="NULL";
						} else {
							if($match['goals1'] > $match['goals2']
							&& $guess['goals1'] > $guess['goals2']){
								$punten=$match['score-winner'];
							}
							if($match['goals1'] < $match['goals2']
							&& $guess['goals1'] < $guess['goals2']){
								$punten=$match['score-winner'];
							}
							if($match['goals1'] === $match['goals2']
							&& $guess['goals1'] === $guess['goals2']){
								$punten=$match['score-winner'];
							}
							if($match['goals1'] === $guess['goals1']
							&& $match['goals2'] === $guess['goals2']){
								$punten=$match['score-goals'];
							}
						}
						$query = "UPDATE `wk_guess` SET `score`=".$punten." WHERE `id`='".$guess['id']."';";
						$result=mysql_query($query); //niets doen indien fout, is toch maar een UPDATE operatie he :-)
					} else {
						$schifting = $guess['goals2'];
						$echt = $match['goals2'];
						$verschil = $schifting - $echt;
						if($verschil<0) $verschil=$verschil*(-1);
						$user = $guess['userid'];
						
						$query = "UPDATE `wk_user` SET `schifting`='".$verschil."' WHERE `id`='".$user."';";
						$result=mysql_query($query); //niets doen indien fout, is toch maar een UPDATE operatie he :-)
					}
				}
			}
			if(mysql_num_rows($matchen)>=1) mysql_data_seek($matchen,0);
		}
		if(mysql_num_rows($guesses)>=1) mysql_data_seek($guesses,0);
	}
	
	//score user = sum(score(guesses_van_user)), en die kan meteen gequery'd worden
	
	if($goed){
		$query = "SELECT `wk_guess`.`userid`,SUM(`wk_guess`.`score`) as `score` FROM `wk_guess` ".
		"INNER JOIN `wk_user` ON `wk_guess`.`userid`=`wk_user`.`id` GROUP BY `wk_guess`.`userid`;";
		$scores = mysql_query($query);
		if(mysql_error()){
			$updatefout = "databasefout :(";
			$goed=0;
		}
	}
	
	if($goed){
		//alle nietvoorkomende: null
		$query = "UPDATE `wk_user` SET `score`=NULL;";
		$result = mysql_query($query); //fout: best negeren...
		while($score=mysql_fetch_array($scores)) {
			$query = "UPDATE `wk_user` SET `score`='".$score['score']."' WHERE `id`='".$score['userid']."';";
			//echo $query;
			$result = mysql_query($query); //fout: best negeren...
		}
		if(mysql_num_rows($scores)>=1) mysql_data_seek($scores,0);
	}
	
	if($goed){
		$updategoed="scores succesvol geupdate.";
	}
	
}

$query = "SELECT `id`,`username` FROM `wk_user` ORDER BY `id` ASC;";

$userresult = mysql_query($query);
if(!$userresult){
	echo 'databasefout. :-(';
	include_once('footer.php');
	exit;
}

db::close_connection();

?>

<div id="adminpaneel">

<h1>Matchen &amp; uitslagen</h1><br/>

<p> <b>Gespeelde matchen:</b> </p><br/>

<div class="spacetable">
<table style="border:none;  border-collapse:collapse; text-align:center;">
<tr><th>Deadline</th><th>Tijd match</th><th>Ploegen</th><th>Uitslag</th><th>Score</th><th></th><th></th></tr>
<?php
	$i=0;
	while($row=mysql_fetch_array($result_match_desc)) {
		if(strtotime($row['deadline']) <= strtotime('now') ){
			
			$i=$i+1;
			$date1 = new DateTime($row['deadline']);
			$date2 = new DateTime($row['played']);
			
			if($i%2==0){
				echo '<tr style="background-color:#ffffc0;">';
			} else {
				echo '<tr>';
			}
			echo '<td>'.$date1->format('d/m H:i').'</td><td>'.$date2->format('d/m H:i').'</td>';
			
			echo '<td>'.utf8_encode($row['team1']).' - '.utf8_encode($row['team2']).'</td>'."\r\n";
			
			$goals1=$row['goals1'];
			$goals2=$row['goals2'];
			$nieuw=0;
			if(!isset($goals1)){
				$nieuw=1;
				$goals1='??';
				$goals2='??';
			}
			
			echo "\r\n".'<td> &nbsp; <input type="text" size="1" id="match'.$row['id'].'-goals1" value="'.$goals1.'" autocomplete="off" ';
			echo "onchange=\"\$('#button".$row['id']."').removeAttr('disabled');\" onfocus=\"if (this.value == '??') {this.value = '';}\" /> - \r\n";
			echo '<input type="text" size="1" id="match'.$row['id'].'-goals2" value="'.$goals2.'" autocomplete="off" ';
			echo "onchange=\"\$('#button".$row['id']."').removeAttr('disabled');\" onfocus=\"if (this.value == '??') {this.value = '';}\" />\r\n";
			echo '&nbsp; </td>'; //TODO pronostiek
			echo '<td>'.$row['score-winner'].' / '.$row['score-goals'].'</td>';
			echo '<td><button type="button" id="button'.$row['id'].'" onclick="geklikt('.$row['id'].')" ';
			//if($nieuw==0) echo 'disabled="disabled"';
			echo 'disabled="disabled"';
			echo '>&nbsp;opslaan&nbsp;</button></td>';
			echo '<td><p id="response'.$row['id'].'"></p></td></tr>';
		}
	}
	if(mysql_num_rows($result_match_desc)>=1) mysql_data_seek($result_match_desc,0);
?>
</table></div>
<p style="font-size:80%;"><b>Ververs steeds de pagina</b> om zeker te zijn dat de correcte uitslagen op de server staan.</p>
<!--[if lt IE 9]>
<br/><p style="font-size:80%;">Werkt <b>niet op Internet Explorer ouder dan 9</b>. Gebruik graag gratis een <a href="http://getfirefox.com">een betere browser</a></p>
<![endif]-->
<br/>

<p> <b>Komende matchen:</b> </p><br/>
<p> Aanpassingen in komende matchen enkel mogelijk in  <a href="http://astrid.ugent.be/phpmyadmin">phpmyadmin</a>.</p><br/>
<br/><br/>



<h1>Update scores</h1><br/>
<p><b>Update de scores van alle gebruikers &amp; de rangschikking.</b></p><br/>
<form action="admin.php" method="post"><p><input type="submit" value="update scores" id="update" name="update"/></p>
<p id="updatefeedback"/>
<?php if(isset($updatefout)) echo '<br/><p style="color:#ff3333;">'.$updatefout.'</p>'; ?>
<?php if(isset($updategoed)) echo '<br/><p style="color:#00cc00;">'.$updategoed.'</p>'; ?>
</p>
</form><br/><br/>
</div><br/><br/>



<?php if(false){ ?>
<h1>Mails versturen</h1><br/>
<p> Automatische dagmail: </p><br/>
<form action="mail.php" method="post">
<input id="mail" type="submit" name="mail" value="Stuur de mail." disabled="disabled"/><br/>
	<?php if(isset($mailfout)){ ?> <p style="color:#ff3333;"><?php echo $mailfout; ?></p> <?php } ?>
	<?php if(isset($mailgoed)){ ?> <p style="color:#00cc00;"><?php echo $mailgoed; ?></p> <?php } ?>
<br/><br/>
</form>
<br/>
<?php } ?>

<h1>Gebruikersbeheer</h1><br/>

<p><b>Gebruiker toevoegen:</b></p><br/>
<form action="admin.php" method="post">
<table style="border:none;">
<tr><td><label for="username">Gebruikersnaam:</label></td><td><input type="text" id="username" name="username" value="<?php 
if(isset($_POST['username']) && isset($userfout)) echo $_POST['username']?>"/></td></tr>
<tr><td><label for="password1">Wachtwoord:</label></td><td><input type="password" id="password1" name="password1"/></td></tr>
<tr><td><label for="password2">Wachtwoord (2):</label></td><td><input type="password" id="password2" name="password2"/></td></tr>
<?php if(isset($userfout)){ ?> <tr><td colspan="2" style="color:#ff3333;"><?php echo $userfout; ?></td></tr> <?php } ?>
<?php if(isset($usergoed)){ ?> <tr><td colspan="2" style="color:#00cc00;"><?php echo $usergoed; ?></td></tr> <?php } ?>
<tr><td></td><td><input type="submit" value="toevoegen" id="toevoegen" name="toevoegen"/></td></tr>
</table>
</form><br/>


<h2>Bestaande gebruikers</h2>
<div id="listusers">
<style type="text/css">
	#listusers td{
		border: 1px solid black;
	}
	table.sortable thead {
		border-collapse: collapse;
		border: 1px solid black;
		font-weight: bold;
		cursor: default;
	}
</style>
<table style="border-collapse: collapse;" id="usertable" class="sortable">
<thead>
<tr><th>id</th><th>gebruikersnaam</th><th>edit</th></tr>
</thead>
<tbody>
<?php
	while($user=mysql_fetch_array($userresult)) {
		echo '<tr><td style="width:60px;">';
		echo $user['id'];
		echo '</td><td style="width:250px;">';
		echo $user['username'];
		echo '</td><td><a href="edituser.php?id='.$user["id"].'"><img src="edit.png"/></a></td></tr>'."\r\n";
	}
	if(mysql_num_rows($userresult)>=1) mysql_data_seek($userresult,0);
?>
</tbody>
</table>
</div>

<br/><br/>

<?php

include('footer.php');

?>