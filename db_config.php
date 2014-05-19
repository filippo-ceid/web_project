<?php
	DEFINE ('DB_USER', 'root');
	DEFINE ('DB_PASSWORD', '123456');
	DEFINE ('DB_HOST', 'localhost');
	DEFINE ('DB_NAME', 'FMC_DB');
	DEFINE ('SITE_NAME','FixMyCity');
	DEFINE ('BASE_URL', 'http://www.fixmycity.gr/');
	DEFINE ('ADM_EMAIL', '');

	// Make the connection:
	$dbhandle = mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
	
	mysql_select_db(DB_NAME,$dbhandle) or die("Could not select " . DB_NAME);
	
	mysql_query('SET CHARACTER SET utf8') or die(mysql_error());
?>
