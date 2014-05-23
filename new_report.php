<?php
	// Start output buffering:
	ob_start();
	// Initialize a session:
	session_start();
	
	if (isset($_POST['submit'])) { // Handle the form.
		
		require "db_config.php";
		
		$category = $description = $user_id = FALSE;
		
		if ($_POST['category'] != "default") {
			$category = mysql_real_escape_string ($_POST['category']);
		} else {
			$category_error = ": Επιλέξτε κατηγορία!";
		}
		
		if (strlen($_POST['description'])<1) {
			$description_error = ": Δώστε περιγραφή!(έως 250 χαρακτήρες)";
		} elseif (strlen($_POST['description'])>500) {
			$description_error = ": Εισάγετε έως 250 χαρακτήρες!";
		} else {
			$description = mysql_real_escape_string ($_POST['description']);
		}
		
		if (($category_error == "") && ($description_error == "")) {
				$user_id = $_SESSION ['user_id'];
				$query = "INSERT INTO reports (category, description, user_id) VALUES
				('$category', '$description', '$user_id');";
				$result = mysql_query ($query, $dbhandle);
				if (mysql_affected_rows($dbhandle) != 0) { // If it ran OK.
					$report = "Η αναφορά σας καταχωρήθηκε!";
					mysql_free_result($result);
					mysql_close($dbhandle);
					ob_end_clean(); // Delete the buffer.
				} 
				else { // If it did not run OK.
					$report = "Αποτυχία Καταχώρησης: Δοκιμάστε ξανά ή επικοινωνήστε μαζί μας!";
				}
		}
		else {
			$report = "Σφάλμα: Παρακαλώ ελέγξτε τα δεδομένα που εισάγατε!";
		}
		mysql_close($dbhandle);
	}
	else{
		$description_error = "";
		$category_error = "";
		$report = "Εισάγετε νεα καταχώρηση στο σύστημα!";
	} // End of the main Submit conditional.
?>
