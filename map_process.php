<?php

// Start output buffering:
ob_start();
// Initialize a session:
session_start();

require "db_config.php";

$user_id = $_SESSION ['user_id'];

################ Save & delete markers #################
if($_POST) //run only if there's a post data
{
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
		$query = "DELETE FROM reports WHERE user_id=$user_id AND lat=$mLat AND lng=$mLng;"; //+user_id
		$result = mysqli_query($dbhandle,$query);
	}
	else if(isset($_POST["save"]) && $_POST["save"]==true)
	{
		$mCateg = filter_var($_POST["category"], FILTER_SANITIZE_STRING);
		$mDesc 	= filter_var($_POST["description"], FILTER_SANITIZE_STRING);
		
		//$user_id = $_SESSION ['user_id'];
		$query = "INSERT INTO reports (category, description, lat, lng, locked, user_id) VALUES ('$mCateg', '$mDesc', '$mLat', '$mLng', 'false', '$user_id');"; //+user_id
		$result = mysqli_query($dbhandle,$query);
	}
	mysqli_free_result($result);
	mysqli_close($dbhandle);
	exit();
}


################ Continue generating Map XML #################
// Select all the rows in the markers table
$query = sprintf("SELECT category, description, datetime, lat, lng FROM reports WHERE user_id=$user_id;");
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
}

echo $dom->saveXML();

mysqli_free_result($result);
mysqli_close($dbhandle);
?>
