<?php

session_start();
include('../const.php');
if(!isset($_SESSION["astridusername"])) header('Location: '.base_url().'/admin/login.php');
define(title,'Admin:: home');
if($_SESSION["astridadmin"]==0){
header('Location: '.base_url());
} else {


include('../header/header1.php');
include('adminmenu.php');
include('../header/header3.php');

/* verwerken geuploade file */
if(isset($_FILES['file1']['name'])){
	
	$target_path1 = "/home/astrid/www/images/activiteiten/groot/";
	$target_path2 = "/home/astrid/www/images/activiteiten/klein/";

	$target_path1 = $target_path1 . $_POST['filename']; 
	$target_path2 = $target_path2 . $_POST['filename']; 
	//$target_path2 = $target_path . basename( $_FILES['file2']['name']); 

	echo $_FILES['file2']['tmp_name'];
	
	if(move_uploaded_file($_FILES['file1']['tmp_name'], $target_path1)
			& move_uploaded_file($_FILES['file2']['tmp_name'], $target_path2)) {
		echo "de bestanden groot/". $_POST['filename']. " en klein/" . $_POST['filename']. 
		" zijn geupload";
	} else{
		//echo "There was an error uploading the file, please try again!";
		?>
		Er was een fout. Probeer aub opnieuw!
		<form enctype="multipart/form-data" action="addfile.php" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
		Naam (AJ/activiteitnaam.jpg): <input name="filename" type="text" /><br />
		Grote afbeelding: <input name="file1" type="file" /><br />
		Kleine afbeelding (160x160px max): <input name="file2" type="file" /><br />
		<input type="submit" value="Upload File" />
		</form>
		<?
	}
	
} else {

?>

<form enctype="multipart/form-data" action="addfile.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
Naam (AJ/activiteitnaam.jpg): <input name="filename" type="text" /><br />
Grote afbeelding: <input name="file1" type="file" /><br />
Kleine afbeelding (160x160px max): <input name="file2" type="file" /><br />
<input type="submit" value="Upload File" />
</form>


<?
}
}

include('../footer.php');
?>