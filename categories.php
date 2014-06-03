<?php

// Start output buffering:
ob_start();
// Initialize a session:
session_start();

if (!isset($_SESSION ['user_id'])){
	header('Location: index.php');
	exit();
}

require "db_config.php";

################ Continue generating Map XML #################
// Select all the rows in the markers table
$query = sprintf("SELECT category FROM categories;");
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
$node = $dom->createElement("categories"); //Create new element node
$parnode = $dom->appendChild($node); //make the node show up 

// Iterate through the rows, adding XML nodes for each
while ($row = mysqli_fetch_assoc($result)){
	  $node = $dom->createElement("category");
	  $newnode = $parnode->appendChild($node);
	  $newnode->setAttribute("category", $row['category']);
}

echo $dom->saveXML();

mysqli_free_result($result);
mysqli_close($dbhandle);
?>
