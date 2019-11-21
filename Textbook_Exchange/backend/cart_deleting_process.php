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

	$buyerID		= $_SESSION['userID'];
	$item_number	= $_POST['item_number'];
	$itemColumn 	= 'item' . $item_number;

	$cart = new Cart;
	$cart->delete_an_item($buyerID, $item_number, $itemColumn);
	
	die(header("Location: cart_displaying_process.php"));
?>