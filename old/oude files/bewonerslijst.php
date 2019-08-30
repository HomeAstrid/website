<?php

define('title','Home Astrid:: de bewonerslijst, versie 2011-2012');
include('const.php');
include('header.php');

echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>';
?>

<h1>De bewonerslijst van Astrid</h1>
<?php /*echo '<table><tr><td><div id="kader">';*/ ?>
<div id="kader">
		
<?php
$vorige=0;

$result = bewlijst_select();
		
while( $row = mysql_fetch_array($result) )
{
	if(floor($row['kamernr']/100)-floor($vorige/100)==1){
		if(floor($row['kamernr']/100)!=1){
			echo '</table><br />';
		}
		echo '<font color="#0000AA"><u><b><div class="header_verdiep_';
		echo floor($row['kamernr']/100);
		echo '">Verdiep ';
		echo floor($row['kamernr']/100);
		echo '</div></b></u></font>';
		echo '<table border=1 cellspacing=0 class="element_';
		echo floor($row['kamernr']/100);
		echo '"><tr><td width="80px"><strong>Kamernr</strong></td>';
		echo '<td width="100px"><strong>Telefoonnr</strong></td>';
		echo '<td width="180px"><strong>Naam</strong></td>';
		echo '<td width="320px"><strong>Richting</strong></td></tr>';
	}
	$vorige=$row['kamernr'];
	echo '<tr><td width="80px">';
	echo $row['kamernr'];
	echo '</td><td width="100px">';
	echo $row['telnr'];
	echo '</td><td width="180px">';
	if(!is_null($row['naam'])){
		echo $row['naam'];
	}
	else{
		echo '&nbsp; ';
	}
	echo '</td><td width="320px">';
	if(!is_null($row['richting'])){
		echo $row['richting'];
	}
	else {
		echo '&nbsp; ';
	}
	echo '</td></tr>';
	echo "\n";
}
?>

</table></div><br />
<p align="center">Voor verbeteren, schrappen of toevoegen van gegevens:
<a href="mailto://pieterreuse@gmail.com">stuur een mailtje</a> naar onze ict.

<script>
 $('.header_verdiep_1').click(function () { 
			 $('.element_1').toggle();		
});
	
$('.header_verdiep_2').click(function () { 
			 $('.element_2').toggle();		
 });
	
$('.header_verdiep_3').click(function () { 
			 $('.element_3').toggle();		
});

$('.header_verdiep_4').click(function () { 
			 $('.element_4').toggle();		
});

$('.header_verdiep_5').click(function () { 
			 $('.element_5').toggle();		
});

$('.header_verdiep_5').hover(function () { 
			 $(this).css('cursor','pointer');		
});
$('.header_verdiep_4').hover(function () { 
			 $(this).css('cursor','pointer');		
});
$('.header_verdiep_3').hover(function () { 
			 $(this).css('cursor','pointer');		
});
$('.header_verdiep_2').hover(function () { 
			 $(this).css('cursor','pointer');		
});
$('.header_verdiep_1').hover(function () { 
			 $(this).css('cursor','pointer');		
});

 $(document).ready(function () {
  $('.element_1').hide();
  $('.element_2').hide();
  $('.element_3').hide();
  $('.element_4').hide();
  $('.element_5').hide();
});
</script>

	
<?php

include('footer.php');
?>
