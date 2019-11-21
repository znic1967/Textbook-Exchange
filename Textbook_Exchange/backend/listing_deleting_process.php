<?php
	require("ClassUser.php");
	require("ClassBook.php");

	$user = new User;
	if (!$user->isLoggedIn)
	{
		die(header("Location: ../frontend/login_required.php"));
	}

	$book = new Book;
	$sellingID = $_POST['sellingID'];

	$book->deleting_a_listing($sellingID);

	die(header("Location: ../frontend/authenticated/listing_deleting_complete.php"));
?>