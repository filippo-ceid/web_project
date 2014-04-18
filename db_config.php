<?php

	DEFINE ('DB_USER', 'root');
	DEFINE ('DB_PASSWORD', '123456');
	DEFINE ('DB_HOST', 'localhost');
	DEFINE ('DB_NAME', 'FMC_DB');

	// Make the connection:
	$dbhandle = mysql_connect (DB_HOST, DB_USER, DB_PASSWORD);

	if (!$dbhandle) {
		trigger_error ('Could not connect to MySQL: ' . mysql_connect_error() );
	}
?>
