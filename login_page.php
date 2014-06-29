<?php

//με αυτό το αρχείο εμφανίζουμε τη φόρμα συμπλήρωσης των στοιχείων για την είσοδο του χρήστη
//στο σύστημα

	include 'header.html';
	if (isset($_SESSION ['user_id'])){
		header('Location: index.php');
		exit();
	}
    require "login_check.php";
    $tab=2;
	require  "menu.php";
?>   
    <div id="top_panel">
		<div id="login_field">
			<table><td>
			<form action="login_page.php" method="POST">
				<table><td>
					<tr><td>Διεύθυνση Email:</td></tr>
					<tr>
						<td><input type="text" name="email" class="field" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>"/></td>
						<td><div class="error_login_field"><?php echo $email_error_msg ?></div></td>
					</tr>
					<tr><td>Κωδικός Ασφαλείας:</td></tr>
					<tr>
						<td><input type="password" name="password" class="field"/></td>
						<td><div class="error_login_field"><?php echo $pass_error_msg ?></div></td>
					</tr>
					<tr><td><input type="submit" name="submit" class="submit" value="Login" /></td></tr>
				</td></table>
			</form>
			</td><td id="login_image">
				<img src="images/login_icon.png"/></img>
			</td></table>
		</div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
