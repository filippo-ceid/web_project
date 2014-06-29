<?php

//έλεγχος των δεδομένων που εισάγονται από το χρήστη για την ανανέωση 
//των στοιχείων του προφίλ του
	
$new_email_error = "";
$pass_error = "";
$new_pass_error="";
$new_fname_error = "";
$new_lname_error = "";
$new_phone_error = "";
$report = "";

//τα παρακάτω εκτελούνται όταν πατηθεί στο update
//στη σελίδα my_account_page.php
if (isset($_POST['update'])) { // Handle the form.
	require "db_config.php";
	
	$new_email = $password = $new_password = $new_firstname = $new_lastname = $new_phone =FALSE;
	
	if (isset($_POST['email']) && preg_match ('/^[^\W_]+([.\-_][^\W_]+)*@[^\W_]+([.-_][^\W_]+)*.[A-Za-z]{2,3}$/', $_POST['email'])) {
		$new_email = mysqli_real_escape_string($dbhandle,$_POST['email']);
	} else {
		$new_email_error = ": Μη έγκυρη διεύθυνση email!";
	}
	
	$password = sha1(mysqli_real_escape_string($dbhandle,$_POST['password']));
	if ($password != $_SESSION['password']) {
		$pass_error = ": Λανθασμένος κωδικός ασφαλείας!";
	}
	else {
		$new_password = $password;
	}
		
	if ($_POST['new_password'] != ""){ 
		if (preg_match('/^[\s\S]{4,128}$/', $_POST['new_password'])) {
			if ($_POST['new_password'] == $_POST['conf_new_password']) {
				$new_password = sha1(mysqli_real_escape_string($dbhandle,$_POST['new_password']));
			}
			else {
				$new_pass_error = ": Ο κωδικός επαλήθευσης δεν ταυτίζεται με τον κωδικό ασφαλείας!";
			}
		}
		else {
			$new_pass_error = ": Μη έγκυρος κωδικός ασφαλείας!";
		}
	}
		
	if (isset($_POST['first_name']) && preg_match ('/^([a-zA-Z ]*|[Α-Ωαάβγδεέζηήθιίϊΐκλνξοόπρστυύϋΰφχψωώς ]*)?$/', $_POST['first_name'])) {
		$new_firstname = mysqli_real_escape_string($dbhandle,$_POST['first_name']);
	}
	else {
		$new_fname_error = ": Μη έγκυρο όνομα!";
	}
		
	if (isset($_POST['last_name']) && preg_match ('/^([a-zA-Z ]*|[Α-Ωαάβγδεέζηήθιίϊΐκλνξοόπρστυύϋΰφχψωώς ]*)?$/', $_POST['last_name'])) {
		$new_lastname = mysqli_real_escape_string($dbhandle,$_POST['last_name']);
	} else {
		$new_lname_error = ": Μη έγκυρο επώνυμο!"; 
	}
		
	if(isset($_POST['phone']) && preg_match("/^(2[1-9][0-9]{8}|69[0-9]{8})?$/", $_POST['phone'])) {
		$new_phone = mysqli_real_escape_string($dbhandle,$_POST['phone']);
	} else {
		$new_phone_error = ": Μη έγκυρος αριθμός!"; 
	}
		
	if (($new_email_error == "") && ($pass_error == "") && ($new_pass_error == "") && ($new_fname_error == "") && ($new_lname_error == "") && ($new_phone_error == "")) { // If everything's OK...
		$user_id = $_SESSION ['user_id'];
		$query = sprintf("UPDATE users SET email='$new_email', password='$new_password', firstname='$new_firstname', lastname='$new_lastname', phone='$new_phone'  WHERE user_id = $user_id;");
		$result = mysqli_query($dbhandle,$query);
		if (mysqli_affected_rows($dbhandle) != 0) { // If it ran OK.
			$report = "Η ενημέρωση των στοιχείων σας πραγματοποιήθηκε!";
			$query = "SELECT user_id, email, password, user_level, firstname, lastname, phone FROM users WHERE user_id = '$user_id';";
			$result = mysqli_query ($dbhandle,$query);
			$_SESSION = mysqli_fetch_array($result, MYSQL_ASSOC);
			mysqli_free_result($result);
		} 
		else { // If it did not run OK.
			$report = "Αποτυχία Ενημέρωσης: Δοκιμάστε ξανά ή επικοινωνήστε μαζί μας!";
		}
	}
	else { // If one of the data tests failed.
		$report = "Σφάλμα Ενημέρωσης: Παρακαλώ ελέγξτε τα δεδομένα που εισάγατε!";
	}
	mysqli_close($dbhandle);
}
else{
	$report = "Τροποποιήστε τα στοιχεία σας στη φόρμα ενημέρωσης!";
}
?>
