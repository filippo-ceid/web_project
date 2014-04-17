<?php
    ob_start(); //??
    session_start(); //??
    
    $dbuser = "root";
	$dbpass = "k7YyhctN";
	$hostname = "localhost";
	$dbname = "FMC_DB";

	//connection to the database
	$dbhandle = mysql_connect($hostname, $dbuser, $dbpass);
	
	if (!$dbhandle) {
	   die('Could not connect: ' . mysql_error());
	}

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    //select a database to work with
	$selected = mysql_select_db($dbname,$dbhandle)
	  or die("Could not select $dbname");
	
	$email = mysql_real_escape_string($email);  
	$query = "SELECT email, password, user_type
    FROM users
    WHERE email = '$email';";

	//execute the SQL query and return records
	$result = mysql_query($query, $dbhandle);

    if(mysql_num_rows($result) != 0) // User not found.
    {
		$userData = mysql_fetch_array($result, MYSQL_ASSOC);
		if($password != $userData['password']) // Incorrect password.
		{
			header('Location: login.php');
		}
		else{ // Redirect to home page after successful login.
			session_regenerate_id();
			$_SESSION['sess_user_id'] = $userData['id'];
			$_SESSION['sess_email'] = $userData['email'];
			session_write_close();
			header('Location: index.php');
		}
    }
    else{
		header('Location: registration.php');
    }

    //close the connection
	mysqli_close($dbhandle);
?>
