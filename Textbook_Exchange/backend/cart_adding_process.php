<?php
	if (session_id() == "")
	{
		session_start();
	}

	require_once("ClassUser.php");
	require_once("ClassCart.php");

	$user = new User;
	if (!$user->isLoggedIn)
	{
		die(header("Location: ../frontend/login_required.php"));
	}

	//Send these 2 variables to the Cart table
	$buyerID	= $_SESSION['userID'];
	$sellingID	= $_POST['sellingID'];

	$cart = new Cart;
	$cart->add_an_item($buyerID, $sellingID);
?>