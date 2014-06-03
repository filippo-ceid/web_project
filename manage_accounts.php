<?php
	include 'header.html';
	require "check_permissions.php";
	check_admin_permissions($user_level);
	$tab=3;
	require  "menu.php";
	require "update_accounts.php";
	
?>  
    <div id="top_panel">
		<div class="reg_field">
			<div class="reg_report"><?php echo $report ?></div><br>
            <form action="manage_accounts.php" method="POST">
				<table>
					<tr>
					  <td>Αναζήτηση Χρήστη:</td>
					  <td><input type="text" name="user" value="<?php if (isset($_POST['user'])) echo $_POST['user']; else echo $userData['user'];?>"/></td>
					  <td><input type="submit" name="search" value="Search"/><div class="error_reg_field"><?php echo $user_error ?></div></td>
					</tr>
					<tr>
					  <td>Κωδικός Διαχειριστή:</td>
					  <td><input type="password" name="password" autocomplete="off"/></td>
					  <td><div class="error_reg_field">*<?php echo $pass_error ?></div></td>
					</tr>
					<tr>
					  <td>Διεύθυνση Email:</td>
					  <td><?php if (isset($userData['email'])) echo $userData['email']; ?></td>
					</tr>
					<tr>
					  <td></td>
					  <td><input type="text" name="email" value="<?php if (isset($userData['email'])) echo $userData['email'];?>"/></td>
					  <td><div class="error_reg_field"><?php echo $new_email_error ?></div></td>
					</tr>
					<tr>
					  <td>Επίπεδο:</td>
					  <td>
						  <select name="level">
							  <option value="<?php if (isset($userData['user_level']) && $userData['user_level'] == 'admin') echo 'admin'; else echo 'simple'?>"><?php if (isset($userData['user_level']) && $userData['user_level'] == 'admin') echo 'Διαχειριστής'; else echo 'Απλός Χρήστης'?></option>
							  <option value="<?php if (isset($userData['user_level']) && $userData['user_level'] == 'admin') echo 'simple'; else echo 'admin'?>"><?php if (isset($userData['user_level']) && $userData['user_level'] == 'admin') echo 'Απλός Χρήστης'; else echo 'Διαχειριστής'?></option>
						  </select>
					  </td>
					</tr>
					<tr>
					  <td>Νέος Κωδικός Ασφαλείας:</td>
					  <td><input type="password" name="new_password" autocomplete="off"/></td>
					  <td><div class="error_reg_field"><?php echo $new_pass_error ?></div></td>
					</tr>
					<tr>
					  <td>Επαλήθευση Νέου Κωδικού:</td>
					  <td><input type="password" name="conf_new_password"/></td>
					  <td><div class="error_reg_field"></div></td>
					</tr>
					<tr>
					  <td>Όνομα:</td>
					  <td><?php if (isset($userData['firstname'])) echo $userData['firstname']; ?></td>
					</tr>
					<tr>
					  <td></td>
					  <td><input type="text" name="first_name" value="<?php if (isset($userData['firstname'])) echo $userData['firstname']; ?>"/></td>
					  <td><div class="error_reg_field">(Ελληνικά ή Αγγλικά)<?php echo $new_fname_error ?></div></td>
					</tr>
					<tr>
					  <td>Επώνυμο:</td>
					  <td><?php if (isset($userData['lastname'])) echo $userData['lastname']; ?></td>
					</tr>
					<tr>
					  <td></td>
					  <td><input type="text" name="last_name" value="<?php if (isset($userData['lastname'])) echo $userData['lastname']; ?>"/></td>
					  <td><div class="error_reg_field">(Ελληνικά ή Αγγλικά)<?php echo $new_lname_error ?></div></td>
					</tr>
					<tr>
					  <td>Τηλέφωνο:</td>
					  <td><?php if (isset($userData['phone'])) echo $userData['phone']; ?></td>
					</tr>
					<tr>
					  <td></td>
					  <td><input type="text" name="phone" value="<?php if (isset($userData['phone'])) echo $userData['phone']; ?>"/></td>
					  <td><div class="error_reg_field">(Δεκαψήφιο Ελληνικό Σταθερό ή Κινητό)<?php echo $new_phone_error ?></div></td>
					</tr>
				</table> 
				<br>
				<div class="reg_button">
					<input type="submit" name="update" value="Update"/>
					<input type="submit" name="delete" value="Delete"/>
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
