<?php
	include 'header.html';
	require "check_permissions.php";
	check_simple_permissions($user_level);
	$tab=2;
	require  "menu.php";
?>   
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="new_report_map.js"></script>
	<script type="text/javascript" src="my_reports_list.js"></script>
    <div id="top_panel">
		<div class="report_field">
				<table>
					<tr>
					  <td>
						 <div id="new_report_map_canvas"></div>
					  </td>
					   <td>
						 <div id="num_of_reports"></div>
						 <div id="list_reports"></div>
					  </td>
					</tr>
				</table> 
        </div>
    </div> <!-- end of top panel -->
    
<?php
	include 'footer.html';
?>
