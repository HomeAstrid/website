<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<html>
<head>
<title>Upload kakkerlakske</title>
</head>

<body>
<div style="padding: 20px; border: 1px solid #999">


<h2>Upload PDF File :</h2>
<form enctype="multipart/form-data"
	action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<p><input type="hidden" name="MAX_FILE_SIZE" value="200000" /> <input
	type="file" name="pdfFile" /><br />
<br />
<input type="submit" value="upload!" /></p>
</form>

</div>
</body>
</html>

<?php
if ( isset( $_FILES['pdfFile'] ) ) {
	if ($_FILES['pdfFile']['type'] == "application/pdf") {
		$source_file = $_FILES['pdfFile']['tmp_name'];
		$dest_file = "uploads/".$_FILES['pdfFile']['name'];

		if (file_exists($dest_file)) {
			echo "The file name already exists!!";
		}
		else {
			move_uploaded_file( $source_file, $dest_file )
			or die ("Error!!");
			if($_FILES['pdfFile']['error'] == 0) {
				echo "Pdf file uploaded successfully!";
				echo "<b><u>Details : </u></b><br/>";
				echo "File Name : ".$_FILES['pdfFile']['name']."<br.>"."<br/>";
				echo "File Size : ".$_FILES['pdfFile']['size']." bytes"."<br/>";
				echo "File location : upload/".$_FILES['pdfFile']['name']."<br/>";
			}
		}
	}
	else {
		if ( $_FILES['pdfFile']['type'] != "application/pdf") {
			echo "Error occured while uploading file : ".$_FILES['pdfFile']['name']."<br/>";
			echo "Invalid  file extension, should be pdf !!"."<br/>";
			echo "Error Code : ".$_FILES['pdfFile']['error']."<br/>";
		}
	}
}
?>