<?php
	require_once("ClassUser.php");
	require_once("ClassShipping.php");
	require_once("ClassCard.php");
	require_once("ClassOrder.php");
	require_once("ClassCart.php");
	require_once("ClassBook.php");

	if (session_id() == '') {
		session_start();
	}

	$user = new User;
	if (!$user->isLoggedIn) {
		die(header("Location: ../login_required.php"));
	}
	$userID = $_SESSION['userID'];

	if (count($shipping_item_arr) != 0)
	{

	}
	$book = new Book;
	$order = new Order;

	$pickup_item_arr = $_SESSION['pickup_item_arr'];
	$shipping_item_arr = $_SESSION['shipping_item_arr'];
	$exchange_item_arr = $_SESSION['exchange_item_arr'];
	$listing_for_exchange = $_SESSION['listing_for_exchange'];

	if (count($exchange_item_arr) != 0)
	{
		$order->insert_exchange_items($userID, $exchange_item_arr, $listing_for_exchange);

		for ($i = 0; $i < count($listing_for_exchange); $i++)
		{
			$sellingID = $listing_for_exchange[$i]['sellingID'];
			$book->deleting_a_listing($sellingID);
		}
	}

	if (count($pickup_item_arr) != 0)
	{
		$order->insert_pickup_items($userID, $pickup_item_arr);
	}	

	if (count($shipping_item_arr) != 0)
	{
		
		$shipping = new Shipping;
		$shipping_arr = $_SESSION['shipping_arr'];
		$index = $_POST['selected_address'];
		$address = $shipping_arr[$index]['address'];
		$shipping->get_shipping($userID, $address);

		$card = new Card;
		$card_number = $_POST['selected_card_number'];
		$card->get_card($userID, $card_number);

		$selected_shipping	= $_SESSION['shipping'];
		$selected_card 		= $_SESSION['card'];

		$order->insert_shipping_items($userID, $shipping_item_arr, $selected_shipping, $selected_card);
	}

	$cart = new Cart;
	$cart->delete_all($userID);

	if (isset($_SESSION['recent_orderID_arr'])) {
		$recent_orderID_arr = $_SESSION['recent_orderID_arr'];
		unset($_SESSION['recent_orderID_arr']);

		$order->get_recent_orders($recent_orderID_arr);
	}
	else {
		die(header("Location: authenticated_homepage.php"));
	}	

	die(header("Location: ../frontend/authenticated/order_confirmation.php"));
?>