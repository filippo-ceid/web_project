<?php
	include 'header.html';
    require "checklogin.php";
    $tab=2;
	require  "menu.php";
?>   
    <div id="top_panel">
		<div class="login_field">
			<form action="login.php" method="POST">
				Διεύθυνση Email:<br>
				<input type="text" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>"/>
				<div class="error_login_field"><?php echo $email_error_msg ?></div><br>
				<br>Κωδικός Ασφαλείας:<br>
				<input type="password" name="password" />
				<div class="error_login_field"><?php echo $pass_error_msg ?></div><br>
				<br><input type="submit" name="submit" value="Login" />
			</form>
		</div>
		<div class="login_image">
            		<img src="images/login_icon.png"/></img>
        </div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
