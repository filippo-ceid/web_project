<?php

	// η βασικη αρχική μας σελίδα , το ταβ χρησιμοποιείται για να δειξουμε σε ποιο μενού βρισκόμαστε ώστε 
	//να είναι επιλεγμένο

	include 'header.html';
	
	//αρα το μενου καλείται με την αρχική σελιδα να ειναι επιλεγμένη
	$tab=1;
	require  "menu.php";
?>   
	<link rel="stylesheet" href="colorbox.css"/>
	
	<!-- obtain Google Map API key from Google API console -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true&language=el"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="map.js"></script>
	<script type="text/javascript" src="statistics.js"></script>
	<script type="text/javascript" src="jquery.colorbox.js"></script>
	<script>
		function image(){
				$(".photo").colorbox({rel:'photo'});
		}
	</script>
    <div id="top_panel">
		<!-- google map -->
    	<div id="map_canvas"></div>
    </div> <!-- end of top panel -->
    
    <!-- bottom panels with ajax etc -->
    <div id="bottom_panel">
		<table>
		<td id="section_info">
			<table>
				<tr><div class="section_title">Πληροφορίες</div></tr>
				<tr>
					<div class="section_text">
					<tr>
						<div class="info_title">Διαδραστικός Χάρτης</div>
						<p>Στο χάρτη εμφανίζονται οι τελευταίες 20 αναφορές που έχουν καταχωρηθεί στο σύστημα απο τους εγγεγραμμένους χρήστες.</p>
					</tr>
					<tr>
						<br>
						<div class="info_title">Δημιουργία Λογαριασμού</div>
						<p>Δημιουργήστε λογαριασμό και βοηθήστε στον έγκαιρο εντοπισμό προβλημάτων στην πόλη μας.</p>
					</tr>
					</div>
				</tr>
			</table>
        </td>
        <td id="separator_image_1"></td>
        <td id="section_rss">
			<table>
				<tr><div class="section_title">RSS Feed Αναφορών</div></tr>
				<tr>
					<div class="section_text">
						<!-- απο το αρχείο map.js ετοιμάζεται η λιστα με javascript -->
						<div id="list_of_reports"></div>
					</div>
				</tr>
				<tr>
					<div class="rss_button"><a href="rss.php" target="_blank"></a></div>
				</tr>
			</table>
        </td>
        <td id="separator_image_2"></td>
		<td id="section_stat">
			<table>
				<tr><div class="section_title">Στατιστικά Αναφορών</div></tr>
				<tr>
					<div class="section_text">
					<ul>
						<!-- στο αρχειο statistics.php kai statidtics.js ετοιμάζουμε τα στατιστικα -->
						<div id="statistics"></div>
					</ul>
					</div>
				</tr>
			</table>
        </td>
        </table>
    </div> <!-- end of bottom panel -->
<?php
	include 'footer.html';
?>
