<?php

session_start();
if(!isset($_SESSION['wkid'])){
	header( 'Location: index.php' );
	exit;
}

define('title','Speluitleg - WK pronostiek tornooi - Home Astrid');

include('const.php');
include('header.php');

?>

					<article>
						<h2>Algemeen</h2>
						<p>Dit is een pronostiektornooi voor en door de bewoners van Home Astrid.</p>
						<p>In de eerste plaats betreuren ook wij het samenvallen van het grootste deel van het WK voetbal met de examenperiode aan de universiteit.</p>
						<p>Daarom, <strong>zorg er zeker voor dat je genoeg studeert</strong> en beschouw dit tornooi, en het WK voetbal in het algemeen, als een leuke pauze tussen het studeren door, maar maak er geen prioriteit van. Beter een examen extra slagen en dit tornooi verliezen dan dit tornooi winnen en een herexamen extra ;-).</p>
						<p>Blijf ook sportief, het is iedereen hier om de fun te doen.</p>

						<h2>Pronostieken</h2>
						<p>Op de pagina '<a href="pronostiek.php">Mijn pronostieken</a>' kun je <strong>jouw</strong> pronostieken ingeven, jouw voorspelling van de uitslag van die match.</p>

						<h3>Deadline</h3>
						<p>Om ervoor te zorgen dat info van <strong>net</strong> voor de aftrap geen invloed heeft, is de deadline voor elke pronistiek een half uur <?php echo utf8_encode("vóór");?> de aftrap van de match gelegd.</p>
						<p>Na het verstrijken van de deadline kan de pronostiek niet meer worden aangepast. Ook niet als de pagina nog open staat en de match nog zichtbaar is (de website controleert het tijdstip van insturen). Indien na de deadline niets is ingevuld, krijg je sowieso geen punten voor die match. Het is dus in je eigen belang sowieso iets in te vullen.</p>
						<p><strong>Je kunt je pronostiek wel aanpassen</strong> tot aan de deadline, dus bij twijfel kun je het blijven aanpassen.</p>

						<h3>Tijd Match</h3>
						<p>In deze kolom staat het moment waarop de aftrap van deze match wordt gegeven <strong>in Belgische tijd</strong> (CEST, GMT+2).</p>

						<h3>Ploegen</h3>
						<p>Welke ploegen de match spelen.</p>
						<p>Hierbij is vanaf match 49 (winnaar groep A tegen 2e groep B, op 30 juni om 20u) in het begin van het tornooi niet gekend welke ploegen deze match zullen spelen. Van zodra deze ploegen bekend zijn, zal de beheerder de ploegen van deze matchen aanpassen. Dit is ruimschoots <?php echo utf8_encode("vóór");?> het verstrijken van de deadline, dus je kunt je pronostiek er nog aan aanpassen.</p>
						<p>Mis je door een reis een deel van het tornooi? En heb je zoveel ongeluk dat je zelfs op reis niet op internet kunt? Gok dan op de matchen die je zult missen. Bij het aanpassen van de ploegen wordt je pronostiek bewaard en door iets in te vullen, al was het 0 - 0, kun je enkel punten winnen.</p>

						<h3>Pronostiek</h3>
						<p>Doe een gokje naar de uitslag van de match. Indien je de juiste winnaar kunt voorspellen, of kunt voorspellen dat er gelijkgespeeld wordt, win je punten. Heb je bovendien het aantal doelpunten door elke ploeg juist, dan win je zelfs meer punten!</p>

						<h3>Score</h3>
						<p>De punten die te winnen zijn met deze match, in deze notatie:</p>
						<p><strong>#punten voor juiste winnaar/gelijkspel</strong> - <strong>#aantal punten indien ook uitslag juist is</strong></p>
						<p>Het aantal punten die te winnen vallen per match zijn als volgt:</p>
						<table class="table">
    						<tr>
    						    <th>Soort match</th>
    						    <th>Aantal matchen</th>
    						    <th>Score winnaar</th>
    						    <th>Score uitslag</th>
    						</tr>
    						<tr>
    						    <td>Groepsfase</td>
    						    <td>48</td>
    						    <td>5</td>
    						    <td>10</td>
    						</tr>
    						<tr>
    						    <td>8e finales</td>
    						    <td>8</td>
    						    <td>10</td>
    						    <td>20</td>
    						</tr>
    						<tr>
    						    <td>kwartfinales</td>
    						    <td>4</td>
    						    <td>12</td>
    						    <td>25</td>
    						</tr>
    						<tr>
    						    <td>halve finales</td>
    						    <td>2</td>
    						    <td>20</td>
    						    <td>40</td>
    						</tr>
    						<tr>
    						    <td>kleine finale</td>
    						    <td>1</td>
    						    <td>40</td>
    						    <td>80</td>
    						</tr>
    						<tr>
    						    <td>finale</td>
    						    <td>1</td>
    						    <td>52</td>
    						    <td>100</td>
    						</tr>
    						<tr>
    						    <th>totaal</th>
    						    <td>51</td>
    						    <td>500</td>
    						    <td>1000</td>
    						</tr>
						</table>
						
						<h2>Gespeelde matchen</h2>
						<p>Hier staat een overzicht van de matchen waarvoor reeds een deadline verstreken is, de uitslag van die wedstrijd, jouw pronostiek (of "geen" indien je dit niet tijdig hebt ingevuld) en het aantal punten die je hiervoor hebt gekregen.</p>
						<p>Match al gespeeld maar uitslag nog "???" ? Even geduld, de beheerder zal dit manueel nog invullen.</p>
						<p>Goed voorspeld maar toch 0 punten? Vraag <a href="//facebook.com/ronald.merckx">de beheerder</a> de scores opnieuw te berekenen, ze heeft misschien een knopje te weinig of te veel ingedrukt. Maar de server is erop voorzien alle scores te herberekenen met de ingevulde uitslagen door <?php echo utf8_encode("één");?> druk op de knop, dus veel moeite is dat niet voor de beheerder ;-)</p>

						<h2>Account</h2>
						<p>Op deze pagina kun je je wachtwoord wijzigen.</p>

						<h2>Rangschikking</h2>
						<p>Hier kun je zien wie er al hoeveel punten verzameld heeft en hoe je er zelf voor staat.</p>
						<p>Er zijn twee aparte klassementen: <?php echo utf8_encode("één");?> voor het betalend tornooi, en eentje voor alle spelers.</p>

						<h3>Score berekening</h3>
						<p>De score die weergegeven wordt in de rangschikking, is de som van alle punten die je hebt verzameld op de voorbije matchen.</p>
						<p>Zie ook 'gespeelde matchen' onder '<a href="pronostiek.php">Mijn pronostieken</a>'.</p>
						<p>Match net voorbij en punten nog niet bijgeteld? Even geduld!</p>
						<p>Score foutief berekend denk je? Stuur een berichtje naar <a href="//facebook.com/ronald.merckx">de beheerder</a>!</p>

						<h3>Ex aequo</h3>
						<p>Ex aequos worden opgelost met de schiftingsvraag (het aantal doelpunten over heel het EK; excl penalties na verlengingen, wat ingevuld moet zijn voor de openingsmatch).</p>
						<p>Indien er mensen met gelijke score <?php echo utf8_encode('én');?> gelijk verschil op de schiftingsvraag zitten, wordt diegene die zich
							het eerst registreerde als eerstes gerangschikt (komt hopelijk niet voor, maar er moet <b>iets</b> van volgorde zijn).</p>

						<h3>Winstverdeling</h3>
						<p>De volgende winsten worden <b>minstens</b>* uitgekeerd:</p>
						<p><ul><li>1e plaats: &euro;50</li>
							<li>2e plaats: &euro;0</li>
							<li>3e plaats: &euro;0</li>
						</ul>
						</p><p style="font-size:70%">* prijzenpot stijgt bij meer betalende deelnemers, dan wordt ook een 2e en 3e prijs voorzien</p>
							
						<a id="betalen"><h3>Meedingen naar prijzenpot</h3></a>
						<p>Op de eerste plaats komt het plezier, maar het meedingen naar de prijzenpot geeft hier een extra dimensie aan.</p>
						<p>Je bent dus niet verplicht mee te dingen naar de prijzenpot om de eer te winnen van de beste WK-voorspeller van Home Astrid te worden.</p>
						<p>Om het ook voor iedereen leuk te houden, kun je slechts &euro;5 inleggen, <?php echo utf8_encode('éénmalig');?>. 
						De rest van het geld kun je spenderen aan pintjes.</p>
						<p><strong>Overtuigd om mee te spelen voor de prijzen?</strong> Betalen kan bij <a href="//facebook.com/bart.vanbalkom.33">Bart</a>, kamernr 116. Vermeld hierbij je gebruikersnaam.</p>
						
						<h2>Alheersende en alwetende wedstrijdjury</h2>
						<p>Bij discussie of onduidelijkheid beslist de alheersende en alwetende wedstrijdjury over het correcte Goddelijke oordeel.</p>
						<p>Deze wedstrijdjury bestaat uit Ronald, Bart en Pieter. Bij onenigheid in de Jury, heeft Ronald het laatste woord.</p>
						
						<h2>Verder vragen?</h2>
						<p>Voor verdere onduidelijkheden mag je steeds aankloppen bij Ronald.</p>
					</article>
<?
include('footer.php');

?>