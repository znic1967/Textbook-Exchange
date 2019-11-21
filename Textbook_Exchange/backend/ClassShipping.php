<?php
	class Shipping
	{
		function __construct()
		{
			require("dbstuffs.inc");

			//Creating shipping Table if not exists one
			$statement = "CREATE TABLE IF NOT EXISTS shipping ( ";
			$statement .= "userID INT NOT NULL, ";
			$statement .= "name VARCHAR(255) NOT NULL, ";
			$statement .= "address VARCHAR(255) NOT NULL PRIMARY KEY, ";
			$statement .= "city VARCHAR(255) NOT NULL, ";
			$statement .= "state VARCHAR(2) NOT NULL, ";
			$statement .= "zip VARCHAR(10) NOT NULL, ";
			$statement .= "phone VARCHAR(25) NOT NULL)";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			} //End Creating shipping Table if not exists one"			
		} //End __construct

		private function is_shipping_existed($address)
		{
			require("dbstuffs.inc");

			$address 	= mysqli_real_escape_string($db, $address);

			$statement = "SELECT * FROM shipping WHERE address = '$address'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$numresults = mysqli_num_rows($result);
			if($numresults == 0) {
				return false;
			}
			else {
				return true;
			}			
		} //End function is_shipping_existed

		private function user_has_shipping($userID)
		{
			require("dbstuffs.inc");

			$statement = "SELECT * FROM shipping WHERE userID = '$userID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$numresults = mysqli_num_rows($result);
			if($numresults == 0) {
				return false;
			}
			else {
				return true;
			}			
		} //End function user_has_shipping		

		public function insert($userID, $name, $address, $city, $state, $zip, $phone)
		{
			if (!$this->is_shipping_existed($address))
			{
				require("dbstuffs.inc");

				$name 		= mysqli_real_escape_string($db, $name);
				$address 	= mysqli_real_escape_string($db, $address);
				$city 		= mysqli_real_escape_string($db, $city);
				$state 		= mysqli_real_escape_string($db, $state);
				$zip 		= mysqli_real_escape_string($db, $zip);
				$phone 		= mysqli_real_escape_string($db, $phone);

				$statement = "INSERT INTO shipping ( ";
				$statement .= "userID, name, address, city, state, zip, phone) ";
				$statement .= "VALUES ( ";
				$statement .= "'$userID', '$name', '$address', '$city', '$state', '$zip', '$phone')";

				$result = mysqli_query($db, $statement);
				if (!$result) {
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}
				
				$currURL = $_SESSION['currentURL'];
				unset($_SESSION['currentURL']);
				die(header("Location: " . $currURL));
			}
			else {
				echo "Shipping Address Existed!<br><br>";
			}
		} //End function insert

		private function insert_primary_shipping($userID)
		{
			require("dbstuffs.inc");

			$statement = "SELECT * FROM users WHERE userID = '$userID'";

			$result = mysqli_query($db, $statement);
			if (!$result) {
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$numresults = mysqli_num_rows($result);
			if($numresults == 0)
			{
				echo "Shipping Not Found!<br>";
				exit;
			}

			$row = $result->fetch_assoc();

			$name		= $row['firstname'] . " " . $row['lastname'];
			$address 	= $row['address'];
			$city 		= $row['city'];
			$state 		= $row['state'];
			$zip 		= $row['zip'];
			$phone 		= $row['phone'];

			$name 		= mysqli_real_escape_string($db, $name);
			$address 	= mysqli_real_escape_string($db, $address);
			$city 		= mysqli_real_escape_string($db, $city);
			$state 		= mysqli_real_escape_string($db, $state);
			$zip 		= mysqli_real_escape_string($db, $zip);
			$phone 		= mysqli_real_escape_string($db, $phone);

			$statement = "INSERT INTO shipping ( ";
			$statement .= "userID, name, address, city, state, zip, phone) ";
			$statement .= "VALUES ( ";
			$statement .= "'$userID', '$name', '$address', '$city', '$state', '$zip', '$phone')";

			$result = mysqli_query($db, $statement);
			if (!$result) {
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}
		} // End function get_primary_shipping

		public function print_all_shipping($userID)
		{
			if (!$this->user_has_shipping($userID))
			{
				$this->insert_primary_shipping($userID);
			}

			if ($this->user_has_shipping($userID))
			{
				require("dbstuffs.inc");

				$statement = "SELECT * FROM shipping WHERE userID = '$userID'";

				$result = mysqli_query($db, $statement);
				if (!$result) {
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}

				$numresults = mysqli_num_rows($result);
				if($numresults == 0)
				{
					echo "Shipping Not Found!<br>";
					exit;
				}

				$shipping_arr = array();
				while ($numresults != 0)
				{
					$row = $result->fetch_assoc();

					$shipping_arr[] = $row;

					$numresults--;
				}

				if (session_id() == '') {
				session_start();
				}

				$_SESSION['shipping_arr'] = $shipping_arr;
			}			
		} //End function print_all_shipping

		public function get_shipping($userID, $address)
		{
			if (!$this->user_has_shipping($userID))
			{
				$this->insert_primary_shipping($userID);
			}

			if ($this->is_shipping_existed($address))
			{
				require("dbstuffs.inc");
				$address = mysqli_real_escape_string($db, $address);

				$statement = "SELECT * FROM shipping WHERE userID = '$userID' AND address = '$address'";

				$result = mysqli_query($db, $statement);
				if (!$result) {
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}

				$numresults = mysqli_num_rows($result);
				if($numresults == 0) {
					echo "Shipping Not Found!<br>";
					exit;
				}
				else {
					$row = $result->fetch_assoc();
					$shipping = $row;
				}

				if (session_id() == '') {
				session_start();
				}

				$_SESSION['shipping'] = $shipping;
			}
			else {
				//Should insert the $addressIN into DB
				echo "Shipping Address Not Existed!<br>";
			}
		} //End function print_shipping
	}
?>