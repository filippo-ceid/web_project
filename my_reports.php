<?php
	include 'header.html';
	require "new_report.php";
	$tab=2;
	require  "menu.php";
?>   
	
    <div id="top_panel">
		<div class="report_field">
			<div class="myreport_report"><?php echo $report ?></div><br>
            <form action="my_reports.php" method="POST">
				<table>
					<tr>
					  <td>
						 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
						 <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
						 <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
						 <script type="text/javascript" src="new_marker_map.js"></script>
						 <div id="new_marker_map_canvas"></div>
					  </td>
					</tr>
					<tr>
					  <td>
						  <br>Κατηγορία:<br>
						  <select name="category">
							  <option value="default">-Επιλέξτε-</option>
							  <option value="road">Road</option>
							  <option value="sky">Sky</option>
						  </select> <div class="error_category_field">*<?php echo $category_error ?></div>
						  <br>
					  </td>
					</tr>
					<tr>
					  <td>
						  <br>Περιγραφή:<br>
						  <textarea name="description" maxlength="500" cols="76" rows="10"><?php if(isset($description)){echo $description;}?></textarea>
					  </td>
					</tr>
				</table> 
				<br>
				<div class="sub_button">
					<input type="submit" name="submit" value="Submit"/>
				</div>
			</form>
			<div class="reg_image">
			</div>
        </div>
    </div> <!-- end of top panel -->
    
<?php
	include 'footer.html';
?>
