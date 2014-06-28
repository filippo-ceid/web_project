<?php
	include 'header.html';
	$tab=1;
	require  "menu.php";
?>   
	<link rel="stylesheet" href="colorbox.css"/>
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
    	<div id="map_canvas"></div>
    </div> <!-- end of top panel -->
    
    <div id="bottom_panel">
		<div id="section_info">
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
        </div>
        <div class="separator"></div>
        <div id="section_rss">
			<table>
				<tr><div class="section_title">RSS Feed Αναφορών</div></tr>
				<tr>
					<div class="section_text">
						<div id="list_of_reports"></div>
					</div>
				</tr>
				<tr>
					<div class="rss_button"><a href="rss.php" target="_blank"></a></div>
				</tr>
			</table>
        </div>
		<div class="separator"></div>
        <div id="section_stat">
			<table>
				<tr><div class="section_title">Στατιστικά Αναφορών</div></tr>
				<tr>
					<div class="section_text">
					<ul>
						<div id="statistics"></div>
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
