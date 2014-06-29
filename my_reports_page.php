<?php
	include 'header.html';
	check_simple_permissions($user_id);
	$tab=2;
	require  "menu.php";
?>  
	<link rel="stylesheet" href="colorbox.css"/>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true&language=el"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="new_report_map.js"></script>
	<script type="text/javascript" src="my_reports_list.js"></script>
	<script type="text/javascript" src="jquery.colorbox.js"></script>
	<script>
		function image(){
				$(".photo").colorbox({rel:'photo'});
		}
	</script>
    <div id="top_panel">
		<div id="my_reports_field">
				<table>
					<tr>
					  <!-- η new_report_map.js είναι υπεύθυνη για τη δημιουργία του χάρτη σε αυτή τη σελίδα -->
					  <td id="report_map"><div id="new_report_map_canvas"></div></td>
					   <td id="report_list">
						   <!-- η my_reports_list.js ετοιμάζει τον αριθμό των αναφορών καθώς και τη λίστα -->
						 <div id="num_of_reports"></div>
						 <div id="my_reports_list"></div>
					  </td>
					</tr>
				</table> 
        </div>
    </div> <!-- end of top panel -->
    
<?php
	include 'footer.html';
?>
