<?php
    include 'header.html';
    if (isset($_SESSION ['user_id'])){
		header('Location: index.php');
		exit();
	}
    require "new_reg_user.php";
    $tab=3;
	require  "menu.php";
?>
    <div id="top_panel">
		<div class="reg_field">
			<div class="reg_report"><?php echo $report ?></div><br>
            <form action="registration.php" method="POST">
				<table>
					<tr>
					  <td>Διεύθυνση Email:</td>
					  <td><input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>"/></td>
					  <td><div class="error_reg_field">*<?php echo $email_error ?></div></td>
					</tr>
					<tr>
					  <td>Κωδικός Ασφαλείας:</td>
					  <td><input type="password" name="password" value="<?php if (!isset($_POST['password'])) echo ""; ?>" autocomplete="off"/></td>
					  <td><div class="error_reg_field">*<?php echo $pass_error ?></div></td>
					</tr>
					<tr>
					  <td>Επαλήθευση Κωδικού:</td>
					  <td><input type="password" name="conf_password"/></td>
					  <td><div class="error_reg_field">*</div></td>
					</tr>
					<tr>
					  <td>Όνομα:</td>
					  <td><input type="text" name="first_name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>"/></td>
					  <td><div class="error_reg_field">(Ελληνικά ή Αγγλικά)<?php echo $fname_error ?></div></td>
					</tr>
					<tr>
					  <td>Επώνυμο:</td>
					  <td><input type="text" name="last_name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>"/></td>
					  <td><div class="error_reg_field">(Ελληνικά ή Αγγλικά)<?php echo $lname_error ?></div></td>
					</tr>
					<tr>
					  <td>Τηλέφωνο:</td>
					  <td><input type="text" name="phone" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>"/></td>
					  <td><div class="error_reg_field">(Δεκαψήφιο Ελληνικό Σταθερό ή Κινητό)<?php echo $phone_error ?></div></td>
					</tr>
				</table> 
				<br>
				<div class="reg_button">
					<input type="submit" name="submit" value="Register"/>
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
