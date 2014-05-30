<?php
	include 'header.html';
	require "check_permissions.php";
	check_admin_permissions($user_level);
	$tab=2;
	require  "menu.php";
	require "categories_update.php";
?>  
	<link rel="stylesheet" href="colorbox.css"/>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true&language=el"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="reports_map.js"></script>
	<script type="text/javascript" src="jquery.colorbox.js"></script>
	<script>
		function image(){
				$(".photo").colorbox({rel:'photo'});
		}
	</script>
    <div id="top_panel">
		<div class="reg_report"><?php echo $report ?></div><br>
		<div class="report_field">
				<table>
					<tr>
					  <td>
						 <div id="reports_map_canvas"></div>
					  </td>
					   <td>
						 <div id="reports_list">
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
        <div class="category_field">
			<div class="reg_report">Εισαγωγή - Διαγραφή Κατηγορίας</div><br>
			<form action="reports_page.php" method="POST">
			<table>
				<tr>
					<td>Όνομα κατηγορίας: </td>
					<td><input type="text" name="new_category"/></td>
					<td><div class="error_categ_field"><?php echo $new_category_error ?></td>
					<div class="delete_field">
					<td>Επιλογή κατηγορίας:</td>
					<td><select name="category">
						<option value="default"></option>
						<?php echo $categ_selection; ?>
					</select></td>
					<td><div class="error_categ_field"><?php echo $category_error ?></td>
					</div>
				</tr>
				<tr>
					<td>Χρώμα marker:</td>
					<td><select name="pin_color">
						<option value="default"></option>
						<option value="pin_white">Άσπρο</option>
						<option value="pin_yellow">Κίτρινο</option>
						<option value="pin_orange">Πορτοκαλί</option>
						<option value="pin_red">Κόκκινο</option>
						<option value="pin_pink">Ροζ</option>
						<option value="pin_purple">Μωβ</option>
						<option value="pin_lightblue">Γαλάζιο</option>
						<option value="pin_blue">Μπλε</option>
						<option value="pin_green">Πράσινο</option>
						<option value="pin_brown">Καφέ</option>
						<option value="pin_grey">Γκρι</option>
						<option value="pin_black">Μαύρο</option>
					</select></td>
					<td><div class="error_categ_field"><?php echo $pin_color_error ?></td>
					<td></td>
					<td><div class="categ_button">
						<input type="submit" name="delete_categ_submit" value="Delete"/>
					</div></td>
				</tr>
				<tr>
					<td></td>
					<td><div class="categ_button">
						<input type="submit" name="new_categ_submit" value="Submit"/>
					</div></td>
				</tr>
			</table>
			
			</form>
        </div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
