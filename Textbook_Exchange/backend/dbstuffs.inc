<?php
	//Connect to the Database
	$host = 'localhost';
	$user = 'admin';
	$pwd = 'admin';
	$dbname = 'TxtExDB';

	$db = mysqli_connect($host, $user, $pwd, $dbname);

	//Check if Database is connected
	if(!$db)
	{
		print "<p><br>Unable to Connect to Database</p>";
		exit;
	}
?>