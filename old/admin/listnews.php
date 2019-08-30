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


//pagina
$page = $_GET['page'];
if(is_null($_GET['page']))
	$page=0;

//per pagina
$perpage = 10;
	
//connectie db
	$con = mysql_connect("localhost","astrid","@sTr1d");
	if (!$con)	die('Gelieve de ICT-verantwoordelijke te contacteren, fout: ' . mysql_error());
	mysql_select_db("astrid",$con);

//bovengrens
	$result = mysql_query("SELECT COUNT(*) FROM `tbl_news`")  or die("fout: " . mysql_error());;
	$boven = mysql_result($result,0);
	$max = round($boven/$perpage-0.5);

//paginatie-links:
echo 'Pagina ';

//eerste
if($page > 2) echo '<a href="'.base_url().'/admin/listnews.php/?page=0">&lt;&lt; 
Eerste</a> ';

//n-2
if($page > 1) echo '<a href="'.base_url().'/admin/listnews.php/?page='.($page-2).'">'.($page-1).'</a> ';

//n-1
if($page > 0) echo '<a href="'.base_url().'/admin/listnews.php/?page='.($page-1).'">'.$page.'</a> ';

//pagina zelf
echo '<b>'.($page+1).'</b>';

//n+1
if($page < $max) echo ' <a href="'.base_url().'/admin/listnews.php/?page='.($page+1).'">'.($page+2).'</a>';

//n+2
if($page < $max-1) echo ' <a href="'.base_url().'/admin/listnews.php/?page='.($page+2).'">'.($page+3).'</a>';

//laatste
if($page < $max-2) echo ' <a href="'.base_url().'/admin/listnews.php/?page='.$max.'">&gt;&gt; Laatste</a>';


echo '<br /><br /><br />';

//nieuwsitems ophalen
	$result = mysql_query("SELECT * FROM `tbl_news` ORDER BY id DESC LIMIT ".$perpage." OFFSET ".$page*$perpage) or die("fout: " . mysql_error());

//nieuwsitems weergeven
while( $row = mysql_fetch_array($result) ){
    echo '<div class="h1">';
    echo '<a href="'.base_url().'/admin/editnews.php?id='.$row["id"].'"><img src="http://www.archon.org/edit.png" /></a> ';
    echo $row['title'].' ';
	if($row['visible']==1) echo '<img src="http://www.lovento.com/media/images/icons/crystal/16/success.png" />';
	else echo '<img src="http://www.seoworld.com/images/b_drop.png" />';
    echo '</div><div class="newsbody">';
	echo '<font size="2" color="#666666">gepost op ';
	echo $row['postdate'];
	echo ' door ';
	$naam = mysql_query('SELECT username FROM users WHERE id='.$row['posterid'].' LIMIT 1') or die ("fout!");
	echo mysql_result($naam,0);
	echo '</font><br />';
	if(!is_null($row['img'])){
		echo '<table><tr><td><div id="foto" style="width:160px;height:160px;display:table-cell;vertical-align:middle">';
		echo '<p align="center"><a href="'.base_url().'/images/activiteiten/groot/';
		echo $row['img'];
		echo '"><img src="'.base_url().'/images/activiteiten/klein/';
		echo $row['img'];
		echo '"/></a></p></div></td><td>';
	}
    if(!is_null($row['date'])){
		echo '<strong>Wanneer?</strong>&nbsp;';
		echo $row['date'];
		echo '<br />van ';
		echo $row['start'];
		echo ' tot ';
		echo $row['end'];
		echo '<br />';
	}
	echo '<br />';
    echo $row['description'];
	if(!is_null($row['img'])){
		echo '<td></tr></table>';
	}
    if(!is_null($row['fb'])){
		echo '<strong>&nbsp;->&nbsp;<a href="';
		echo $row['fb'];
		echo '">Meer info</strong>';
		echo '</a>';
	}
    echo '</div>';
	echo "\n";
}
mysql_close($con);

//paginatie-links:
echo '<br />Pagina ';

//eerste
if($page > 2) echo '<a href="'.base_url().'/admin/listnews.php/?page=0">&lt;&lt; 
Eerste</a> ';

//n-2
if($page > 1) echo '<a href="'.base_url().'/admin/listnews.php/?page='.($page-2).'">'.($page-1).'</a> ';

//n-1
if($page > 0) echo '<a href="'.base_url().'/admin/listnews.php/?page='.($page-1).'">'.$page.'</a> ';

//pagina zelf
echo '<b>'.($page+1).'</b>';

//n+1
if($page < $max) echo ' <a href="'.base_url().'/admin/listnews.php/?page='.($page+1).'">'.($page+2).'</a>';

//n+2
if($page < $max-1) echo ' <a href="'.base_url().'/admin/listnews.php/?page='.($page+2).'">'.($page+3).'</a>';

//laatste
if($page < $max-2) echo ' <a href="'.base_url().'/admin/listnews.php/?page='.$max.'">&gt;&gt; Laatste</a>';

}

include('../footer.php');
?>


