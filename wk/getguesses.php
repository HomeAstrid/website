<?php

session_start();
if(!isset($_SESSION['wkid'])){
	header( 'Location: index.php' );
	exit;
}

//invoer van gewenste formaat?

$id=$_GET['id'];
if(!preg_match('/^[0-9]{1,3}$/', $id)){
	header( 'Location: index.php' );
	exit;
}

include_once('db.php');
db::open_connection();

$query = "SELECT `matchid`,`goals1`,`goals2`,`score` FROM `wk_guess` WHERE `userid`='".$id."' AND `score` IS NOT NULL ORDER BY `matchid`;";
//echo $query;
$result = mysql_query($query);
if(mysql_error()){
	header( 'Location: index.php' );
	db::close_connection();
	exit;
}

$query = "SELECT `username` FROM `wk_user` WHERE `id`='".$id."';";
$result2 = mysql_query($query);
if(mysql_error()){
	header( 'Location: index.php' );
	db::close_connection();
	exit;
}
$name=mysql_result($result2,0);


$query ="SELECT `id`,`team1`,`team2`,`played`, `goals1`,`goals2`, `deadline` FROM `wk_match` ORDER BY `id`;";
$result_m = mysql_query($query);
$new_array[] = $row;
while ($row = mysql_fetch_array($result_m)) {
    $new_array[$row['id']] = $row;
}


db::close_connection();

define('title','Scores en pronostieken gebruiker '.$id.' - WK pronostiek tornooi - Home Astrid');
define('pagina','scores');
include('const.php');
include('header.php');

?>

<br/>
Pronostieken gebruiker <b><?php echo $name;?></b>:<br/><br/>

<article>

<?php

echo '<table class="matches nextup">'."\r\n".
		'<tr class="matches-head">';
echo '<th>Ploegen</th><th>tijdstip';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>';
echo '<th>pronostiek</th><th>uitslag</th>';
echo '<th>score</th></tr>'."\r\n";

while($match=mysql_fetch_array($result)) {
	if(strtotime($new_array[$match["matchid"]][6]) < strtotime('now') ){
		echo "<tr>";
		//echo "<td>".utf8_encode(mysql_result($result_m,$match["matchid"]+1,1))
		echo "<td>".utf8_encode($new_array[$match["matchid"]][1])
		//." - ".utf8_encode(mysql_result($result_m,$match["matchid"]+1,2))."&nbsp;</td>";
		." - ".utf8_encode($new_array[$match["matchid"]][2])."&nbsp;</td>";
		//$date2 = new DateTime(mysql_result($result_m,$match["matchid"]+1,3));
		$date2 = new DateTime($new_array[$match["matchid"]][3]);
		echo "<td>".$date2->format('d/m H')."u</td>";
		echo "<td>".$match["goals1"]."-".$match["goals2"]."</td>";
		//echo "<td>".mysql_result($result_m,$match["matchid"]+1,4)."-".
		echo "<td>".$new_array[$match["matchid"]][4]."-".
		$new_array[$match["matchid"]][5]."</td>";
		echo "<td>".$match["score"]."</td>";
		echo "</tr>\r\n";
	}
}
//if(mysql_num_rows($result)>=1) mysql_data_seek($result,0);
echo "</table>";

//echo $result;

?>

</article>

<?php

include('footer.php');


?>