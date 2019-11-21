<?php
	require_once("../backend/ClassUser.php");
	require_once("../backend/ClassBook.php");

	$user = new User;
	if (!$user->isLoggedIn)
	{
		die(header("Location: ../frontend/login_required.php"));
	}

	$book = new Book;

	$sellingID		= $_POST['sellingID'];
	$ex_title		= $_POST['ex_title'];
	$ex_author		= $_POST['ex_author'];
	$ex_genre		= $_POST['ex_genre'];
	$ex_isbn		= $_POST['ex_isbn'];

	$book->insert_exchange($sellingID, $ex_title, $ex_author, $ex_genre, $ex_isbn);
?>