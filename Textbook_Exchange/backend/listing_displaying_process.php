<?php
	require_once("ClassUser.php");
	require_once("ClassOrder.php");
	
	$user = new User;		
	if (!$user->isLoggedIn) {
		$_SESSION['currentURL'] = "listing_displaying_process.php";
		die(header("Location: ../frontend/login_required.php"));
	}

	$order = new Order;
	$sale_pending_quantity = count($_SESSION['sale_pending_arr']);

	if ($sale_pending_quantity == 0) {
		die(header("Location: ../frontend/authenticated/listing.php"));
	}
	else {
		die(header("Location: ../frontend/authenticated/manage_listing.php"));
	}
?>