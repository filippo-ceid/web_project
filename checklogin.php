<?php
	// Start output buffering:
	ob_start();
	// Initialize a session:
	session_start();

	if (isset($_POST['submit'])) {
		
		require "db_config.php";

		// Validate the email address and password
		if (!empty($_POST['email'])) { 
			if (!empty($_POST['password'])) {
				
				$email = mysqli_real_escape_string($dbhandle,$_POST['email']);
				$query = "SELECT user_id, email, password, user_level
				FROM users
				WHERE email = '$email';";

				//execute the SQL query and return records
				$result = mysqli_query ($dbhandle,$query);
				
				if(mysqli_num_rows($result) != 0) { // User not found.
					$_SESSION = mysqli_fetch_array($result, MYSQL_ASSOC);
					$password = sha1(mysqli_real_escape_string($dbhandle,$_POST['password']));
					if($password != $_SESSION ['password']) { // Incorrect password.
						$_SESSION = array();
						$pass_error_msg = "Ελέγξτε τον κωδικό ασφαλείας!";
						$email_error_msg = "Ελέγξτε τη διεύθυνση email!";
					}
					else{ // Redirect to home page after successful login.
						mysqli_free_result($result);
						mysqli_close($dbhandle);
						ob_end_clean(); // Delete the buffer.
						header("Location: index.php");
						exit(); // Quit the script.
					}
				}
				else{
					$pass_error_msg = "Ελέγξτε τον κωδικό ασφαλείας!";
						$email_error_msg = "Ελέγξτε τη διεύθυνση email!";
				}
			} 
			else {
			$password = FALSE;
			$pass_error_msg = "Ξεχάσατε να εισάγετε κωδικό!";
			}
		} 
		else {
			$email = FALSE;
			$email_error_msg = "Ξεχάσατε να εισάγετε διεύθυνση email!";
		}
		mysqli_close($dbhandle); //close the connection
	}
	else {
		$email_error_msg = "";
		$pass_error_msg = "";	
	}
?>
