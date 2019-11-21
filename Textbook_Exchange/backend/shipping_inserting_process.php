<?php
	require_once("../backend/ClassUser.php");
	require_once("../backend/ClassShipping.php");

	$user = new User;
	if (!$user->isLoggedIn)
	{
		die(header("Location: ../frontend/login_required.php"));
	}

	$shipping = new Shipping;
	$userID			= $_SESSION['userID'];
	$name 			= $_POST['name'];
	$address		= $_POST['address'];
	$city			= $_POST['city'];
	$state			= $_POST['state'];
	$zip			= $_POST['zip'];
	$phone			= $_POST['phone'];




	$shipping->insert($userID, $name, $address, $city, $state, $zip, $phone);
?>
