<?php
	require_once("ClassUser.php");
	require_once("ClassCart.php");
	
	$user = new User;		
	if (!$user->isLoggedIn) {
		$_SESSION['currentURL'] = "cart_displaying_process.php";
		die(header("Location: ../frontend/login_required.php"));
	}

	$cart = new Cart;
	$buyerID = $_SESSION['userID'];

	if ($cart->is_empty()) {
		die(header("Location: ../frontend/authenticated/cart_empty.php"));
	}
	else {
		$cart->cart_displaying();
	}
?>