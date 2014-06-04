<?php

require "db_config.php";

################ Continue generating Map XML #################
// Select all the rows in the markers table
$query = sprintf("SELECT report_id, category, description, datetime, lat, lng, firstname, lastname FROM reports INNER JOIN users on users.user_id = reports.user_id ORDER BY report_id DESC LIMIT 20;");
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
	$newnode->setAttribute("firstname", $row['firstname']);
	$newnode->setAttribute("lastname", $row['lastname']);
	$report_id = $row['report_id'];
	$query = "SELECT photo_name FROM photos WHERE report_id=$report_id;";
	$photos_result = mysqli_query($dbhandle,$query);
	$i = 0;
	while ($photos_row = mysqli_fetch_assoc($photos_result)){
		$newnode->setAttribute("photo_name_".$i, $photos_row['photo_name']);
		$i = $i + 1;
	}
	$newnode->setAttribute("num_of_photos", $i);
	$category = $row['category'];
	$query = sprintf("SELECT pin_icon FROM categories WHERE category='$category';");
	$icon_result = mysqli_query($dbhandle,$query);
	$icon_row = mysqli_fetch_assoc($icon_result);
	$newnode->setAttribute("pin_icon", $icon_row['pin_icon']);
}

echo $dom->saveXML();

mysqli_free_result($result);
mysqli_close($dbhandle);
?>
