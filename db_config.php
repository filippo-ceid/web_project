<?php
	$DB_USER = 'root';	//mysql user
	$DB_PASSWORD = '123456'; //mysql password
	$DB_HOST = 'localhost'; //<server_ip>:<mysql_port>
	$DB_NAME = 'FMC_DB'; //mysql database
	$PHP_HOST = 'localhost'; //<server_ip>:<php_port>

	// Make the connection:
	$dbhandle = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD,$DB_NAME) or die("Failed to connect to MySQL: " . mysql_error());
	
	mysqli_query($dbhandle,"SET CHARACTER SET utf8") or die(mysql_error());
?>
