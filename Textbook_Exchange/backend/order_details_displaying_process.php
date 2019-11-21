<?php
	require_once("ClassUser.php");
	require_once("ClassOrder.php");
	
	$user = new User;		
	if (!$user->isLoggedIn) {
		$_SESSION['currentURL'] = "order_details_displaying_process.php";
		die(header("Location: ../frontend/login_required.php"));
	}

	$order = new Order;
	$orderID = $_POST['orderID'];

	$order->get_order_details($orderID);

	die(header("Location: ../frontend/authenticated/order_details.php"));
?>