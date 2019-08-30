<?php

session_start();
$_SESSION['wkid']=null;
$_SESSION['wkadmin']=null;
header( 'Location: index.php' );

?>