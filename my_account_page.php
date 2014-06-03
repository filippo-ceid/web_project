<?php
	include 'header.html';
	require "check_permissions.php";
	check_permissions($user_level);
	$tab=3;
	require  "menu.php";
	require "my_account_update.php";
?>   
    <div id="top_panel">
		<div class="reg_field">
			<div class="reg_report"><?php echo $report ?></div><br>
            <form action="my_account_page.php" method="POST">
				<table>
					<tr>
					  <td>Διεύθυνση Email:</td>
					  <td><?php if (isset($_SESSION ['email'])) echo $_SESSION ['email']; ?></td>
					</tr>
					<tr>
					  <td></td>
					  <td><input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; else echo $_SESSION ['email'];?>"/></td>
					  <td><div class="error_reg_field"><?php echo $new_email_error ?></div></td>
					</tr>
					<tr>
					  <td>Κωδικός Ασφαλείας:</td>
					  <td><input type="password" name="password" autocomplete="off"/></td>
					  <td><div class="error_reg_field">*<?php echo $pass_error ?></div></td>
					</tr>
					<tr>
					  <td>Νέος Κωδικός Ασφαλείας:</td>
					  <td><input type="password" name="new_password"/></td>
					  <td><div class="error_reg_field"><?php echo $new_pass_error ?></div></td>
					</tr>
					<tr>
					  <td>Επαλήθευση Νέου Κωδικού:</td>
					  <td><input type="password" name="conf_new_password"/></td>
					  <td><div class="error_reg_field"></div></td>
					</tr>
					<tr>
					  <td>Όνομα:</td>
					  <td><?php if (isset($_SESSION ['firstname'])) echo $_SESSION ['firstname']; ?></td>
					</tr>
					<tr>
					  <td></td>
					  <td><input type="text" name="first_name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; else echo $_SESSION ['firstname']; ?>"/></td>
					  <td><div class="error_reg_field">(Ελληνικά ή Αγγλικά)<?php echo $new_fname_error ?></div></td>
					</tr>
					<tr>
					  <td>Επώνυμο:</td>
					  <td><?php if (isset($_SESSION ['lastname'])) echo $_SESSION ['lastname']; ?></td>
					</tr>
					<tr>
					  <td></td>
					  <td><input type="text" name="last_name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; else echo $_SESSION ['lastname']; ?>"/></td>
					  <td><div class="error_reg_field">(Ελληνικά ή Αγγλικά)<?php echo $new_lname_error ?></div></td>
					</tr>
					<tr>
					  <td>Τηλέφωνο:</td>
					  <td><?php if (isset($_SESSION ['phone'])) echo $_SESSION ['phone']; ?></td>
					</tr>
					<tr>
					  <td></td>
					  <td><input type="text" name="phone" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; else echo $_SESSION ['phone']; ?>"/></td>
					  <td><div class="error_reg_field">(Δεκαψήφιο Ελληνικό Σταθερό ή Κινητό)<?php echo $new_phone_error ?></div></td>
					</tr>
				</table> 
				<br>
				<div class="reg_button">
					<input type="submit" name="update" value="Update"/>
				</div>
			</form>
			<div class="reg_image">
            		<img src="images/register_icon.png"/></img>
			</div>
        </div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
