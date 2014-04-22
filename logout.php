<?php
	// Start output buffering:
	ob_start();
	// Initialize a session:
	session_start();
	$_SESSION = array(); // Destroy the variables.
	session_destroy(); // Destroy the session itself.
	setcookie (session_name(), '', time()-300); // Destroy the cookie.
	header("Location: index.php");
	exit(); // Quit the script.
?>
