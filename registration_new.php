<?php	
$email_error = "";
$pass_error = "";
$fname_error = "";
$lname_error = "";
$phone_error = "";
$report = "";

if (isset($_POST['submit'])) { // Handle the form.	
	require "db_config.php";
		
	// Assume invalid values:
	$email = $password = $firstname = $lastname = $phone = FALSE;
		
	// Check for an email address:
	if (preg_match ('/^[^\W_]+([.\-_][^\W_]+)*@[^\W_]+([.-_][^\W_]+)*.[A-Za-z]{2,3}$/', $_POST['email'])) {
		$email = mysqli_real_escape_string($dbhandle,$_POST['email']);
	} else {
		$email_error = ": Μη έγκυρη διεύθυνση email!";
	}

	// Check for a password and match against the confirmed password:
	if (preg_match('/^[\s\S]{4,128}$/', $_POST['password']) ) {
		if ($_POST['password'] == $_POST['conf_password']) {
			$password = sha1(mysqli_real_escape_string($dbhandle,$_POST['password']));
		}
		else {
			$pass_error = ": Ο κωδικός επαλήθευσης δεν ταυτίζεται με τον κωδικό ασφαλείας!";
		}
	} 
	else {
		$pass_error = ": Μη έγκυρος κωδικός ασφαλείας!";
	}
		
	// Check for a first name:
	if (isset($_POST['first_name']) && preg_match ('/^([a-zA-Z ]*|[Α-Ωαάβγδεέζηήθιίϊΐκλνξοόπρστυύϋΰφχψωώς ]*)?$/', $_POST['first_name'])) {
		$firstname = mysqli_real_escape_string($dbhandle,$_POST['first_name']);
	}
	else {
		$fname_error = ": Μη έγκυρο όνομα!";
	}
		
	// Check for a last name:
	if (isset($_POST['last_name']) && preg_match ('/^([a-zA-Z ]*|[Α-Ωαάβγδεέζηήθιίϊΐκλνξοόπρστυύϋΰφχψωώς ]*)?$/', $_POST['last_name'])) {
		$lastname = mysqli_real_escape_string($dbhandle,$_POST['last_name']);
	} else {
		$lname_error = ": Μη έγκυρο επώνυμο!"; 
	}
	
	//Check for a phone number: ??????
	if(isset($_POST['phone']) && preg_match("/^(2[1-9][0-9]{8}|69[0-9]{8})?$/", $_POST['phone'])) {
		$phone = mysqli_real_escape_string($dbhandle,$_POST['phone']);
	} else {
		$phone_error = ": Μη έγκυρος αριθμός!"; 
	}
		
	if ($email && $password && ($fname_error == "") && ($lname_error == "") && ($phone_error == "")) { // If everything's OK...
		// Make sure the email address is available:
		$query = "SELECT user_id FROM users WHERE email= '$email';";
		$result = mysqli_query($dbhandle,$query);
		if (mysqli_num_rows($result) != 0) { // The email address is not available.
			$email_error = ": Μη έγκυρη διεύθυνση email!";
			$report = "Σφάλμα Εγγραφής: Η διεύθυνση email έχει καταχωρηθεί ήδη!";
		} 
		else { // Available.
			$user_level = "simple"; //gia na ginei kapoios admin prepei na tou allaksei tin idiotita enas allos admin
			// Add the user to the database:
			$query = "INSERT INTO users (email, password, user_level, firstname, lastname, phone) VALUES 
			('$email', '$password', '$user_level', '$firstname', '$lastname', '$phone');";
			$result = mysqli_query($dbhandle,$query);
			if (mysqli_affected_rows($dbhandle) != 0) { // If it ran OK.
				$report = "Ευχαριστούμε για την εγγραφή σας στο σύστημα!";
				mysqli_free_result($result);
				mysqli_close($dbhandle);
				ob_end_clean(); // Delete the buffer.
				header('Location: login_page.php');
				exit(); // Quit the script.
			} 
			else { // If it did not run OK.
				$report = "Αποτυχία Εγγραφής: Δοκιμάστε ξανά ή επικοινωνήστε μαζί μας!";
			}
		}
	}
	else { // If one of the data tests failed.
		$report = "Σφάλμα Εγγραφής: Παρακαλώ ελέγξτε τα δεδομένα που εισάγατε!";
	}
	mysqli_close($dbhandle);
}
else{
	$report = "Εισάγετε τα στοιχεία σας στη φόρμα εγγραφής!";
} // End of the main Submit conditional.
?>
