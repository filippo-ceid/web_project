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
	
	if (isset($_POST['new_category']) && preg_match ('/^([A-Z][a-zA-Z ]*|[Α-Ω][Α-Ωαάβγδεέζηήθιίϊΐκλνξοόπρστυύϋΰφχψωώς ]*)$/', $_POST['new_category'])) {
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
else if (isset($_POST['edit_categ_submit'])) { // Handle the form.
	
	$category=FALSE;
	
	if ($_POST['category'] != "default") {
		$category = mysqli_real_escape_string($dbhandle,$_POST['category']);
	}
	else {
		$category_error = ": Επιλέξτε κατηγορίας!";
	}
	
	if ($category_error == "") {
		$query = sprintf("SELECT categ_id, category, pin_icon FROM categories WHERE category = '$category';");
		$result = mysqli_query ($dbhandle,$query);
		$categData = mysqli_fetch_array($result, MYSQL_ASSOC);
		$pin_icon = $categData['pin_icon'];
		
		if ($pin_icon == 'pin_white') {
			$color_name = 'Άσπρο';
		}
		else if ($pin_icon == 'pin_yellow'){
			$color_name = 'Κίτρινο';
		}
		else if ($pin_icon == 'pin_orange'){
			$color_name = 'Πορτοκαλί';
		}
		else if ($pin_icon == 'pin_red'){
			$color_name = 'Κόκκινο';
		}
		else if ($pin_icon == 'pin_pink'){
			$color_name = 'Ροζ';
		}
		else if ($pin_icon == 'pin_purple'){
			$color_name = 'Μωβ';
		}
		else if ($pin_icon == 'pin_lightblue'){
			$color_name = 'Γαλάζιο';
		}
		else if ($pin_icon == 'pin_blue'){
			$color_name = 'Μπλε';
		}
		else if ($pin_icon == 'pin_green'){
			$color_name = 'Πράσινο';
		}
		else if ($pin_icon == 'pin_brown'){
			$color_name = 'Καφέ';
		}
		else if ($pin_icon == 'pin_grey'){
			$color_name = 'Γκρι';
		}
		else if ($pin_icon == 'pin_black'){
			$color_name = 'Μαύρο';
		}
		else {
			$color_name = '';
			$report = "Σφάλμα: Δεν βρέθηκε η κατηγορία στη βάση!";
		}
		$report = 'Η κατηγορία "'.$category.'" είναι έτοιμη προς τροποποίηση!';
		mysqli_free_result($result);
	}
	else {
		$report = "Σφάλμα: Δεν επιλέξατε κατηγορία προς τροποποίηση!";
	}
}
else if (isset($_POST['update_categ_submit'])) {
	
	$new_category_name = $new_pin_color = FALSE;
	
	if ($_POST['category_id']) {
		$category_id  = mysqli_real_escape_string($dbhandle,$_POST['category_id']);
		if (isset($_POST['new_category']) && preg_match ('/^([a-zA-Z ]*|[Α-Ωαάβγδεέζηήθιίϊΐκλνξοόπρστυύϋΰφχψωώς ]*)?$/', $_POST['new_category'])) {
			$new_category_name = mysqli_real_escape_string($dbhandle,$_POST['new_category']);
			$query = "SELECT categ_id FROM categories WHERE category = '$new_category_name' AND categ_id != $category_id;";
			$result = mysqli_query($dbhandle,$query);
			$row = mysqli_fetch_assoc($result);
			if (mysqli_num_rows($result) != 0) {
				$new_category_error = ": Η κατηγορία υπάρχει ήδη!";
			} 		
		}
		else {
			$new_category_error = ": Μη έγκυρο όνομα κατηγορίας!";
		}
		
		if ($_POST['pin_color'] != "default") {
			$new_pin_color = mysqli_real_escape_string($dbhandle,$_POST['pin_color']);
		}
		else {
			$pin_color_error = ": Επιλέξτε χρώμα!";
		}
		
		if ($new_category_error == "" && $pin_color_error == "") {
			$query = sprintf("UPDATE categories SET category='$new_category_name', pin_icon='$new_pin_color' WHERE categ_id = $category_id;");
			$result = mysqli_query($dbhandle,$query);
			if (mysqli_affected_rows($dbhandle) != 0) { // If it ran OK.
				$report = 'Η ενημέρωση της κατηγορίας πραγματοποιήθηκε!';
			} 
			else { // If it did not run OK.
				$report = "Αποτυχία Ενημέρωσης: Δοκιμάστε ξανά!";
			}
		}
		else {
			$report = "Σφάλμα: Παρακαλώ ελέγξτε τα δεδομένα που εισάγατε!";
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
