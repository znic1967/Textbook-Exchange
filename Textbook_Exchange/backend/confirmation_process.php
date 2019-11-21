<?php
	require_once("ClassUser.php");
	require_once("ClassOrder.php");

	if (session_id() == '') {
		session_start();
	}

	$user = new User;
	if (!$user->isLoggedIn) {
		die(header("Location: ../login_required.php"));
	}

	$order = new Order;
	$orderID = $_POST['orderID'];

	$order->status_updating($orderID);

	die(header("Location: ../frontend/authenticated/selling_confirmation.php"));
?>