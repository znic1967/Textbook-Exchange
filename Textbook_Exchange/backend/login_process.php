<?php
	require_once("ClassUser.php");
	
	$user = new User;

	if ($user->authenticate($_POST['username'],$_POST['password']))
	{
		if (isset($_SESSION['currentURL']))
		{
			$currURL = $_SESSION['currentURL'];
			unset($_SESSION['currentURL']);
			die(header("Location: " . $currURL));
		}
		die(header("Location: ../frontend/authenticated/authenticated_homepage.php"));
	}
?>