<?php
	require("dbstuffs.inc");

	/************************ FOR USER TABLE ********************************/
	//Creating users Table if not exists one
	$statement = "CREATE TABLE IF NOT EXISTS users ( ";
	$statement .= "userID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ";
	$statement .= "firstname VARCHAR(255) NOT NULL, ";
	$statement .= "lastname VARCHAR(255) NOT NULL, ";
	$statement .= "email VARCHAR(255) NOT NULL, ";
	$statement .= "username VARCHAR(255) NOT NULL, ";
	$statement .= "password VARCHAR(255) NOT NULL, ";
	$statement .= "address VARCHAR(255) NOT NULL, ";
	$statement .= "city VARCHAR(255) NOT NULL, ";
	$statement .= "state VARCHAR(2) NOT NULL, ";
	$statement .= "zip VARCHAR(10) NOT NULL, ";
	$statement .= "location VARCHAR(255) NOT NULL, ";
	$statement .= "phone VARCHAR(25) NOT NULL)";

	$result = mysqli_query($db, $statement);
	if (!$result)
	{
		printf ("<br>Error (%s)", mysqli_error($db));
		print "<br>Error with MySQL";
		exit;
	} //End Creating users Table if not exists one"

	if (session_id() == '') {
		session_start();
	}

	//Inserting User's Info to users Table
	$firstnameIN	= mysqli_real_escape_string($db, $_POST['firstname']);
	$lastnameIN		= mysqli_real_escape_string($db, $_POST['lastname']);
	$emailIN		= mysqli_real_escape_string($db, $_POST['email']);
	$usernameIN		= mysqli_real_escape_string($db, $_POST['username']);
	$passwordIN		= mysqli_real_escape_string($db, $_POST['password']);
	$addressIN		= mysqli_real_escape_string($db, $_POST['address']);
	$cityIN			= mysqli_real_escape_string($db, $_POST['city']);
	$stateIN		= mysqli_real_escape_string($db, $_POST['state']);
	$zipIN			= mysqli_real_escape_string($db, $_POST['zip']);
	$locationIN		= $cityIN . ", " . $stateIN . ", " . $zipIN;
	$phoneIN		= mysqli_real_escape_string($db, $_POST['phone']);

	if (empty($firstnameIN) || empty($lastnameIN) || empty($emailIN) || empty($usernameIN) || empty($passwordIN) || empty($addressIN) || empty($cityIN) || empty($stateIN) || empty($zipIN) || empty($phoneIN))
	{
		die(header("Location: ../frontend/signup_failed_fields_required.html"));
	}

	//================= CHECK FOR DUPLICATED EMAIL ===================
	$statement = "SELECT * FROM users WHERE email = '$emailIN'";

	$result = mysqli_query($db, $statement);
	if (!$result)
	{
		printf ("<br>Error (%s)", mysqli_error($db));
		print "<br>Error with MySQL";
		exit;
	}

	$numresults = mysqli_num_rows($result);
	if($numresults != 0) {
		$_SESSION['dup_email'] = 1;
		//die(header("Location: ../frontend/signup.php"));
		die(header("Location: ../frontend/signup_failed_duplicated_email.html"));
	}
	//================= CHECK FOR DUPLICATED EMAIL ===================

	//================= CHECK FOR DUPLICATED USERNAME =================
	$statement = "SELECT * FROM users WHERE username = '$usernameIN'";

	$result = mysqli_query($db, $statement);
	if (!$result)
	{
		printf ("<br>Error (%s)", mysqli_error($db));
		print "<br>Error with MySQL";
		exit;
	}

	$numresults = mysqli_num_rows($result);
	if($numresults != 0) {
		$_SESSION['dup_username'] = 1;
		//die(header("Location: ../frontend/signup.php"));
		die(header("Location: ../frontend/signup_failed_duplicated_username.html"));
	}
	//================= CHECK FOR DUPLICATED USERNAME =================



	$statement = "INSERT INTO users ( ";
	$statement .= "firstname, lastname, email, username, ";
	$statement .= "password, address, city, state, zip, location, phone) ";
	$statement .= "VALUES ( ";
	$statement .= "'$firstnameIN', '$lastnameIN', '$emailIN', '$usernameIN', ";
	$statement .= "'$passwordIN', '$addressIN', '$cityIN', '$stateIN', '$zipIN', '$locationIN', '$phoneIN')";

	$result = mysqli_query($db, $statement);
	if (!$result)
	{
		printf ("<br>Error (%s)", mysqli_error($db));
		print "<br>Error with MySQL";
		exit;
	} //End Inserting User's Info to users table
	/********************** END FOR USER TABLE ******************************/

	/************************ FOR CART TABLE ********************************/
	//Creating cart Table if not exists one
	$statement = "CREATE TABLE IF NOT EXISTS cart ( ";
	$statement .= "buyerID INT NOT NULL PRIMARY KEY, ";
	$statement .= "cart_quantity INT NOT NULL DEFAULT '0', ";
	$statement .= "item1 INT NULL, ";
	$statement .= "item2 INT NULL, ";
	$statement .= "item3 INT NULL, ";
	$statement .= "item4 INT NULL, ";
	$statement .= "item5 INT NULL, ";
	$statement .= "item6 INT NULL, ";
	$statement .= "item7 INT NULL, ";
	$statement .= "item8 INT NULL, ";
	$statement .= "item9 INT NULL, ";
	$statement .= "item10 INT NULL)";

	$result = mysqli_query($db, $statement);
	if (!$result)
	{
		printf ("<br>Error (%s)", mysqli_error($db));
		print "<br>Error with MySQL";
		exit;
	} //End Creating cart Table if not exists one"

	//Initializing the cart for this specific user (userID = buyerID)
	$statement = "SELECT * FROM users WHERE email='$emailIN'";

	$result = mysqli_query($db, $statement);
	if (!$result)
	{
		printf ("<br>Error (%s)", mysqli_error($db));
		print "<br>Error with MySQL";
		exit;
	}

	$numresults = mysqli_num_rows($result);
	if($numresults == 0)
	{
		die("Email Not Found!<br>");
	}
	
	$row = $result->fetch_assoc();
	$buyerID = $row['userID'];

	$statement = "INSERT INTO cart (buyerID) VALUES ('$buyerID')";

	$result = mysqli_query($db, $statement);
	if (!$result)
	{
		printf ("<br>Error (%s)", mysqli_error($db));
		print "<br>Error with MySQL";
		exit;
	}
	//End Initializing the cart
	/********************** END FOR CART TABLE ******************************/

	die(header("Location: ../frontend/signup_complete.html"));
?>