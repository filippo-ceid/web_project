<?php
// Start output buffering:
ob_start();
// Initialize a session:
session_start();

if (isset($_SESSION ['user_id'])){
	$user_id =  $_SESSION ['user_id'];
	require "check_permissions.php";
	check_admin_permissions($user_id);
}
else {
	exit();
}

require "db_config.php";


################ Continue generating Map XML #################
// Select all the rows in the markers table
$query = sprintf("select COUNT(*) FROM users;");
$result = mysqli_query($dbhandle,$query);
$count_row = mysqli_fetch_assoc($result);
$counts = $count_row['COUNT(*)'];

$query = sprintf("SELECT email,user_id FROM users ORDER BY email;");
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
$node = $dom->createElement("accounts"); //Create new element node
$parnode = $dom->appendChild($node); //make the node show up 
// Iterate through the rows, adding XML nodes for each
while ($row = mysqli_fetch_assoc($result)){
	$node = $dom->createElement("account");
	$newnode = $parnode->appendChild($node);
	$newnode->setAttribute("user_email", $row['email']);
	$newnode->setAttribute("user_id", $row['user_id']);
	$newnode->setAttribute("num_of_users", $counts);	
}

if ($counts == 0) {
	$node = $dom->createElement("account");
	$newnode = $parnode->appendChild($node);
	$newnode->setAttribute("num_of_reports", $counts);
}

echo $dom->saveXML();

mysqli_free_result($result);
mysqli_close($dbhandle);
?>
