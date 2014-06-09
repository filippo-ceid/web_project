<?php
$user_error ="";
$new_email_error = "";
$pass_error = "";
$new_pass_error="";
$new_fname_error = "";
$new_lname_error = "";
$new_phone_error = "";
$report = "";


require "db_config.php";

if (isset($_POST['update'])) { // Handle the form.
	
	$email = $new_email = $new_password = $new_level = $new_firstname = $new_lastname = $new_phone =FALSE;
	
	$email = $_POST['user'];
		
	if (isset($_POST['email']) && preg_match ('/^[^\W_]+([.\-_][^\W_]+)*@[^\W_]+([.-_][^\W_]+)*.[A-Za-z]{2,3}$/', $_POST['email'])) {
		$new_email = mysqli_real_escape_string($dbhandle,$_POST['email']);
	} else {
		$new_email_error = ": Μη έγκυρη διεύθυνση email!";
	}
		
	$password = sha1(mysqli_real_escape_string($dbhandle,$_POST['password']));
	if ($password != $_SESSION['password']) {
		$pass_error = ": Λανθασμένος κωδικός ασφαλείας!";
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
	else {
		$query = "SELECT password FROM users WHERE email = '$email';";
		$result = mysqli_query ($dbhandle,$query);
		$userData = mysqli_fetch_array($result, MYSQL_ASSOC);
		$new_password = $userData['password'];
	}
		
	$new_level = mysqli_real_escape_string($dbhandle,$_POST['level']);
			
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
		
	if ($_POST['user_level'] != 'admin' || $_POST['user_id'] == $_SESSION['user_id']) {
		if (($new_email_error == "") && ($pass_error == "") && ($new_pass_error == "") && ($new_fname_error == "") && ($new_lname_error == "") && ($new_phone_error == "")) { // If everything's OK...
			$query = sprintf("UPDATE users SET email='$new_email', password='$new_password', user_level='$new_level', firstname='$new_firstname', lastname='$new_lastname', phone='$new_phone'  WHERE email = '$email';");
			$result = mysqli_query($dbhandle,$query);
			if (mysqli_affected_rows($dbhandle) != 0) { // If it ran OK.
				$report = "Η ενημέρωση των στοιχείων πραγματοποιήθηκε!";
			} 
			else { // If it did not run OK.
				$report = "Αποτυχία Ενημέρωσης: Δοκιμάστε ξανά!";
			}
		}
		else { // If one of the data tests failed.
			$report = "Σφάλμα Ενημέρωσης: Παρακαλώ ελέγξτε τα δεδομένα που εισάγατε!";
		}
		$query = "SELECT user_id, email, password, user_level, firstname, lastname, phone FROM users WHERE email = '$email';";
		$result = mysqli_query ($dbhandle,$query);
		$userData = mysqli_fetch_array($result, MYSQL_ASSOC);
		mysqli_free_result($result);
	}
	else {
		$report = "Σφάλμα Ενημέρωσης: Δεν μπορείτε να τροποποιήσετε στοιχεία διαχειριστή!";
	}
}
else if (isset($_POST['search'])) { // Handle the form.
	$user=FALSE;
	
	if (isset($_POST['user']) && preg_match ('/^[^\W_]+([.\-_][^\W_]+)*@[^\W_]+([.-_][^\W_]+)*.[A-Za-z]{2,3}$/', $_POST['user'])) {
		$user = mysqli_real_escape_string($dbhandle,$_POST['user']);
	} else {
		$user_error = "  Μη έγκυρη διεύθυνση email!";
	}
	
	if ($user_error == "") {
		$query = "SELECT user_id, email, password, user_level, firstname, lastname, phone FROM users WHERE email = '$user';";
		$result = mysqli_query ($dbhandle,$query);
		$userData = mysqli_fetch_array($result, MYSQL_ASSOC);
		if ($userData != 0){
			$report = "Τροποποιήστε τα στοιχεία στη φόρμα ενημέρωσης!";
		}
		else {
			$report = "Δεν βρέθηκε ο χρήστη ".$user."!";
		}
		mysqli_free_result($result);
	}
	else { // If it did not run OK.
		$report = "Αποτυχία Αναζήτησης!";
	}
}
else if (isset($_POST['delete'])) { // Handle the form.
	$email = $_POST['user'];
	$password = sha1(mysqli_real_escape_string($dbhandle,$_POST['password']));
	if ($password == $_SESSION['password']) {
		if ($_POST['user_level'] == 'simple') {
			$query = sprintf("DELETE FROM users WHERE email = '$email';");
			$result = mysqli_query($dbhandle,$query);
			if (mysqli_affected_rows($dbhandle) != 0) { // If it ran OK.
				$report = "Ο χρήστης ".$email." διαγράφηκε απο το σύστημα!";
				mysqli_free_result($result);
			} 
			else { // If it did not run OK.
				$report = "Αποτυχία Διαγραφής: Δοκιμάστε ξανά!";
			}
		}
		else{
			$report = "Σφάλμα Διαγραφής: Δεν μπορείτε να διαγράψετε διαχειριστή απο το σύστημα!";
		}
	}
	else {
		$pass_error = ": Λανθασμένος κωδικός ασφαλείας!";
		$report = "Σφάλμα Διαγραφής: Παρακαλώ ελέγξτε τα δεδομένα που εισάγατε!";
	}
}
else{
	$report = "Αναζητήστε χρήστη του συστήματος!";
}
mysqli_close($dbhandle);
?>
