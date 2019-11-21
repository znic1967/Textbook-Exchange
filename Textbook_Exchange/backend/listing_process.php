<?php
	require_once("../backend/ClassUser.php");
	require_once("../backend/ClassBook.php");

	$user = new User;
	if (!$user->isLoggedIn)
	{
		die(header("Location: ../frontend/login_required.php"));
	}

	$book = new Book;
	$sellerID_IN	= $_SESSION['userID'];
	$seller_IN		= $_SESSION['firstname'] . " " . $_SESSION['lastname'];
	$title_IN		= $_POST['title'];
	$author_IN		= $_POST['author'];
	$genre_IN		= $_POST['genre'];
	$isbn_IN		= $_POST['isbn'];
	$description_IN	= $_POST['description'];
	$condi_IN		= $_POST['condi'];
	$location_IN	= $_SESSION['location'];
	$exmethod_IN	= $_POST['exmethod'];
	$price_IN		= $_POST['price'];
	
	$book->insert($sellerID_IN, $seller_IN, $title_IN, $author_IN, $genre_IN, $isbn_IN, $description_IN, $condi_IN, $location_IN, $exmethod_IN, $price_IN);
?>