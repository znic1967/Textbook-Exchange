<?php
	class Card
	{
		function __construct()
		{
			require("dbstuffs.inc");

			//Creating card Table if not exists one
			$statement = "CREATE TABLE IF NOT EXISTS card ( ";
			$statement .= "userID INT NOT NULL, ";
			$statement .= "card_name VARCHAR(255) NOT NULL, ";
			$statement .= "card_number VARCHAR(255) NOT NULL PRIMARY KEY, ";
			$statement .= "card_exp DATE NOT NULL, ";
			$statement .= "card_cvv INT NOT NULL, ";
			$statement .= "card_address VARCHAR(255) NOT NULL, ";
			$statement .= "card_city VARCHAR(255) NOT NULL, ";
			$statement .= "card_state VARCHAR(2) NOT NULL, ";
			$statement .= "card_zip VARCHAR(10) NOT NULL)";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			} //End Creating card Table if not exists one"			
		} //End __construct

		private function is_card_existed($card_number)
		{
			require("dbstuffs.inc");

			$statement = "SELECT * FROM card WHERE card_number = '$card_number'";

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
		} //End function is_card_existed

		private function user_has_card($userID)
		{
			require("dbstuffs.inc");

			$statement = "SELECT * FROM card WHERE userID = '$userID'";

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
		} //End function user_has_card		

		public function insert($userID, $card_name, $card_number, $card_exp, $card_cvv, $card_address, $card_city, $card_state, $card_zip)
		{
			if (!$this->is_card_existed($card_number))
			{
				require("dbstuffs.inc");

				$card_name 		= mysqli_real_escape_string($db, $card_name);
				$card_number 	= mysqli_real_escape_string($db, $card_number);
				$card_cvv 		= mysqli_real_escape_string($db, $card_cvv);
				$card_address 	= mysqli_real_escape_string($db, $card_address);
				$card_city 		= mysqli_real_escape_string($db, $card_city);
				$card_state 	= mysqli_real_escape_string($db, $card_state);
				$card_zip 		= mysqli_real_escape_string($db, $card_zip);

				$statement = "INSERT INTO card ( ";
				$statement .= "userID, card_name, card_number, card_exp, ";
				$statement .= "card_cvv, card_address, card_city, card_state, card_zip) ";
				$statement .= "VALUES ( ";
				$statement .= "'$userID', '$card_name', '$card_number', '$card_exp', ";
				$statement .= "'$card_cvv', '$card_address', '$card_city', '$card_state', '$card_zip')";

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
				echo "Card Existed!<br><br>";
			}
		} //End function insert

		public function print_all_cards($userID)
		{
			if ($this->user_has_card($userID))
			{
				require("dbstuffs.inc");

				$statement = "SELECT * FROM card WHERE userID = '$userID'";

				$result = mysqli_query($db, $statement);
				if (!$result) {
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}

				$numresults = mysqli_num_rows($result);
				if($numresults == 0)
				{
					echo "Card Not Found!<br>";
					exit;
				}

				$card_arr = array();
				while ($numresults != 0)
				{
					$row = $result->fetch_assoc();

					$card_arr[] = $row;

					$numresults--;
				}

				if (session_id() == '') {
				session_start();
				}

				$_SESSION['card_arr'] = $card_arr;
			}
			else
			{
				die(header("Location: card_required.php"));
			}
		} //End function print_all_cards

		public function get_card($userID, $card_number)
		{
			require("dbstuffs.inc");
			$card_number = mysqli_real_escape_string($db, $card_number);
			
			if ($this->user_has_card($userID))
			{
				require("dbstuffs.inc");

				$statement = "SELECT * FROM card WHERE userID = '$userID' AND card_number = '$card_number'";

				$result = mysqli_query($db, $statement);
				if (!$result) {
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}

				$numresults = mysqli_num_rows($result);
				if($numresults == 0) {
					echo "Card Not Found!<br>";
					exit;
				}
				else {
					$row = $result->fetch_assoc();
					$card = $row;
				}

				if (session_id() == '') {
				session_start();
				}

				$_SESSION['card'] = $card;
			}
			else
			{
				die(header("Location: card_required.php"));
			}
		} //End function print_card
	}
?>