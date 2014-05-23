<?php
	
	include 'header.html';
	require "new_report.php";
	$tab=2;
	require  "menu.php";
?>   
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
	<script type="text/javascript" src="new_marker_map.js"></script>
    <div id="top_panel">
		<div class="report_field">
			<div class="myreport_report"><?php echo $report ?></div><br>
            <form action="my_reports.php" method="POST">
				<table>
					<tr>
					  <td>
						 <div id="new_marker_map_canvas"></div>
					  </td>
					</tr>
					<tr>
					  <td>
						  <br>Κατηγορία:<div class="error_rep_field"> *<?php echo $category_error ?></div><br>
						  <select name="category">
							  <option value="default">-Επιλέξτε-</option>
							  <option value="road">Road</option>
							  <option value="sky">Sky</option>
						  </select>
						  <br>
					  </td>
					</tr>
					<tr>
					  <td>
						  <br>Περιγραφή:<div class="error_rep_field"> *<?php echo $description_error ?></div><br>
						  <textarea name="description" maxlength="500" cols="76" rows="10"><?php if(isset($_POST['description'])&&($_POST['category']=="default")){echo $_POST['description'];}?></textarea>
					  </td>
					</tr>
				</table> 
				<br>
				<div class="sub_button">
					<input type="submit" name="submit" value="Submit"/>
				</div>
			</form>
        </div>
        <div class="old_reports">
			<ul>
				<li>Page 1</li>
				<li>Page 2</li>
				<li>Page 3</li>
				<li>Page 4</li>
				<li>Page 5</li>
				<li>Page 6</li>
			</ul>
		</div>
    </div> <!-- end of top panel -->
    
<?php
	include 'footer.html';
?>
