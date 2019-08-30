<?php

session_start();

define('title','Admin:: logout');

include('../const.php');
include('../header/header1.php');

?>

            <div id="header">
                    <div class="menu">
                    <ul>
                    <li><a href="<?php echo base_url();?>" target="_self" >Home</a></li>
                    <li><a href="<?php echo base_url();?>/admin/login" target="_self" >Login</a></li>
                    </ul>
                    </div>

            </div>

<?php
include('../header/header3.php');

if(!isset($_SESSION["astridusername"])){

	echo iconv("utf-8","ISO-8859-1",'U bent niet ingelogd. Dan kan u ook niet uitloggen hé klojo.');

} else {
	session_destroy();
	echo 'U bent uitgelogd. U kunt nu terug <a href="'.base_url().'/admin/login.php">inloggen</a>';

}

include('../footer.php');
?>
