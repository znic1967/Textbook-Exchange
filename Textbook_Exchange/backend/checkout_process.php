<?php
	require_once("ClassUser.php");
	require_once("ClassCart.php");
	require_once("ClassBook.php");

	if (session_id() == '') {
		session_start();
	}  

	$user = new User;
	if (!$user->isLoggedIn) {
		die(header("Location: ../frontend/login_required.php"));
	}

	$cart = new Cart;
	if ($cart->is_empty()) {
		die(header("Location: cart_empty.php"));
	}

	$item_arr = $_SESSION['item_arr'];

	$book = new Book;
	$book->get_onsale_books();
	$onsale_books_arr = $_SESSION['onsale_books_arr'];

	$exchange_item_arr = array();
	$listing_for_exchange = array();
	$pickup_item_arr = array();
	$shipping_item_arr = array();

	for ($i = 0; $i < count($item_arr); $i++)
	{
		if ($item_arr[$i]['exmethod'] == "local") {
			$pickup_item_arr[] = $item_arr[$i];
		}
		else {
			$shipping_item_arr[] = $item_arr[$i];
		}
	}

	for ($i = 0; $i < count($pickup_item_arr); $i++)
	{
		$found = 0;
		if ($pickup_item_arr[$i]['accept_exchange'] == "Yes")
		{
			for ($j = 0; $j < count($onsale_books_arr); $j++)
			{
				if (($pickup_item_arr[$i]['exchange_title'] == $onsale_books_arr[$j]['title']) || ($pickup_item_arr[$i]['exchange_isbn'] == $onsale_books_arr[$j]['isbn']))
				{
					$listing_for_exchange[] = $onsale_books_arr[$j];
					$exchange_item_arr[] = $pickup_item_arr[$i];
					$found = 1;
				}
			}			
		}
		if ($found == 1)
		{
			$lnx = count($pickup_item_arr) - 1;
			$pickup_item_arr[$i] = $pickup_item_arr[$lnx];
			unset($pickup_item_arr[$lnx]);
			$i--;
		}
	}
/*
	echo "PICKUP ITEMS:<br>";
	echo "Size: " . count($pickup_item_arr) . "<br>";
	for ($i = 0; $i < count($pickup_item_arr); $i++)
	{
		echo "Index " . $i . "<br>";
		echo $pickup_item_arr[$i]['title'] . "<br>";		
	}

	echo "<br><br>";

	echo "EXCHANGE ITEMS:<br>";
	echo "Size: " . count($exchange_item_arr) . "<br>";
	for ($i = 0; $i < count($exchange_item_arr); $i++)
	{
		echo "Index " . $i . "<br>";
		echo $exchange_item_arr[$i]['title'] . "<br>";

	}

	echo "<br><br>";

	echo "LISTING FOR EXCHANGE ITEMS:<br>";
	echo "Size: " . count($listing_for_exchange) . "<br>";
	for ($i = 0; $i < count($listing_for_exchange); $i++)
	{
		echo "Index " . $i . "<br>";
		echo $listing_for_exchange[$i]['title'] . "<br>";
		echo $listing_for_exchange[$i]['seller'] . "<br>";
		echo $listing_for_exchange[$i]['price'] . "<br>";
	}
	
	echo "<br><br>";
*/

	$_SESSION['pickup_item_arr'] = $pickup_item_arr;
	$_SESSION['exchange_item_arr'] = $exchange_item_arr;
	$_SESSION['listing_for_exchange'] = $listing_for_exchange;
	$_SESSION['shipping_item_arr'] = $shipping_item_arr;

	die(header("Location: ../frontend/authenticated/checkout.php"))

?>