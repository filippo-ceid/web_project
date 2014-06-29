<?php
$report = "Επιλέξτε έως 4 φωτογραφίες (jpeg,jpg,png,gif)";

//τα παρακάτω θα εκτελεστούν όταν πατήσουμε 
//submit στο αρχείο uploadphotos.php
if(isset($_POST['submit']))
{	
	//αποθηκέυονται στη βάση τα ονόματα των φωτογραφιών που ανεβάζουμε
	//και οι φωτογραφίες στέλνονται στη φάκελο uploads
    $destination = 'uploads';
    $images = array('ImageFile1','ImageFile2','ImageFile3','ImageFile4');
    $k = 0;
    
    require "db_config.php";
    $query = sprintf("SELECT report_id FROM reports WHERE user_id=$user_id ORDER BY report_id DESC LIMIT 1;");
	$result = mysqli_query($dbhandle,$query);
	$row = mysqli_fetch_assoc($result);
	$report_id = $row['report_id'];
	
	
	for ($i = 0; $i <= 3; $i++) {
		$img = $images[$i];
		$ImageType = $_FILES[$img]['type']; //"image/png", image/jpeg etc.
		if ((($ImageType == "image/gif") || ($ImageType == "image/jpeg") || ($ImageType == "image/jpg") || ($ImageType == "image/png") || ($ImageType == ""))
		&& ($_FILES["file"]["size"] < 20000000)){
			$k = $k + 1;
		}
	}
	
	if($k==4){
		for ($i = 0; $i <= 3; $i++) {
			$img = $images[$i];
			$ImageType = $_FILES[$img]['type']; //"image/png", image/jpeg etc.
			if ($ImageType != ""){
				$ImageExt = substr($ImageType,6);
				$ImageName = "image_".$report_id."_(".$i.").".$ImageExt;
				move_uploaded_file($_FILES[$img]['tmp_name'], "$destination/$ImageName");
				$query = "INSERT INTO photos (photo_name, report_id) VALUES ('$ImageName', '$report_id');";
				$result = mysqli_query($dbhandle,$query);
			}
		}
		ob_end_clean(); // Delete the buffer.
		header("Location: my_reports_page.php");
		exit(); // Quit the script.
	}
	else {
		$report = "Σφάλμα: Μη αποδεκτή μορφή αρχείου!<br>Αποδεκτές μορφές: jpeg,jpg,png,gif";
	} 
}
else if (isset($_POST['cancel'])){
	ob_end_clean(); // Delete the buffer.
	header("Location: my_reports_page.php");
	exit(); // Quit the script.
}
?> 
