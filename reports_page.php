<?php
	include 'header.html';
	//αποτροπή για χειροκινητη πρόσβαση στη σελίδα
	//αν δεν είσαι admin
	check_admin_permissions($user_id);
	$tab=2;
	require  "menu.php";
	require "categories_update.php";
?>  
	<link rel="stylesheet" href="colorbox.css"/>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true&language=el"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="reports_map.js"></script>
	<script type="text/javascript" src="jquery.colorbox.js"></script>
	<script type="text/javascript" src="reports_list_admin.js"></script>
	<script>
		function image(){
				$(".photo").colorbox({rel:'photo'});
		}
	</script>
    <div id="top_panel">
		<div class="reg_report">Ενημέρωση/Διαγραφή Ανοιχτών Αναφορών</div><br>
		<div class="reg_report"><?php echo $report ?></div><br>
		<div id="reports_field">
				<table class="reports_table">
					<tr>
					  <td id="admin_reports_map">
						  <!-- ετοιμάζεται ο χάρτης στην reports_map.js -->
						 <div id="reports_map_canvas"></div>
					  </td>
					  <td id="reports_list">
						  <!-- reports_list_admin.js -->
						 <div id="num_of_reports_admin"></div>
						 <div id="list_unsolved_reports"></div>
						 <button onclick="prevPage('unsolved')"><<</button> 
						 <button onclick="nextPage('unsolved')">>></button>
						 <br><br>
						 <div id="num_of_solved_reports_admin"></div>
						 <div id="list_solved_reports"></div>
						 <button onclick="prevPage('solved')"><<</button>
						 <button onclick="nextPage('solved')">>></button>
					  </td>
					</tr>
				</table>
        </div>
        <div class="reg_report">Εισαγωγή/Τροποποίηση/Διαγραφή Κατηγοριών</div><br>
        <div id="category_field">
			<form action="reports_page.php" method="POST">
			<table class="reports_table">
				<tr>
					<td>Επιλογή κατηγορίας:</td>
					<td>
						<select name="category">
							<option value="default"></option>
							<?php echo $categ_selection; ?>
						</select>
						<input type="submit" name="edit_categ_submit" value="Edit"/>
						<input type="submit" name="delete_categ_submit" value="Delete"/>
					</td>
					<td>
						<div class="error_reg_field"><?php echo $category_error ?></div>
					</td>
					<td><br><br></td>
				</tr>
				<tr>
					<td>Όνομα κατηγορίας: </td>
					<td><input type="text" name="new_category" value="<?php if (isset($categData['category'])) echo $categData['category'];?>" class="field"/></td>
					<td><div class="error_reg_field"><?php echo $new_category_error ?></td>
					<input type="hidden" name="category_id" value="<?php if (isset($categData['categ_id'])) echo $categData['categ_id'];?>"/>
				</tr>
				<tr>
					<td>Χρώμα marker:</td>
					<td><select name="pin_color">	
						<option value="<?php if (isset($categData['pin_icon'])) echo $categData['pin_icon']; else echo 'default';?>"><?php if (isset($color_name)) echo $color_name; else echo '';?></option>
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
					</select></td>
					<td><div class="error_reg_field"><?php echo $pin_color_error ?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="<?php if (isset($categData['categ_id'])) echo 'update_categ_submit'; else echo 'new_categ_submit'; ?>" class="submit" value="<?php if (isset($categData['categ_id'])) echo 'Update'; else echo 'Submit';?>"/>
					</td>
				</tr>
			</table>
			
			</form>
        </div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
