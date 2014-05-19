<?php
	// Start output buffering:
	ob_start();
	// Initialize a session:
	session_start();
	
	include 'header.html';
	$tab=1;
	require  "menu.php";
?>   
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
	<script type="text/javascript" src="map.js"></script>
	
    <div id="top_panel">
    	<div id="map_canvas"></div>
    	<br><br>
    </div> <!-- end of top panel -->
    
    <div id="bottom_panel">
		<div class="section">
			<table>
				<tr><div class="section_title">Ανακοινώσεις</div></tr>
				<tr>
					<div class="section_text">
					<tr>
						<div class="news_title">Διαδραστικός Χάρτης</div>
						<p>Στο χάρτη εμφανίζονται οι τελευταίες 20 αναφορές που έχουν καταχωρηθεί στο σύστημα απο τους εγγεγραμμένους χρήστες.</p>
					</tr>
					<tr>
						<div class="news_title">Δημιουργία Λογαριασμού</div>
						<p>Δημιουργήστε λογαριασμό και βοηθήστε στην ενημέρωση του συστήματος.</p>
					</tr>
					</div>
				</tr>
				<tr><div class="section_button"><a href="#">Περισσότερες</a></div></tr>
			</table>
        </div>
		<div class="separator"></div>
		<div class="section">
			<table>
				<tr><div class="section_title">Λίστα Αναφορών</div></tr>
				<tr>
					<div class="section_text">
					<ul>
						<li><a href="#">Lampa</a></li>
						<li><a href="#">Dromos</a></li>  
						<li><a href="#">Dromos</a></li>                   
					</ul>
					</div>
				</tr>
				<tr><div class="section_button"><a href="#">Περισσότερες</a></div></tr>
			</table>
        </div>
        <div class="separator"></div>
        <div class="section">
			<table>
				<tr><div class="section_title">Στατιστικά</div></tr>
				<tr>
					<div class="section_text">
					<ul>
						<li>Συνολικός αριθμός αναφορών:</li>
						<li>Συνολικός αριθμός ανοικτών αναφορών:</li>
						<li>Συνολικός αριθμός επιλυμένων αναφορών:</li>
						<li>Μέσος χρόνος επίλυσης αναφορών:</li>
					</ul>
					</div>
				</tr>
			</table>
        </div>
        <div class="cleaner_h20">&nbsp;</div> 
    </div> <!-- end of bottom panel -->
<?php
	include 'footer.html';
?>
