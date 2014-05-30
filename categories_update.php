<?php

if (!isset($user_id)){
	exit();
}

require "db_config.php";

$report = "";
$new_category_error = "";
$category_error = "";
$pin_color_error = "";

if (isset($_POST['new_categ_submit'])) {

	$new_category = $pin_color = FALSE;
	
	if (isset($_POST['new_category']) && preg_match ('/^([a-zA-Z ]*|[Α-Ωαάβγδεέζηήθιίϊΐκλνξοόπρστυύϋΰφχψωώς ]*)?$/', $_POST['new_category'])) {
		$new_category = mysqli_real_escape_string($dbhandle,$_POST['new_category']);
	}
	else {
		$new_category_error = ": Μη έγκυρο όνομα κατηγορίας!";
	}
	
	if ($_POST['pin_color'] != "default") {
		$pin_color = mysqli_real_escape_string($dbhandle,$_POST['pin_color']);
	}
	else {
		$pin_color_error = ": Επιλέξτε χρώμα!";
	}
	
	if (($new_category_error == "") && ($pin_color_error == "")) {
		$query = "SELECT categ_id FROM categories WHERE category = '$new_category';";
		$result = mysqli_query($dbhandle,$query);
		if (mysqli_num_rows($result) != 0) {
			$email_error = ": Μη έγκυρη κατηγορία!";
			$report = 'Σφάλμα: Η κατηγορία "'.$new_category.'" έχει καταχωρηθεί ήδη!';
		} 
		else {
			$query = "INSERT INTO categories (category, pin_icon) VALUES ('$new_category', '$pin_color');";
			$result = mysqli_query($dbhandle,$query);
			if (mysqli_affected_rows($dbhandle) != 0) { // If it ran OK.
				$report = 'Η κατηγορία "'.$new_category.'" προστέθηκε επιτυχώς!';
			} 
			else { 
				$report = "Αποτυχία Προσθήκης: Δοκιμάστε ξανά!";
			}
		}
	}
	else {
		$report = "Σφάλμα: Παρακαλώ ελέγξτε τα δεδομένα που εισάγατε!";
	}
}
else if (isset($_POST['delete_categ_submit'])) {
	
	$category = FALSE;
	
	if ($_POST['category'] != "default") {
		$category = mysqli_real_escape_string($dbhandle,$_POST['category']);
	}
	else {
		$category_error = ": Επιλέξτε κατηγορίας!";
	}
	if ($category_error == "") {
		$query = "SELECT categ_id FROM categories WHERE category = '$category';";
		$result = mysqli_query($dbhandle,$query);
		$row = mysqli_fetch_assoc($result);
		$category_id = $row['categ_id'];
		if ($category_id == "") {
			$report = 'Η κατηγορία "'.$category.'" έχει διαγραφεί ήδη!';
		}
		else { 
			$query = sprintf("DELETE FROM categories WHERE categ_id = '$category_id';");
			$result = mysqli_query($dbhandle,$query);
			if (mysqli_affected_rows($dbhandle) != 0) { // If it ran OK.
				$report = 'Η κατηγορία "'.$category.'" διαγράφηκε απο το σύστημα!';
			} 
			else { // If it did not run OK.
				$report = "Αποτυχία Διαγραφής: Δοκιμάστε ξανά!";
			}
		}	
	}
	else {
		$report = "Σφάλμα: Δεν επιλέξατε κατηγορία προς διαγραφή!";
	}
}

$categ_selection ="";
$query = sprintf("SELECT category FROM categories;");
$result = mysqli_query($dbhandle,$query);
while ($row = mysqli_fetch_assoc($result)){
	$categ_selection = $categ_selection.'<option value="'.$row['category'].'"/>'.$row['category'].'</option>';
}

mysqli_free_result($result);
mysqli_close($dbhandle);
?>
