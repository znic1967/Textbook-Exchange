<?php
	require_once("../backend/ClassUser.php");
	require_once("../backend/ClassCard.php");

	$user = new User;
	if (!$user->isLoggedIn)
	{
		die(header("Location: ../frontend/login_required.php"));
	}

	$card = new Card;
	$userID			= $_SESSION['userID'];
	$card_name		= $_POST['card_name'];
	$card_number	= $_POST['card_number'];
	$card_exp		= $_POST['card_exp'];
	$card_cvv		= $_POST['card_cvv'];
	$card_address	= $_POST['card_address'];
	$card_city		= $_POST['card_city'];
	$card_state		= $_POST['card_state'];
	$card_zip		= $_POST['card_zip'];

	$card->insert($userID, $card_name, $card_number, $card_exp, $card_cvv, $card_address, $card_city, $card_state, $card_zip);
?>