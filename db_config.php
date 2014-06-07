<?php
	$DB_USER = 'root';
	$DB_PASSWORD =  '123456';
	$DB_HOST =  'localhost';
	$DB_NAME = 'FMC_DB';

	// Make the connection:
	$dbhandle = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD,$DB_NAME) or die("Failed to connect to MySQL: " . mysql_error());
	
	mysqli_query($dbhandle,"SET CHARACTER SET utf8") or die(mysql_error());
?>
