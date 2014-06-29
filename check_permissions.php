<?php

//περιέχει συναρτήσεις που βρίσκουν το user level 

if (!isset($user_id)){
	header('Location: index.php');
	exit();
}
function check_simple_permissions($user_id){
	require "db_config.php";
	$query = "SELECT user_level FROM users WHERE user_id = $user_id;";
	$result = mysqli_query($dbhandle,$query);
	$row = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	mysqli_close($dbhandle);
	$user_level = $row['user_level'];
	if ($user_level != "simple"){
		$_SESSION = array(); // Destroy the variables.
		session_destroy(); // Destroy the session itself.
		setcookie (session_name(), '', time()-300); // Destroy the cookie.
		header('Location: index.php');
		exit();
	}
}
function check_admin_permissions($user_id){
		require "db_config.php";
		$query = "SELECT user_level FROM users WHERE user_id = $user_id;";
		$result = mysqli_query($dbhandle,$query);
		$row = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		mysqli_close($dbhandle);
		$user_level = $row['user_level'];
		if ($user_level != "admin"){
			$_SESSION = array(); // Destroy the variables.
			session_destroy(); // Destroy the session itself.
			setcookie (session_name(), '', time()-300); // Destroy the cookie.
			header('Location: index.php');
			exit();
		}
}
function check_permissions($user_id){
	require "db_config.php";
	$query = "SELECT user_level FROM users WHERE user_id = $user_id;";
	$result = mysqli_query($dbhandle,$query);
	$row = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	mysqli_close($dbhandle);
	$user_level = $row['user_level'];
	if ($user_level != "admin" && $user_level != "simple"){
		header('Location: index.php');
		exit();
	}
}
?>
