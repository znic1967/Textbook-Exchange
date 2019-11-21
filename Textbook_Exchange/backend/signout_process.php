<?php
	require_once("ClassUser.php");

	$user = new User;

	$user->signout();
	
	die(header("Location: ../homepage.php"));
?>