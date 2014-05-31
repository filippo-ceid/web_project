<?php
	// Start output buffering:
	ob_start();
	// Initialize a session:
	session_start();
	include 'header.html';
	//require "new_report.php";
	$tab=2;
	require  "menu.php";
?>   
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="new_report_map.js"></script>
    <div id="top_panel">
		<div class="report_field">
				<table>
					<tr>
					  <td>
						 <div id="new_report_map_canvas"></div>
					  </td>
					   <td>
						 <div id="old_reports">
							<ul>
								<li>Page 1</li>
								<li>Page 2</li>
								<li>Page 3</li>
								<li>Page 4</li>
								<li>Page 5</li>
								<li>Page 6</li>
							</ul>
						</div>
					  </td>
					</tr>
				</table> 
        </div>
    </div> <!-- end of top panel -->
    
<?php
	include 'footer.html';
?>
