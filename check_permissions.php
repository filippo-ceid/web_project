<?php
if (!isset($user_level)){
	exit();
}
function check_simple_permissions($user_level){
	if ($user_level != "simple"){
		header('Location: index.php');
		exit();
	}
}
function check_admin_permissions($user_level){
	if ($user_level != "admin"){
		header('Location: index.php');
		exit();
	}
}
function check_permissions($user_level){
	if ($user_level != "admin" && $user_level != "simple"){
		header('Location: index.php');
		exit();
	}
}
?>
