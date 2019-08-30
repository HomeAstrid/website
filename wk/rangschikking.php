<?php

session_start();
if(!isset($_SESSION['wkid'])){
	header( 'Location: index.php' );
	exit;
}

define('title','Rangschikking - WK pronostiek tornooi - Home Astrid');
define('pagina','rangschikking');

include('const.php');
include('header.php');

include_once('db.php');
db::open_connection();


$query = "SELECT `id`,`username`,`score` FROM `wk_user` WHERE `wk_user`.`betaald`='1' ORDER BY `score` DESC, `schifting` asc, `id` asc;";
$result_user_descA = mysql_query($query);


$query = "SELECT `id`,`username`,`score` FROM `wk_user` ORDER BY `score` DESC, `schifting` asc, `id` asc;";
$result_user_descB = mysql_query($query);

db::close_connection();

?>

<article>
	<h1>Rangschikking voor prijzenpot</h1>
	<table class="ranking payed">

<?php

	$i=0;
	$betaald=0;
	while($user=mysql_fetch_array($result_user_descA)) {
		$i=$i+1;
		if($user['id']==$_SESSION['wkid']){
			echo '<tr class="me">';
			$betaald=1;
		} else {
			/*if($i%2==0) echo '<tr>';
			else echo '<tr style="background-color:#ffffcc;">';*/
			echo '<tr>';
		}
		echo '<td>';
		if($i>3) echo $i;
		echo '</td><td>';
		if($user['id']==$_SESSION['wkid']) echo '<b>';
		echo '<a class="zwart" href="getguesses.php?id='.$user['id'].'">';
		echo $user['username'];
		echo "</a>";
		if($user['id']==$_SESSION['wkid']) echo '</b>';
		echo '</td><td>'.$user['score'].'</td></tr>';
	}
	if(mysql_num_rows($result_user_descA)>=1){
		mysql_data_seek($result_user_descA,0);
	}
?>
</table>
<br/> 
<?php if($betaald==0){
	?>
	<p style="font-size:70%;">Wil je meedoen voor de prijzenpot? Meer info <a href="uitleg.php#betalen">hier.</a></p>
	<?php
}
?>
<br/><br/>

	<h1>Rangschikking iedereen</h1>
	<table class="ranking all">

<?php
	//exit;
	$i=0;
	while($user=mysql_fetch_array($result_user_descB)) {
		$i=$i+1;
		if($user['id']==$_SESSION['wkid']){
			echo '<tr class="me">';
		} else {
			/*if($i%2==0) echo '<tr>';
			else echo '<tr style="background-color:#ffffcc;">';*/
			echo '<tr>';
		}
		echo '<td>';
		if($i>3) echo $i;
		echo '</td><td>';
		if($user['id']==$_SESSION['wkid']) echo '<b>';
		echo '<a class="zwart" href="getguesses.php?id='.$user['id'].'">';
		echo $user['username'];
		echo "<a/>";
		if($user['id']==$_SESSION['wkid']) echo '</b>';
		echo '</td><td>'.$user['score'].'</td></tr>';
	}
	if(mysql_num_rows($result_user_descB)>=1) mysql_data_seek($result_user_descB,0);
?>
</table>
<br/> <br/>

<p style="font-size:80%;"><b>Foutje? Vraag <a href="//facebook.com/ronald.merckx">Ronald</a></b> de scores opnieuw te berekenen.<br/>
Is maar <?php echo utf8_encode("één");?> klik moeite dus geen probleem.</p>
<br/><br/>

</article>


<?php

include('footer.php');

?>