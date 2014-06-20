<?php
// Start output buffering:
ob_start();
// Initialize a session:
session_start();

if (isset($_SESSION ['user_id'])){
	$user_id =  $_SESSION ['user_id'];
	require "check_permissions.php";
	check_simple_permissions($user_id);
}
else {
	exit();
}

require "db_config.php";

################ Save & delete markers #################
if($_POST) //run only if there's a post data
{
	$source = 'uploads';
	//make sure request is comming from Ajax
	$xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'; 
	if (!$xhr){ 
		header('HTTP/1.1 500 Error: Request must come from Ajax!'); 
		mysqli_free_result($result);
		mysqli_close($dbhandle);
		exit();
	}
	
	// get marker position and split it for database
	$mLatLang	= explode(',',$_POST["latlang"]);
	$mLat 		= filter_var($mLatLang[0], FILTER_VALIDATE_FLOAT);
	$mLng 		= filter_var($mLatLang[1], FILTER_VALIDATE_FLOAT);
	
	//Delete Report
	if(isset($_POST["del"]) && $_POST["del"]==true)
	{
		$query = sprintf("SELECT report_id FROM reports WHERE user_id=$user_id AND lat=$mLat AND lng=$mLng;");
		$result = mysqli_query($dbhandle,$query);
		$row = mysqli_fetch_assoc($result);
		$report_id = $row['report_id'];
		
		$query = sprintf("SELECT photo_name FROM photos WHERE report_id=$report_id;");
		$result = mysqli_query($dbhandle,$query);
		while ($row = mysqli_fetch_assoc($result)){
			$photo_name = $source."/".$row['photo_name'];
			unlink($photo_name);
		}
		$query = "DELETE FROM reports WHERE user_id=$user_id AND lat=$mLat AND lng=$mLng;";
		$result = mysqli_query($dbhandle,$query);
	}
	else if(isset($_POST["save"]) && $_POST["save"]==true)
	{
		$mCateg = filter_var($_POST["category"], FILTER_SANITIZE_STRING);
		$mDesc 	= filter_var($_POST["description"], FILTER_SANITIZE_STRING);
		
		//$user_id = $_SESSION ['user_id'];
		$query = "INSERT INTO reports (category, description, lat, lng, user_id) VALUES ('$mCateg', '$mDesc', '$mLat', '$mLng', '$user_id');"; //+user_id
		$result = mysqli_query($dbhandle,$query);
		
		$query = sprintf("SELECT report_id FROM reports ORDER BY report_id DESC LIMIT 1;");
		$result = mysqli_query($dbhandle,$query);
		
		$row = mysqli_fetch_assoc($result);
		$rep_id = $row['report_id'];
		
		$query = "INSERT INTO status (report_id) VALUES ('$rep_id');"; //+user_id
		$result = mysqli_query($dbhandle,$query);
	}
	mysqli_free_result($result);
	mysqli_close($dbhandle);
	exit();
}


################ Continue generating Map XML #################
// Select all the rows in the markers table
$query = sprintf("SELECT COUNT(*) FROM reports WHERE user_id=$user_id;");
$result = mysqli_query($dbhandle,$query);
$count_row = mysqli_fetch_assoc($result);
$counts = $count_row['COUNT(*)'];

$query = sprintf("SELECT reports.report_id, category, description, datetime, lat, lng , status ,comment FROM reports INNER JOIN status on status.report_id=reports.report_id WHERE user_id=$user_id ORDER BY datetime DESC;");
$result = mysqli_query($dbhandle,$query);

if (!$result) {  
	header('HTTP/1.1 500 Error: Could not get reports!'); 
	exit();
} 

//set document header to text/xml
header("Content-type: text/xml"); 

//Create a new DOMDocument object
$dom = new DOMDocument('1.0','utf-8');
$dom->formatOutput = true;
$node = $dom->createElement("reports"); //Create new element node
$parnode = $dom->appendChild($node); //make the node show up 

// Iterate through the rows, adding XML nodes for each
while ($row = mysqli_fetch_assoc($result)){
	$node = $dom->createElement("report");
	$newnode = $parnode->appendChild($node);
	$newnode->setAttribute("category", $row['category']);
	$newnode->setAttribute("description", $row['description']);
	$newnode->setAttribute("datetime", $row['datetime']);
	$newnode->setAttribute("lat", $row['lat']);
	$newnode->setAttribute("lng", $row['lng']);
	$newnode->setAttribute("report_status", $row['status']);
	$newnode->setAttribute("report_comment", $row['comment']);
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

if ($counts == 0) {
	$node = $dom->createElement("report");
	$newnode = $parnode->appendChild($node);
	$newnode->setAttribute("num_of_reports", $counts);
}

echo $dom->saveXML();

mysqli_free_result($result);
mysqli_close($dbhandle);
?>
