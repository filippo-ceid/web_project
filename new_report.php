<?php
	// Start output buffering:
	ob_start();
	// Initialize a session:
	session_start();
	
	if (isset($_POST['submit'])) { // Handle the form.
		
		require "db_config.php";
		
		$category = $description = $user_id = FALSE;
		
		$description = mysql_real_escape_string ($_POST['description']);
		
		if ($_POST['category'] != "default") {
				$category = mysql_real_escape_string ($_POST['category']);
				$user_id = $_SESSION ['user_id'];
				$query = "INSERT INTO reports (category, description, user_id) VALUES
				('$category', '$description', '$user_id');";
				$result = mysql_query ($query, $dbhandle);
				if (mysql_affected_rows($dbhandle) != 0) { // If it ran OK.
					$report = "Η αναφορά σας καταχωρήθηκε!";
					mysql_free_result($result);
					mysql_close($dbhandle);
					ob_end_clean(); // Delete the buffer.
					//header('Location: login.php');
					//exit(); // Quit the script.
				} 
				else { // If it did not run OK.
					$report = "Αποτυχία Καταχώρησης: Δοκιμάστε ξανά ή επικοινωνήστε μαζί μας!";
				}
		}
		else {
			$category_error = ": Επιλέξτε κατηγορία!";
			$report = "Σφάλμα: Παρακαλώ ελέγξτε τα δεδομένα που εισάγατε!";
		}
		mysql_close($dbhandle);
	}
	else{
		$description = "";
		$category_error = "";
		$report = "Εισάγετε νεα καταχώρηση στο σύστημα!";
	} // End of the main Submit conditional.
?>
