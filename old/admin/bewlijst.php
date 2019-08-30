<?php

session_start();
include('../const.php');
if(!isset($_SESSION["astridusername"])) header('Location: '.base_url().'/admin/login.php');
define(title,'Admin:: bewonerslijst beheren');
if($_SESSION["astridadmin"]==0){
header('Location: '.base_url());
} else {


include('../header/header1.php');
include('adminmenu.php');
include('../header/header3.php');

/* verwerken geposte gegevens */

if(isset($_POST['reset'])){
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);
	
	$query = "UPDATE `tbl_bewlijst` SET `naam`=NULL, `richting`=NULL WHERE 1;";
	mysql_query($query);
	
	mysql_close($con);
}

if(isset($_POST['bijvoegen'])){
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);
	
	$volledigetekst = $_POST['tekst'];
	$rijen = explode("\r\n",$volledigetekst);
	foreach($rijen as $rij){
		try{
			$arr = explode(",",$rij);
			$query = "UPDATE `tbl_bewlijst` SET `naam`='".mysql_real_escape_string($arr[1])."', `richting`='".
				mysql_real_escape_string($arr[2])."' WHERE `kamernr`='".mysql_real_escape_string($arr[0])."';";
			mysql_query($query);
		} catch (Exception $e){
			//do nothing
		}
	}
	
	mysql_close($con);
}

?>


<h1>Lijst resetten</h1>
<form action="bewlijst.php" method="post">
<input type="submit" value="Resetten" name="reset"/>
</form>
<br/><br/>

<h1>Lijst bijvullen</h1>
<form action="bewlijst.php" method="post">
(formaat: kamernr,naam,richting - meerdere lijnen tegelijk kunnen)<br/><br/>
<textarea name="tekst" cols="70" rows="20"></textarea>
<br/><br/>
<input type="submit" value="Bijvoegen" name="bijvoegen"/>
</form>

<?php

}

include('../footer.php');
?>
