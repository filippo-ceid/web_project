<?php
// Start output buffering:
ob_start();
// Initialize a session:
session_start();

if (isset($_SESSION ['user_id'])){
	$user_id =  $_SESSION ['user_id'];
	//require "check_permissions.php";
	//check_admin_permissions($user_id);
}
else {
	//exit();
}

################ Save & delete markers #################
if($_POST) //run only if there's a post data
{
	require "db_config.php";
	
	if(isset($_POST["list"]))
	{
		GetReports($_POST["list"],$_POST["page"]);
	}
	
	$source = 'uploads';
	//make sure request is comming from Ajax
	$xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'; 
	if (!$xhr){ 
		header('HTTP/1.1 500 Error: Request must come from Ajax!'); 
		exit();
	}
	
	// get marker position and split it for database
	$mLatLang	= explode(',',$_POST["latlang"]);
	$mLat 		= filter_var($mLatLang[0], FILTER_VALIDATE_FLOAT);
	$mLng 		= filter_var($mLatLang[1], FILTER_VALIDATE_FLOAT);
	
	//Delete Report
	if(isset($_POST["del"]) && $_POST["del"]==true)
	{
		$query = sprintf("SELECT report_id FROM reports WHERE lat=$mLat AND lng=$mLng;");
		$result = mysqli_query($dbhandle,$query);
		$row = mysqli_fetch_assoc($result);
		$report_id = $row['report_id'];
		$query = sprintf("SELECT photo_name FROM photos WHERE report_id=$report_id;");
		$result = mysqli_query($dbhandle,$query);
		while ($row = mysqli_fetch_assoc($result)){
			$photo_name = $source."/".$row['photo_name'];
			unlink($photo_name);
		}
		$query = "DELETE FROM reports WHERE lat=$mLat AND lng=$mLng;";
		$result = mysqli_query($dbhandle,$query);
	}
	else if(isset($_POST["save"]) && $_POST["save"]==true)
	{
		$query = sprintf("SELECT report_id FROM reports WHERE lat=$mLat AND lng=$mLng;");
		$result = mysqli_query($dbhandle,$query);
		$row = mysqli_fetch_assoc($result);
		$report_id = $row['report_id'];
		$mStatus = $_POST['status'];
		$mComm 	= $_POST['comment'];
		$query = "UPDATE status SET status='$mStatus', comment='$mComm', admin_id=$user_id  WHERE report_id =$report_id";
		$result = mysqli_query($dbhandle,$query);
	}
	mysqli_free_result($result);
	mysqli_close($dbhandle);
	exit();
}
else {
	GetReports('Ανοιχτή', 0);
}

function GetReports($status, $page){
	require "db_config.php";
	################ Continue generating Map XML #################
	// Select all the rows in the markers table
	$query = sprintf("SELECT COUNT(*) FROM reports, status WHERE reports.report_id = status.report_id AND status = '$status';");
	$result = mysqli_query($dbhandle,$query);
	$count_row = mysqli_fetch_assoc($result);
	$counts = $count_row['COUNT(*)'];
	
	if ($page==0){
		$page_num = ceil($counts/20);
		$page_n = 1;
	}
	else {
		$page_num = $page;
		$page_n = $page;
	}
	
	//set document header to text/xml
	header("Content-type: text/xml"); 

	//Create a new DOMDocument object
	$dom = new DOMDocument('1.0','utf-8');
	$dom->formatOutput = true;
	$node = $dom->createElement("reports"); //Create new element node
	$parnode = $dom->appendChild($node); //make the node show up 
	
	while ($page_n<=$page_num){
		
		$first_report = ($page_n - 1)*20;
		$query = sprintf("SELECT * FROM (SELECT reports.report_id ,category, description, datetime, lat, lng, email, admin_id FROM reports INNER JOIN status on reports.report_id=status.report_id INNER JOIN users on users.user_id = reports.user_id WHERE status.status ='$status' ORDER BY datetime DESC  LIMIT $first_report,20) AS T1 ORDER BY category;");
		$result = mysqli_query($dbhandle,$query);

		if (!$result) {  
			header('HTTP/1.1 500 Error: Could not get reports!'); 
			exit();
		} 

		// Iterate through the rows, adding XML nodes for each
		while ($row = mysqli_fetch_assoc($result)){
			$node = $dom->createElement("report");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("category", $row['category']);
			$newnode->setAttribute("description", $row['description']);
			$newnode->setAttribute("datetime", $row['datetime']);
			$newnode->setAttribute("lat", $row['lat']);
			$newnode->setAttribute("lng", $row['lng']);
			$newnode->setAttribute("user_email", $row['email']);

			$admin_id = $row['admin_id'];
			$query = sprintf("SELECT email FROM users WHERE user_id='$admin_id';");
			$admin_result = mysqli_query($dbhandle,$query);
			$admin_row = mysqli_fetch_assoc($admin_result);
			$newnode->setAttribute("admin_email", $admin_row['email']);
			
			$report_id = $row['report_id'];
			$query = "SELECT photo_name FROM photos WHERE report_id=$report_id;";
			$photos_result = mysqli_query($dbhandle,$query);
			$i = 0;
			while ($photos_row = mysqli_fetch_assoc($photos_result)){
				$newnode->setAttribute("photo_name_".$i, $photos_row['photo_name']);
				$i = $i + 1;
			}
			$newnode->setAttribute("num_of_photos", $i);
			$newnode->setAttribute("num_of_reports", $counts);
			$category = $row['category'];
			$query = sprintf("SELECT pin_icon FROM categories WHERE category='$category';");
			$icon_result = mysqli_query($dbhandle,$query);
			$icon_row = mysqli_fetch_assoc($icon_result);
			$newnode->setAttribute("pin_icon", $icon_row['pin_icon']);
		}
		$page_n = $page_n + 1 ;
	}

	if ($counts == 0) {
		$node = $dom->createElement("report");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("num_of_reports", $counts);
	}

	echo $dom->saveXML();
	
	mysqli_free_result($result);
	mysqli_close($dbhandle);
}
?>
