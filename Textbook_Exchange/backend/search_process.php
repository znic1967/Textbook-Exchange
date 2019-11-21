<?php
	require_once("../backend/ClassBook.php");

	$book = new Book;

	$keyword_IN = $_POST['keyword'];

	$book->search($keyword_IN);
?>