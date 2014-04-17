<?php
    require "db_config.php";

	//connection to the database
	$dbhandle = mysql_connect($hostname, $dbuser, $dbpass);
	
	if (!$dbhandle) {
	   die('Could not connect: ' . mysql_error());
	}

	if(isset($_POST['submit'])){
		
		//select a database to work with
		mysql_select_db($dbname,$dbhandle)
			or die("Could not select $dbname");
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		
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
	}
		//close the connection
		mysql_close($dbhandle);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FixMyCity - Δήμος Ι.Π. Μεσολογγίου</title>
<meta name="keywords" content="Dimos Mesologgiou, FixMyCity, Provlimata" />
<meta name="description" content="Login page of FixMyCity.gr for users and administrators." />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
	<div id="header_panel">
    	<div id="site_title">
        	FixMyCity
        </div>
    </div>
    
    <div id="menu">
    	<ul>
            <li><a href="index.php">Αρχική</a></li>
            <li><a href="login.php" class="current">Είσοδος</a></li>
            <li><a href="registration.php">Εγγραφή</a></li>
            <li><a href="contact.php">Επικοινωνία</a></li>
        </ul>
    
    </div> <!-- end of menu -->
    
    <div id="top_panel">
		<div class="login_field">
			<form action="login.php" method="POST">
				Email<br>
				<input type="text" name="email" /><br>
				<br>Password<br>
				<input type="password" name="password" /><br>
				<br>
				<input type="submit" name="submit" value="Login" />
			</form>
		</div>
    </div> <!-- end of top panel -->
    
	<div id="footer">    
    	Copyright © 2014 <a href="http://www.messolonghi.gr/"><strong>Δήμος Ι.Π. Μεσολογγίου</strong></a>
	</div> <!-- end of footer -->
</div> <!-- end of container -->
</html>
