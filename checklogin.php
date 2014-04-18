<?php
    require "db_config.php";
    
	// Start output buffering:
	ob_start();

	// Initialize a session:
	session_start();

	if(isset($_POST['submit'])){

		//select a database to work with
		mysql_select_db(DB_NAME,$dbhandle)
			or die("Could not select " . DB_NAME);
			
		// Validate the email address and password
		if (!empty($_POST['email'])) { 
			if (!empty($_POST['password'])) {
				
				$email = mysql_real_escape_string($_POST['email']);
				$query = "SELECT email, password, user_type
				FROM users
				WHERE email = '$email';";

				//execute the SQL query and return records
				$result = mysql_query($query, $dbhandle);

				if(mysql_num_rows($result) != 0) { // User not found.
					$userData = mysql_fetch_array($result, MYSQL_ASSOC);
					$password = mysql_real_escape_string($_POST['password']);
					if($password != $userData['password']) { // Incorrect password.
						$pass_error_msg = "Check your password!";
						$email_error_msg = "Check your email address!";
					}
					else{ // Redirect to home page after successful login.
						session_regenerate_id();
						$_SESSION['sess_user_id'] = $userData['id'];
						$_SESSION['sess_email'] = $userData['email'];
						session_write_close();
						header('Location: index.php');
					}
				}
				else{
					$pass_error_msg = "Check your password!";
					$email_error_msg = "Check your email address!";
				}
			} 
			else {
			$password = FALSE;
			$pass_error_msg = "You forgot to enter your password!";
			}
		} 
		else {
			$email = FALSE;
			$email_error_msg = "You forgot to enter your email!";
		}
	}
	else {
		$email_error_msg = "";
		$pass_error_msg = "";	
	}
	//close the connection
	mysql_close($dbhandle);
?>
