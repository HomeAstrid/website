<?php session_start();?>
<!DOCTYPE html>
<?php if ( ! defined('title')) exit('Hélaba! Snodaard, door mijn code willen snuisteren ja? Hihi, lukt niet!'); ?>
<?php if ( ! defined('const')) include 'const.php';?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<link href="style.css" rel="stylesheet" type="text/css" id="stylesheet"/>
		<title><?php echo title;?></title>
		<?php if(defined('script')) echo script; ?>
	</head>
	<body<?php if(defined('bodyclass')) echo ' class="'.bodyclass.'"';?>>
		<div id="wrapper">
			
			<header>
				<div class="inner-header">
					<a id="logo" href="http://astrid.ugent.be" title="Terug naar de Home Astrid-site"></a>
					<h1>Home Astrid WK Pronostiek</h1>
				

			<?php
			if(isset($_SESSION['wkid'])){
				echo '<nav class="menu">';
				echo '<ul>';
				echo '<li><a href="pronostiek.php"'; if(defined('pagina') && pagina==="pronostiek") echo ' class="current"'; 
					echo ' target="_self" >Mijn pronostieken</a></li>'."\r\n";
				echo '<li><a href="rangschikking.php"'; if(defined('pagina') && pagina==="rangschikking") echo ' class="current"'; 
					echo ' target="_self" >Rangschikking</a></li>'."\r\n";
				echo '<li><a href="uitleg.php"'; if(defined('pagina') && pagina==="uitleg") echo ' class="current"'; 
					echo ' target="_self" >Speluitleg</a></li>'."\r\n";
				echo '<li><a href="account.php"'; if(defined('pagina') && pagina==="account") echo ' class="current"'; 
					echo ' target="_self" >Account</a></li>'."\r\n";
				if(isset($_SESSION['wkadmin'])){
					echo '<li><a href="admin.php" target="_self" >admin</a></li>'."\r\n";
				}
				echo '<li class="signout"><a href="logout.php" target="_self">uitloggen</a></li>'."\r\n";
				echo '</ul></nav>';
			} else {
				//echo '<li><a href="index.php" target="_self" >Home / inloggen</a></li>'."\r\n"; //nieks 
			}
			?>
				</div>
				</header>

	<div class="content-wrapper">
				<section class="content">