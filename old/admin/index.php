<?php

session_start();

include('../const.php');

if(!isset($_SESSION["astridusername"])) header('Location: '.base_url().'/admin/login.php');

define(title,'Admin:: home');

if($_SESSION["astridadmin"]==0){

include('../header/header.php');

echo 'U heeft geen adminrechten, get the fuck out. <br />';

} else {

include('../header/header1.php');
include('adminmenu.php');
include('../header/header3.php');
?>

Welkom, admin! Zoals u ziet, werkt alle inlogfunctionaliteit van het admingedeelte reeds, maar moet de rest nog gemaakt worden (toevoegen, aanpassen en inactief zetten van zowel nieuwsitems als gebruikers).

<?php

}

include('../footer.php');
?>


