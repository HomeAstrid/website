<?php

session_start();
if(!isset($_SESSION['wkid'])){
	header( 'Location: index.php' );
	exit;
}

define('title','Mijn Pronostieken - WK pronostiek tornooi - Home Astrid');
define('pagina','pronostiek');

//define('script','<script src="matchen.js"></script>');
define('script',"<script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script><script>var output;
function geklikt(index){
	if(index!=65){
		goals1=document.getElementById('match'+index+'-goals1').value;
		goals2=document.getElementById('match'+index+'-goals2').value;
		GET2('updateguess.php?matchid='+index+'&goals1='+goals1+'&goals2='+goals2);
	} else {
		goals2=document.getElementById('match'+index+'-goals2').value;
		GET2('updateguess.php?matchid='+index+'&goals2='+goals2);	
	}
	firstchar = output.substring(0,1);
	if(firstchar==='0'){
		inner = '<p style=\"color:#dd5555; font-size:85%;\">';
		inner = inner+output.substring(1);
		//inner = inner+'</p>';
		document.getElementById('response'+index).innerHTML=inner;
	} else {
		//inner = '<div id=fade'+index+'><p style=\"color:#33cc33; font-size:75%;\">';
		inner = '<span id=fade'+index+' style=\"color:#33cc33; font-size:75%;\">';
		inner = inner+output.substring(1);
		//inner = inner+'</span>';
		document.getElementById('response'+index).innerHTML=inner;
		document.getElementById('button'+index).setAttribute('disabled','disabled');
		//setTimeout(function(){document.getElementById('response'+index).innerHTML=''},3000);
		setTimeout(function(){\$(\"#fade\"+index).fadeOut(1500)},2000);
	}
}
function GET2(url2){
output = $.ajax({ type: 'GET',
         url: url2,   
         async: false}).responseText;
}
$(document).ready(function(){
	$('.latervolgend').hide(0);
});
</script>");

include('const.php');
include('header.php');

include_once('db.php');
db::open_connection();

$query = "SELECT * FROM `wk_match` ORDER BY `deadline` ASC;";
$result_match_asc = mysql_query($query);

$query = "SELECT * FROM `wk_match` ORDER BY `deadline` DESC;";
$result_match_desc = mysql_query($query);

$query = "SELECT * FROM `wk_guess` WHERE `userid`='".$_SESSION['wkid']."' ORDER BY `matchid` ASC;";
$result_user = mysql_query($query);

db::close_connection();

?>

<p style="font-size:160%;"><b>Bedankt aan iedereen om mee te spelen!<br/>
Eervolle vermeldingen voor Wim, winnaar van het tornooi,<br/> en Daphn<?php echo utf8_encode('é');?> die van het begin tot 
vlak vor het einde aan de leiding stond! <br/><br/>
Ook proficiat aan Robin, Jasper en Lisa die ook geldprijzen winnen!<br/>
Tenslotte ook proficiat aan Pim, die de algemene top vijf ook haalde!</p>
<br/>

<p style="font-size:140%;">Winnaars kunnen langsgaan bij Jasper of Pieter voor het innen van de geldprijs. <br/>
Indien moeilijk praktisch haalbaar, mag je je rekeningnummer doorgeven aan Pieter.</p>

	<article>
		<h1>Komende matchen</h1>

<?php
	$i=0;
	while($row=mysql_fetch_array($result_match_asc)) {
	
	$ts1=strtotime('now');
	$ts2=strtotime($row['deadline']);
	$seconds_diff = $ts2 - $ts1;
	$daydiff=floor($seconds_diff/3600/24);
		if(strtotime($row['deadline']) > strtotime('now') ){
			$i=$i+1; //match $i
			
			if($i==1){ //eerste keer: header tabel
				echo '<table class="matches nextup">'."\r\n".
					'<tr class="matches-head"><th>Deadline</th><th>Tijd match</th>';
				echo '<th>Ploegen</th><th>Prono</th><th>Score<br><strong>(winnaar-uitslag)</strong></th>';
				echo '<th></th><th></th></tr>'."\r\n";
			}
			
			$date1 = new DateTime($row['deadline']);
			$date2 = new DateTime($row['played']);
			
			//if($i%2==0){
			echo "\r\n";
			if($daydiff<3){
				echo '<tr data-row="13" test="'.$daydiff.'">';
			} else {
				echo '<tr data-row="13" class="latervolgend">';
			}
			//} else {
				//echo '<tr>';
			//}
			echo '<td>'.$date1->format('d/m H:i').'</td><td>'.$date2->format('d/m H:i').'</td>';
			
			echo '<td>'.utf8_encode($row['team1']).' - '.utf8_encode($row['team2']).'</td>'."\r\n";
			
			$goals1=null;
			$goals2=null;
			//vind uitslag van mijn pronostiek en evt bijhorende score
			$found=0;
			while($row2=mysql_fetch_array($result_user)){
				if($row2['matchid']==$row['id']){
					$goals1=$row2['goals1'];
					$goals2=$row2['goals2'];
				}
			}
			if(mysql_num_rows($result_user)>=1) mysql_data_seek($result_user,0);
			
			$nieuw=0;
			if(!isset($goals1)){
				$nieuw=1;
				$goals1="??";
				$goals2="??";
			}
			
			if($row['id']==65){
				echo "\r\n".'<td> &nbsp; <div class="scoreboard2">';
				echo '<input type="text" maxlength="4" size="4" id="match'.$row['id'].'-goals2" value="'.$goals2.'" autocomplete="off" ';
				echo "onchange=\"\$('#button".$row['id']."').removeAttr('disabled');\" onfocus=\"if (this.value == '??') {this.value = '';}\" />\r\n";
			} else {
				echo "\r\n".'<td> &nbsp; <div class="scoreboard"><input type="text"  maxlength="2" size="1" id="match'.$row['id'].'-goals1" value="'.$goals1.'" autocomplete="off" ';
				echo "onchange=\"\$('#button".$row['id']."').removeAttr('disabled');\" onfocus=\"if (this.value == '??') {this.value = '';}\" /> - \r\n";
				echo '<input type="text" maxlength="2" size="1" id="match'.$row['id'].'-goals2" value="'.$goals2.'" autocomplete="off" ';
				echo "onchange=\"\$('#button".$row['id']."').removeAttr('disabled');\" onfocus=\"if (this.value == '??') {this.value = '';}\" />\r\n";
			}
			echo '&nbsp; </div></td>'; 
			echo '<td>'.$row['score-winner'].' - '.$row['score-goals'].'</td>';
			echo '<td><button type="button" id="button'.$row['id'].'" onclick="geklikt('.$row['id'].')" ';
			echo 'disabled="disabled"';
			echo '>&nbsp;opslaan&nbsp;</button></td>';
			echo '<td><span id="response'.$row['id'].'"></span></td></tr>';
		}
	}
	if(mysql_num_rows($result_match_asc)>=1) mysql_data_seek($result_match_asc,0);
	if($i==0){ //nooit uitvoer gehad?
		echo "Er zijn geen komende matchen meer. Bedankt om mee te doen met de pronostiek van Home Astrid voor het WK van 2014!<br/>";
	} else {
		echo "</table>\r\n<br/>\r\n"; 
		echo "<button class='toonknop' onclick=\"$('.latervolgend').toggle(700);$('.toonknop').toggle(700);\" value='toon'>Toon matchen binnen meer dan 3 dagen.</button><br/> \r\n";
		echo '<p style="font-size:80%;"><b>Refresh steeds de pagina en controleer de gegevens</b><br/>'."\r\n"; 
		echo 'om zeker te zijn dat de gewenste pronostieken correct op de server staan.</p><br/>'."\r\n";
		echo '<noscript><p style="font-size:80%; font-weight:bold; color:#cc0000;">Om dit te kunnen invullen moet je ';
		echo '<a href="http://enable-javascript.com/" target="_blank">';
		echo 'javascript inschakelen</a> en refreshen!</p></noscript>'."\r\n";
	}
?>

<!--[if lt IE 9]>
<br/><p style="font-size:80%;">Werkt <b>niet op Internet Explorer ouder dan 9</b>. Gebruik graag gratis een <a href="http://getfirefox.com" target="_blank">een betere browser</a></p>
<![endif]-->
<br/>
	</article>
	<article>

<h1>Gespeelde matchen</h1>

<table class="matches nextup">
	<tr class="matches-head">
		<th>Tijd match</th><th>Ploegen</th><th>Uitslag</th><th>Pronostiek</th><th>Score</th>
	</tr>
<?php
	$i=0;
	while($row=mysql_fetch_array($result_match_desc)) {
		if(strtotime($row['deadline']) <= strtotime('now') ){
			$i=$i+1;
			
			$date1 = new DateTime($row['played']);
			
			/*if($i%2==0){
				echo '<tr style="background-color:#ffffc0;">';
			} else {
				echo '<tr>';
			}*/
			echo '<tr><td>'.$date1->format('d/m H:i').'</td>';
			
			if($row['id']!=65){
			
			echo '<td>'.utf8_encode($row['team1']).' - '.utf8_encode($row['team2']).'</td>';
			
			if(isset($row['goals1'])){
				echo '<td>'.$row['goals1'].' - '.$row['goals2'].'</td>';
			} else {
				echo '<td> ?? </td>';
			}
			
			//vind uitslag van mijn pronostiek en evt bijhorende score
			$found=0;
			while($row2=mysql_fetch_array($result_user)){
				if($row2['matchid']==$row['id']){
					$found=1;
					echo '<td>'.$row2['goals1'].' - '.$row2['goals2'].'</td>';
					if(isset($row2['score'])){
						echo '<td> '.$row2['score'].' </td>';
					} else {
						echo '<td> ?? </td>';
					}
				}
			}
			if(mysql_num_rows($result_user)>=1) mysql_data_seek($result_user,0);
			
			} else {
			
			echo '<td>'.utf8_encode($row['team2']).'</td>';
			
			if(isset($row['goals1'])){
				echo '<td>'.$row['goals2'].'</td>';
			} else {
				echo '<td> ?? </td>';
			}
			
			//vind uitslag van mijn pronostiek en evt bijhorende score
			$found=0;
			while($row2=mysql_fetch_array($result_user)){
				if($row2['matchid']==$row['id']){
					$found=1;
					echo '<td>'.$row2['goals2'].'</td>';
					/*if(isset($row2['score'])){
						echo '<td> '.$row2['score'].' </td>';
					} else {
						echo '<td> ?? </td>';
					}*/
					echo "<td>-".abs($row['goals2']-$row2['goals2'])."</td>";
				}
			}
			if(mysql_num_rows($result_user)>=1) mysql_data_seek($result_user,0);
			
			}
			
			if($found==0){
				echo '<td style="color:#ff3333;"> geen </td>';
				echo '<td> 0 </td>';
			}
			echo '</tr>';
		}
	}
	if(mysql_num_rows($result_match_desc)>=1) mysql_data_seek($result_match_desc,0);
?>
</table>
</article>

<?php

include('footer.php');

?>