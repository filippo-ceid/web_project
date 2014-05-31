<?php
	DEFINE ('DB_USER', 'root');
	DEFINE ('DB_PASSWORD', '123456');
	DEFINE ('DB_HOST', 'localhost');
	DEFINE ('DB_NAME', 'FMC_DB');
	DEFINE ('SITE_NAME','FixMyCity');
	DEFINE ('BASE_URL', 'http://www.fixmycity.gr/');
	DEFINE ('ADM_EMAIL', '');

	// Make the connection:
	$dbhandle = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME) or die("Failed to connect to MySQL: " . mysql_error());
	
	mysqli_query($dbhandle,"SET CHARACTER SET utf8") or die(mysql_error());
?>
