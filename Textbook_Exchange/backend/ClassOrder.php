<?php
	class Order
	{
		private $order_history_arr = array();

		function __construct()
		{
			require("dbstuffs.inc");

			//Creating order Table if not exists one
			$statement = "CREATE TABLE IF NOT EXISTS `order` ( ";

			// ==================== ORDER INFO ====================
			$statement .= "orderID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ";
			$statement .= "exmethod VARCHAR(255) NOT NULL, ";
			$statement .= "status VARCHAR(255) NOT NULL, ";
			$statement .= "date_of_order DATE NOT NULL, ";
			$statement .= "time_of_order TIME NOT NULL, ";
			$statement .= "order_quantity INT NOT NULL DEFAULT '0', ";
			$statement .= "order_subtotal DOUBLE NOT NULL DEFAULT '0', ";
			// ====================================================

			// ==================== BUYER INFO ====================
			$statement .= "buyerID INT NOT NULL, ";
			$statement .= "buyer_name VARCHAR(255) NOT NULL, ";
			$statement .= "buyer_email VARCHAR(255) NOT NULL, ";
			$statement .= "buyer_phone VARCHAR(25) NOT NULL, ";

			$statement .= "shipping_name VARCHAR(255) NULL, ";
			$statement .= "shipping_address VARCHAR(255) NULL, ";
			$statement .= "shipping_city VARCHAR(255) NULL, ";
			$statement .= "shipping_state VARCHAR(2) NULL, ";
			$statement .= "shipping_zip VARCHAR(10) NULL, ";
			$statement .= "shipping_phone VARCHAR(25) NULL, ";

			$statement .= "card_name VARCHAR(255) NULL, ";
			$statement .= "card_number VARCHAR(255) NULL, ";
			$statement .= "card_exp DATE NULL, ";
			$statement .= "card_cvv INT NULL, ";
			$statement .= "card_address VARCHAR(255) NULL, ";
			$statement .= "card_city VARCHAR(255) NULL, ";
			$statement .= "card_state VARCHAR(2) NULL, ";
			$statement .= "card_zip VARCHAR(10) NULL, ";
			// ====================================================

			// ==================== SELLER INFO ====================
			$statement .= "sellerID INT NOT NULL, ";
			$statement .= "seller_name VARCHAR(255) NOT NULL, ";
			$statement .= "seller_email VARCHAR(255) NOT NULL, ";
			$statement .= "seller_phone VARCHAR(25) NOT NULL, ";
			$statement .= "seller_address VARCHAR(255) NOT NULL, ";	
			$statement .= "seller_city VARCHAR(255) NOT NULL, ";
			$statement .= "seller_state VARCHAR(2) NOT NULL, ";
			$statement .= "seller_zip VARCHAR(10) NOT NULL, ";
			// =====================================================

			// ==================== ITEM_1 INFO ====================
			$statement .= "title_item1 VARCHAR(255) NULL, ";
			$statement .= "author_item1 VARCHAR(255) NULL, ";
			$statement .= "genre_item1 VARCHAR(255) NULL, ";
			$statement .= "isbn_item1 VARCHAR(255) NULL, ";
			$statement .= "description_item1 VARCHAR(255) NULL, ";
			$statement .= "condi_item1 VARCHAR(255) NULL, ";
			$statement .= "price_item1 DOUBLE NULL, ";
			// =====================================================

			// ==================== ITEM_2 INFO ====================
			$statement .= "title_item2 VARCHAR(255) NULL, ";
			$statement .= "author_item2 VARCHAR(255) NULL, ";
			$statement .= "genre_item2 VARCHAR(255) NULL, ";
			$statement .= "isbn_item2 VARCHAR(255) NULL, ";
			$statement .= "description_item2 VARCHAR(255) NULL, ";
			$statement .= "condi_item2 VARCHAR(255) NULL, ";
			$statement .= "price_item2 DOUBLE NULL, ";
			// =====================================================			
			// ==================== ITEM_3 INFO ====================
			$statement .= "title_item3 VARCHAR(255) NULL, ";
			$statement .= "author_item3 VARCHAR(255) NULL, ";
			$statement .= "genre_item3 VARCHAR(255) NULL, ";
			$statement .= "isbn_item3 VARCHAR(255) NULL, ";
			$statement .= "description_item3 VARCHAR(255) NULL, ";
			$statement .= "condi_item3 VARCHAR(255) NULL, ";
			$statement .= "price_item3 DOUBLE NULL, ";
			// =====================================================

			// ==================== ITEM_4 INFO ====================
			$statement .= "title_item4 VARCHAR(255) NULL, ";
			$statement .= "author_item4 VARCHAR(255) NULL, ";
			$statement .= "genre_item4 VARCHAR(255) NULL, ";
			$statement .= "isbn_item4 VARCHAR(255) NULL, ";
			$statement .= "description_item4 VARCHAR(255) NULL, ";
			$statement .= "condi_item4 VARCHAR(255) NULL, ";
			$statement .= "price_item4 DOUBLE NULL, ";
			// =====================================================

			// ==================== ITEM_5 INFO ====================
			$statement .= "title_item5 VARCHAR(255) NULL, ";
			$statement .= "author_item5 VARCHAR(255) NULL, ";
			$statement .= "genre_item5 VARCHAR(255) NULL, ";
			$statement .= "isbn_item5 VARCHAR(255) NULL, ";
			$statement .= "description_item5 VARCHAR(255) NULL, ";
			$statement .= "condi_item5 VARCHAR(255) NULL, ";
			$statement .= "price_item5 DOUBLE NULL)";
			// =====================================================

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			} //End Creating order Table if not exists one"

//=============== NEW IMPLEMENTATION ============================
			$statement = "SELECT * FROM `order` WHERE ex_title_item1";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				$errNo = mysqli_errno($db);
				$errMes = mysqli_error($db);

				if ($errNo == 1054)
				{
					$add_statement = "ALTER TABLE `order` ADD ";
					$add_statement .= "(ex_title_item1 VARCHAR(255) NULL, ";
					$add_statement .= "ex_author_item1 VARCHAR(255) NULL, ";
					$add_statement .= "ex_genre_item1 VARCHAR(255) NULL, ";
					$add_statement .= "ex_isbn_item1 VARCHAR(255) NULL, ";
					$add_statement .= "ex_description_item1 VARCHAR(255) NULL, ";
					$add_statement .= "ex_condi_item1 VARCHAR(255) NULL, ";
					$add_statement .= "ex_price_item1 VARCHAR(255) NULL, ";

					$add_statement .= "ex_title_item2 VARCHAR(255) NULL, ";
					$add_statement .= "ex_author_item2 VARCHAR(255) NULL, ";
					$add_statement .= "ex_genre_item2 VARCHAR(255) NULL, ";
					$add_statement .= "ex_isbn_item2 VARCHAR(255) NULL, ";
					$add_statement .= "ex_description_item2 VARCHAR(255) NULL, ";
					$add_statement .= "ex_condi_item2 VARCHAR(255) NULL, ";
					$add_statement .= "ex_price_item2 VARCHAR(255) NULL, ";

					$add_statement .= "ex_title_item3 VARCHAR(255) NULL, ";
					$add_statement .= "ex_author_item3 VARCHAR(255) NULL, ";
					$add_statement .= "ex_genre_item3 VARCHAR(255) NULL, ";
					$add_statement .= "ex_isbn_item3 VARCHAR(255) NULL, ";
					$add_statement .= "ex_description_item3 VARCHAR(255) NULL, ";
					$add_statement .= "ex_condi_item3 VARCHAR(255) NULL, ";
					$add_statement .= "ex_price_item3 VARCHAR(255) NULL, ";

					$add_statement .= "ex_title_item4 VARCHAR(255) NULL, ";
					$add_statement .= "ex_author_item4 VARCHAR(255) NULL, ";
					$add_statement .= "ex_genre_item4 VARCHAR(255) NULL, ";
					$add_statement .= "ex_isbn_item4 VARCHAR(255) NULL, ";
					$add_statement .= "ex_description_item4 VARCHAR(255) NULL, ";
					$add_statement .= "ex_condi_item4 VARCHAR(255) NULL, ";
					$add_statement .= "ex_price_item4 VARCHAR(255) NULL, ";

					$add_statement .= "ex_title_item5 VARCHAR(255) NULL, ";
					$add_statement .= "ex_author_item5 VARCHAR(255) NULL, ";
					$add_statement .= "ex_genre_item5 VARCHAR(255) NULL, ";
					$add_statement .= "ex_isbn_item5 VARCHAR(255) NULL, ";
					$add_statement .= "ex_description_item5 VARCHAR(255) NULL, ";
					$add_statement .= "ex_condi_item5 VARCHAR(255) NULL, ";
					$add_statement .= "ex_price_item5 VARCHAR(255) NULL)";					

					$add_result = mysqli_query($db, $add_statement);
					if (!$add_result)
					{
						$add_errNo = mysqli_errno($db);
						$add_errMes = mysqli_error($db);

						print "<br>Error with MySQL!<br>";
						printf ("(" . $add_errNo . ": " . $add_errMes . ")<br>");
						exit;
					}
				}
				else {

					//Output MySQL Error Codes & Error Messages
					print "<br>Error with MySQL!<br>";
					printf ("(" . $errNo . ": " . $errMes . ")<br>");
					exit;					
				}
			}
//=============== NEW IMPLEMENTATION ============================			

			if (!$this->is_order_hist_empty())
			{
				$this->_initOrder();
			}

			$this->get_sale_pending();
			$this->get_selling_history();
		} //end __construct


		public function is_order_hist_empty()
		{
			require("dbstuffs.inc");

			if (session_id() == "") {
				session_start();
			}

			$buyerID = $_SESSION['userID'];

			$statement = "SELECT * FROM `order` WHERE `buyerID` ='$buyerID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$numresults = mysqli_num_rows($result);
			if($numresults == 0) {
				return true;
			}
			else {
				return false;
			}
		} // End of function is_order_hist_empty


		private function _initOrder()
		{
			require("dbstuffs.inc");
			
			if (session_id() == "") {
				session_start();
			}

			$buyerID = $_SESSION['userID'];

			$statement = "SELECT * FROM `order` WHERE `buyerID` ='$buyerID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$order_history_arr = array();
			$numresults = mysqli_num_rows($result);

			while ($numresults != 0)
			{
				$row = $result->fetch_assoc();

				$order_history_arr[] = $row;

				$numresults--;
			}

			$this->order_history_arr = $order_history_arr;

			$this->_setSession();
		} // End of function _initOrder


		private function _setSession()
		{
			$_SESSION['order_history_arr'] = $this->order_history_arr;
		} // End of function _setSession





// ======================= FOR BUYER ==================================
		public function insert_exchange_items($buyerID, $exchange_item_arr, $listing_for_exchange)
		{
			if (session_id() == '') {
				session_start();
			}

			if (isset($_SESSION['recent_orderID_arr'])) {
				$recent_orderID_arr = $_SESSION['recent_orderID_arr'];
			}
			else {
				$recent_orderID_arr = array();
			}

			require("dbstuffs.inc");

		// ==================== ORDER INFO ====================
			$exmethod		= "local";
			$status			= "Awaiting Seller Confirmation";
		// =============== END OF ORDER INFO ==================

		// ==================== BUYER INFO ====================
			//$buyerID; // ALREADY HAVE IT
			$buyer_name		= $_SESSION['firstname'] . " " . $_SESSION['lastname'];
			$buyer_email	= $_SESSION['email'];
			$buyer_phone	= $_SESSION['phone'];

			$buyer_name 	= mysqli_real_escape_string($db, $buyer_name);
			$buyer_email 	= mysqli_real_escape_string($db, $buyer_email);
			$buyer_phone 	= mysqli_real_escape_string($db, $buyer_phone);
		// =============== END OF BUYER INFO ==================

		// ============== SORTING BY SellerID ========================	
			for ($i = 0; $i < (count($exchange_item_arr) - 1); $i++)
			{
				$min = $i;

				for ($j = ($i + 1); $j < count($exchange_item_arr); $j++)
				{
					if ($exchange_item_arr[$j]['sellerID'] < $exchange_item_arr[$min]['sellerID']) {
						$min = $j;
					}
				}

				$temp = $exchange_item_arr[$min];
				$exchange_item_arr[$min] = $exchange_item_arr[$i];
				$exchange_item_arr[$i] = $temp;
			}
		// ========== END OF SORTING BY SellerID =====================

			while (count($exchange_item_arr) != 0)
			{
			// ============= SEPARATE ITEMS BY SellerID ===============
				$last_index = (count($exchange_item_arr) - 1);

				$same_seller_arr = array();
				$same_seller_arr[] = $exchange_item_arr[$last_index];
				unset($exchange_item_arr[$last_index]);
				$last_index--;

				for ($i = $last_index; $i >= 0; $i--)
				{
					if ($same_seller_arr[0]['sellerID'] == $exchange_item_arr[$last_index]['sellerID'])
					{
						$same_seller_arr[] = $exchange_item_arr[$last_index];
						unset($exchange_item_arr[$last_index]);
						$last_index--;
					}
				}
			// ========= END OF SEPARATE ITEMS BY SellerID ============

				$order_quantity = count($same_seller_arr);

			// ===== INSERT same_seller_arr TO DB START FROM HERE =====

				// ================= GET SELLER INFO ====================
				$sellerID 		= $same_seller_arr[0]['sellerID'];
				$seller_name 	= $same_seller_arr[0]['seller'];
				$seller_name 	= mysqli_real_escape_string($db, $seller_name);

				$statement = "SELECT * FROM users WHERE userID ='$sellerID'";
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
					echo "Seller Info. Not Found!<br>";
					exit;
				}
				$row = $result->fetch_assoc();

				$seller_email 	= $row['email'];
				$seller_phone	= $row['phone'];
				$seller_address = $row['address'];
				$seller_city 	= $row['city'];
				$seller_state 	= $row['state'];
				$seller_zip 	= $row['zip'];

				$seller_email 	= mysqli_real_escape_string($db, $seller_email);
				$seller_phone 	= mysqli_real_escape_string($db, $seller_phone);
				$seller_address = mysqli_real_escape_string($db, $seller_address);
				$seller_city 	= mysqli_real_escape_string($db, $seller_city);
				$seller_state 	= mysqli_real_escape_string($db, $seller_state);
				$seller_zip 	= mysqli_real_escape_string($db, $seller_zip);				
				// ============ END OF GET SELLER INFO =================

				$doo = date("Y/m/d"); // Date of Order
				$too = date("H:i:s"); // Time of Order

				//==== INSERTING BUYER & SELLER INFO TO THE TABLE =====

				$statement = "INSERT INTO `order` ( ";
				$statement .= "`exmethod`, `status`, `date_of_order`, `time_of_order`, `order_quantity`, ";
				$statement .= "`buyerID`, `buyer_name`, `buyer_email`, `buyer_phone`, ";
				$statement .= "`sellerID`, `seller_name`, `seller_email`, `seller_phone`, `seller_address`, `seller_city`, `seller_state`, `seller_zip`) ";
				$statement .= "VALUES ( ";
				$statement .= "'$exmethod', '$status', '$doo', '$too', '$order_quantity', ";
				$statement .= "'$buyerID', '$buyer_name', '$buyer_email', '$buyer_phone', ";
				$statement .= "'$sellerID', '$seller_name', '$seller_email', '$seller_phone', '$seller_address', '$seller_city', '$seller_state', '$seller_zip')";
				$result = mysqli_query($db, $statement);
				if (!$result)
				{
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}
				
				//=== END OF INSERTING BUYER & SELLER INFO TO THE TABLE ===


				//== GET orderID for inserting items in same_seller_arr ===

				$statement = "SELECT * FROM `order` WHERE `buyerID` = '$buyerID' AND `sellerID` = '$sellerID' AND `date_of_order` = '$doo' AND `time_of_order` = '$too' AND `order_quantity` = '$order_quantity' AND `exmethod` = '$exmethod'";
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
					echo "Order Info. Not Found!<br>";
					exit;
				}
				$row = $result->fetch_assoc();

				$orderID 		= $row['orderID'];
				$order_subtotal = $row['order_subtotal'];

				$recent_orderID_arr[] = $orderID;
				
				//==== END OF GET orderID for inserting items =====

				$item_number = 1;

				$price_item_value = 0;
				$order_subtotal = 0;

				for ($i = 0; $i < count($same_seller_arr); $i++)
				{
					$title_item_column 	= 'title_item' . $item_number;
					$author_item_column = 'author_item' . $item_number;
					$genre_item_column 	= 'genre_item' . $item_number;
					$isbn_item_column 	= 'isbn_item' . $item_number;
					$description_item_column = 'description_item' . $item_number;
					$condi_item_column 	= 'condi_item' . $item_number;
					$price_item_column 	= 'price_item' . $item_number;

$ex_title_item_column = 'ex_title_item' . $item_number;
$ex_author_item_column = 'ex_author_item' . $item_number;
$ex_genre_item_column 	= 'ex_genre_item' . $item_number;
$ex_isbn_item_column 	= 'ex_isbn_item' . $item_number;
$ex_description_item_column = 'ex_description_item' . $item_number;
$ex_condi_item_column 	= 'ex_condi_item' . $item_number;
$ex_price_item_column 	= 'ex_price_item' . $item_number;

					$title_item_value 	= $same_seller_arr[$i]['title'];
					$author_item_value 	= $same_seller_arr[$i]['author'];
					$genre_item_value 	= $same_seller_arr[$i]['genre'];
					$isbn_item_value 	= $same_seller_arr[$i]['isbn'];
					$description_item_value = $same_seller_arr[$i]['description'];
					$condi_item_value 	= $same_seller_arr[$i]['condi'];
					$prc_item_value 	= $same_seller_arr[$i]['price'];

for ($j = 0; $j < count($listing_for_exchange); $j++)
{
	if ($listing_for_exchange[$j]['title'] == $same_seller_arr[$i]['exchange_title'])
	{
		$ex_title_item_value 	= $listing_for_exchange[$j]['title'];
		$ex_author_item_value 	= $listing_for_exchange[$j]['author'];
		$ex_genre_item_value 	= $listing_for_exchange[$j]['genre'];
		$ex_isbn_item_value 	= $listing_for_exchange[$j]['isbn'];
		$ex_description_item_value = $listing_for_exchange[$j]['description'];
		$ex_condi_item_value 	= $listing_for_exchange[$j]['condi'];
		$ex_price_item_value 	= $listing_for_exchange[$j]['price'];

	}
}

		$price_item_value 	= $prc_item_value - $ex_price_item_value;

		$order_subtotal = $order_subtotal + $price_item_value;

/*
echo "title_item_value: " . $title_item_value . "<br>";
echo "author_item_value: " . $author_item_value . "<br>";
echo "genre_item_value: " . $genre_item_value . "<br>";
echo "isbn_item_value: " . $isbn_item_value . "<br>";
echo "description_item_value: " . $description_item_value . "<br>";
echo "condi_item_value: " . $condi_item_value . "<br>";
echo "prc_item_value: " . $prc_item_value . "<br>";

echo "ex_title_item_value: " . $ex_title_item_value . "<br>";
echo "ex_author_item_value: " . $ex_author_item_value . "<br>";
echo "ex_genre_item_value: " . $ex_genre_item_value . "<br>";
echo "ex_isbn_item_value: " . $ex_isbn_item_value . "<br>";
echo "ex_description_item_value: " . $ex_description_item_value . "<br>";
echo "ex_condi_item_value: " . $ex_condi_item_value . "<br>";
echo "ex_price_item_value: " . $ex_price_item_value . "<br><br>";
*/


					$title_item_value = mysqli_real_escape_string($db, $title_item_value);
					$author_item_value = mysqli_real_escape_string($db, $author_item_value);
					$genre_item_value = mysqli_real_escape_string($db, $genre_item_value);
					$isbn_item_value = mysqli_real_escape_string($db, $isbn_item_value);
					$description_item_value = mysqli_real_escape_string($db, $description_item_value);
					$condi_item_value = mysqli_real_escape_string($db, $condi_item_value);
					$price_item_value = mysqli_real_escape_string($db, $price_item_value);

					$ex_title_item_value = mysqli_real_escape_string($db, $ex_title_item_value);
					$ex_author_item_value = mysqli_real_escape_string($db, $ex_author_item_value);
					$ex_genre_item_value = mysqli_real_escape_string($db, $ex_genre_item_value);
					$ex_isbn_item_value = mysqli_real_escape_string($db, $ex_isbn_item_value);
					$ex_description_item_value = mysqli_real_escape_string($db, $ex_description_item_value);
					$ex_condi_item_value = mysqli_real_escape_string($db, $ex_condi_item_value);					


$statement = "UPDATE `order` SET ";
$statement .= "`$title_item_column` = '$title_item_value', ";
$statement .= "`$author_item_column` = '$author_item_value', ";
$statement .= "`$genre_item_column` = '$genre_item_value', ";
$statement .= "`$isbn_item_column` = '$isbn_item_value', ";
$statement .= "`$description_item_column` = '$description_item_value', ";
$statement .= "`$condi_item_column` = '$condi_item_value', ";
$statement .= "`$price_item_column` = '$prc_item_value', ";
$statement .= "`$ex_title_item_column` = '$ex_title_item_value', ";
$statement .= "`$ex_author_item_column` = '$ex_author_item_value', ";
$statement .= "`$ex_genre_item_column` = '$ex_genre_item_value', ";
$statement .= "`$ex_isbn_item_column` = '$ex_isbn_item_value', ";
$statement .= "`$ex_description_item_column` = '$ex_description_item_value', ";
$statement .= "`$ex_condi_item_column` = '$ex_condi_item_value', ";
$statement .= "`$ex_price_item_column` = '$ex_price_item_value', ";
$statement .= "`order_subtotal` = '$order_subtotal' ";
$statement .= "WHERE `orderID` = '$orderID'";

$result = mysqli_query($db, $statement);
if (!$result)
{
	printf ("<br>Error (%s)", mysqli_error($db));
	print "<br>Error with MySQL";
	exit;
}

					$item_number++;
				}
				//echo "Subtotal: " . $order_subtotal . "<br><br>";
			//========== END OF INSERT same_seller_arr TO DB ========
				
			} // END OF while (count($shipping_item_arr) != 0)

			$_SESSION['recent_orderID_arr'] = $recent_orderID_arr;
		} // End of Function insert_exchange_items






		public function insert_pickup_items($buyerID, $pickup_item_arr)
		{
			if (session_id() == '') {
				session_start();
			}

			if (isset($_SESSION['recent_orderID_arr'])) {
				$recent_orderID_arr = $_SESSION['recent_orderID_arr'];
			}
			else {
				$recent_orderID_arr = array();
			}

			require("dbstuffs.inc");

		// ==================== ORDER INFO ====================
			$exmethod		= "local";
			$status			= "Awaiting Seller Confirmation";
		// =============== END OF ORDER INFO ==================

		// ==================== BUYER INFO ====================
			//$buyerID; // ALREADY HAVE IT
			$buyer_name		= $_SESSION['firstname'] . " " . $_SESSION['lastname'];
			$buyer_email	= $_SESSION['email'];
			$buyer_phone	= $_SESSION['phone'];

			$buyer_name 	= mysqli_real_escape_string($db, $buyer_name);
			$buyer_email 	= mysqli_real_escape_string($db, $buyer_email);
			$buyer_phone 	= mysqli_real_escape_string($db, $buyer_phone);
		// =============== END OF BUYER INFO ==================

		// ============== SORTING BY SellerID ========================	
			for ($i = 0; $i < (count($pickup_item_arr) - 1); $i++)
			{
				$min = $i;

				for ($j = ($i + 1); $j < count($pickup_item_arr); $j++)
				{
					if ($pickup_item_arr[$j]['sellerID'] < $pickup_item_arr[$min]['sellerID']) {
						$min = $j;
					}
				}

				$temp = $pickup_item_arr[$min];
				$pickup_item_arr[$min] = $pickup_item_arr[$i];
				$pickup_item_arr[$i] = $temp;
			}
		// ========== END OF SORTING BY SellerID =====================

			//$counter_testing = 1; // REMOVE THIS AFTER TESTING DONE

			while (count($pickup_item_arr) != 0)
			{
			// ============= SEPARATE ITEMS BY SellerID ===============
				$last_index = (count($pickup_item_arr) - 1);

				$same_seller_arr = array();
				$same_seller_arr[] = $pickup_item_arr[$last_index];
				unset($pickup_item_arr[$last_index]);
				$last_index--;

				for ($i = $last_index; $i >= 0; $i--)
				{
					if ($same_seller_arr[0]['sellerID'] == $pickup_item_arr[$last_index]['sellerID'])
					{
						$same_seller_arr[] = $pickup_item_arr[$last_index];
						unset($pickup_item_arr[$last_index]);
						$last_index--;
					}
				}
			// ========= END OF SEPARATE ITEMS BY SellerID ============

				$order_quantity = count($same_seller_arr);

			// ========== INSERT same_seller_arr TO DB START FROM HERE ======
				
				/*echo "=========== INSERT PICKUP ITEMS ============<br><br>";
				echo "===== INSERT same_seller_arr TO DB START FROM HERE ======<br><br>";
				echo "Inserted same seller array " . $counter_testing;
				echo ", from " . $same_seller_arr[0]['seller'] . ", contains " . count($same_seller_arr) . " item(s).<br><br>";*/


				// ================= GET SELLER INFO ====================
				$sellerID 		= $same_seller_arr[0]['sellerID'];
				$seller_name 	= $same_seller_arr[0]['seller'];
				$seller_name 	= mysqli_real_escape_string($db, $seller_name);

				$statement = "SELECT * FROM users WHERE userID ='$sellerID'";
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
					echo "Seller Info. Not Found!<br>";
					exit;
				}
				$row = $result->fetch_assoc();

				$seller_email 	= $row['email'];
				$seller_phone	= $row['phone'];
				$seller_address = $row['address'];
				$seller_city 	= $row['city'];
				$seller_state 	= $row['state'];
				$seller_zip 	= $row['zip'];

				$seller_email 	= mysqli_real_escape_string($db, $seller_email);
				$seller_phone 	= mysqli_real_escape_string($db, $seller_phone);
				$seller_address = mysqli_real_escape_string($db, $seller_address);
				$seller_city 	= mysqli_real_escape_string($db, $seller_city);
				$seller_state 	= mysqli_real_escape_string($db, $seller_state);
				$seller_zip 	= mysqli_real_escape_string($db, $seller_zip);				

				/*echo "Seller ID: " . $sellerID . "<br>";
				echo "Seller   : " . $seller_name . "<br>";
				echo "Email    : " . $seller_email . "<br>";
				echo "Phone    : " . $seller_phone . "<br>";
				echo "Address  : ";
				echo $seller_address	. ", ";
				echo $seller_city	. ", ";
				echo $seller_state 	. ", ";
				echo $seller_zip	. "<br><br>";*/
				// ============ END OF GET SELLER INFO =================

				$doo = date("Y/m/d"); // Date of Order
				$too = date("H:i:s"); // Time of Order

				// ======= INSERTING BUYER & SELLER INFO TO THE TABLE =======
				$statement = "INSERT INTO `order` ( ";
				$statement .= "`exmethod`, `status`, `date_of_order`, `time_of_order`, `order_quantity`, ";
				$statement .= "`buyerID`, `buyer_name`, `buyer_email`, `buyer_phone`, ";
				$statement .= "`sellerID`, `seller_name`, `seller_email`, `seller_phone`, `seller_address`, `seller_city`, `seller_state`, `seller_zip`) ";
				$statement .= "VALUES ( ";
				$statement .= "'$exmethod', '$status', '$doo', '$too', '$order_quantity', ";
				$statement .= "'$buyerID', '$buyer_name', '$buyer_email', '$buyer_phone', ";
				$statement .= "'$sellerID', '$seller_name', '$seller_email', '$seller_phone', '$seller_address', '$seller_city', '$seller_state', '$seller_zip')";
				$result = mysqli_query($db, $statement);
				if (!$result)
				{
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}
				// === END OF INSERTING BUYER & SELLER INFO TO THE TABLE ====

				//$counter_testing++; // REMOVE THIS AFTER DONE TESTING

				//=== GET orderID for inserting items in same_seller_arr ====
				$statement = "SELECT * FROM `order` WHERE `buyerID` = '$buyerID' AND `sellerID` = '$sellerID' AND `date_of_order` = '$doo' AND `time_of_order` = '$too' AND `order_quantity` = '$order_quantity' AND `exmethod` = '$exmethod'";
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
					echo "Order Info. Not Found!<br>";
					exit;
				}
				$row = $result->fetch_assoc();

				$orderID 		= $row['orderID'];
				$order_subtotal = $row['order_subtotal'];

				$recent_orderID_arr[] = $orderID;
				//echo "OrderID: " . $orderID . "<br><br>";
				
				//========= END OF GET orderID for inserting items ==========

				$item_number = 1;

				for ($i = 0; $i < count($same_seller_arr); $i++)
				{
					$title_item_column 	= 'title_item' . $item_number;
					$author_item_column = 'author_item' . $item_number;
					$genre_item_column 	= 'genre_item' . $item_number;
					$isbn_item_column 	= 'isbn_item' . $item_number;
					$description_item_column = 'description_item' . $item_number;
					$condi_item_column 	= 'condi_item' . $item_number;
					$price_item_column 	= 'price_item' . $item_number;


					$title_item_value 	= $same_seller_arr[$i]['title'];
					$author_item_value 	= $same_seller_arr[$i]['author'];
					$genre_item_value 	= $same_seller_arr[$i]['genre'];
					$isbn_item_value 	= $same_seller_arr[$i]['isbn'];
					$description_item_value = $same_seller_arr[$i]['description'];
					$condi_item_value 	= $same_seller_arr[$i]['condi'];
					$price_item_value 	= $same_seller_arr[$i]['price'];

				    $order_subtotal = $order_subtotal + $same_seller_arr[$i]['price'];					

					$title_item_value = mysqli_real_escape_string($db, $title_item_value);
					$author_item_value = mysqli_real_escape_string($db, $author_item_value);
					$genre_item_value = mysqli_real_escape_string($db, $genre_item_value);
					$isbn_item_value = mysqli_real_escape_string($db, $isbn_item_value);
					$description_item_value = mysqli_real_escape_string($db, $description_item_value);
					$condi_item_value = mysqli_real_escape_string($db, $condi_item_value);
					$price_item_value = mysqli_real_escape_string($db, $price_item_value);

					/*echo $title_item_column . "<br>";
					echo $author_item_column . "<br>";
					echo $genre_item_column . "<br>";
					echo $isbn_item_column . "<br>";
					echo $description_item_column . "<br>";
					echo $condi_item_column . "<br>";
					echo $price_item_column . "<br><br>";

					echo "From same_seller_arr Index: "	. $i . "<br>";
			        echo "Title: " . $title_item_value . "<br>";
			        echo "Author: " . $author_item_value . "<br>";
			        echo "Genre: " . $genre_item_value . "<br>";
			        echo "ISBN: " . $isbn_item_value . "<br>";
			        echo "Description: " . $description_item_value . "<br>";
			        echo "Condition: " . $condi_item_value . "<br>";
			        echo "Price: " . $price_item_value . "<br>";
			        echo "Subtotal: " . $order_subtotal . "<br><br>";*/

					$statement = "UPDATE `order` SET ";
					$statement .= "`$title_item_column` = '$title_item_value', ";
					$statement .= "`$author_item_column` = '$author_item_value', ";
					$statement .= "`$genre_item_column` = '$genre_item_value', ";
					$statement .= "`$isbn_item_column` = '$isbn_item_value', ";
					$statement .= "`$description_item_column` = '$description_item_value', ";
					$statement .= "`$condi_item_column` = '$condi_item_value', ";
					$statement .= "`$price_item_column` = '$price_item_value', ";
					$statement .= "`order_subtotal` = '$order_subtotal' ";
					$statement .= "WHERE `orderID` = '$orderID'";

					$result = mysqli_query($db, $statement);
					if (!$result)
					{
						printf ("<br>Error (%s)", mysqli_error($db));
						print "<br>Error with MySQL";
						exit;
					}

					$item_number++;
				}
			// ============= END OF INSERT same_seller_arr TO DB ============
			
				//echo "========= END INSERT same_seller_arr TO DB ===============<br><br><br><br>";
			} // END OF while (count($shipping_item_arr) != 0)

			$_SESSION['recent_orderID_arr'] = $recent_orderID_arr;
		} // End of Function insert_pickup_items


		public function insert_shipping_items($buyerID, $shipping_item_arr, $selected_shipping, $selected_card)
		{
			if (session_id() == '') {
				session_start();
			}

			if (isset($_SESSION['recent_orderID_arr'])) {
				$recent_orderID_arr = $_SESSION['recent_orderID_arr'];
			}
			else {
				$recent_orderID_arr = array();
			}

			require("dbstuffs.inc");

		// ==================== ORDER INFO ====================
			$exmethod		= "ship";
			$status			= "Awaiting Shipping";
		// =============== END OF ORDER INFO ==================

		// ==================== BUYER INFO ====================
			//$buyerID; // ALREADY HAVE IT
			$buyer_name		= $_SESSION['firstname'] . " " . $_SESSION['lastname'];
			$buyer_email	= $_SESSION['email'];
			$buyer_phone	= $_SESSION['phone'];

			$shipping_name		= $selected_shipping['name'];
			$shipping_address	= $selected_shipping['address'];
			$shipping_city		= $selected_shipping['city'];
			$shipping_state		= $selected_shipping['state'];
			$shipping_zip		= $selected_shipping['zip'];
			$shipping_phone		= $selected_shipping['phone'];

			$card_name		= $selected_card['card_name'];
			$card_number	= $selected_card['card_number'];
			$card_exp		= $selected_card['card_exp'];
			$card_cvv		= $selected_card['card_cvv'];
			$card_address	= $selected_card['card_address'];
			$card_city		= $selected_card['card_city'];
			$card_state		= $selected_card['card_state'];
			$card_zip		= $selected_card['card_zip'];

			$buyer_name 	= mysqli_real_escape_string($db, $buyer_name);
			$buyer_email 	= mysqli_real_escape_string($db, $buyer_email);
			$buyer_phone 	= mysqli_real_escape_string($db, $buyer_phone);

			$shipping_name 	= mysqli_real_escape_string($db, $shipping_name);
			$shipping_address = mysqli_real_escape_string($db, $shipping_address);
			$shipping_city = mysqli_real_escape_string($db, $shipping_city);
			$shipping_state = mysqli_real_escape_string($db, $shipping_state);
			$shipping_zip = mysqli_real_escape_string($db, $shipping_zip);
			$shipping_phone = mysqli_real_escape_string($db, $shipping_phone);

			$card_name 	= mysqli_real_escape_string($db, $card_name);
			$card_number = mysqli_real_escape_string($db, $card_number);
			$card_exp = mysqli_real_escape_string($db, $card_exp);
			$card_cvv = mysqli_real_escape_string($db, $card_cvv);
			$card_address = mysqli_real_escape_string($db, $card_address);
			$card_city = mysqli_real_escape_string($db, $card_city);
			$card_state = mysqli_real_escape_string($db, $card_state);
			$card_zip = mysqli_real_escape_string($db, $card_zip);									
		// =============== END OF BUYER INFO ==================

		// ============== SORTING BY SellerID ========================	
			for ($i = 0; $i < (count($shipping_item_arr) - 1); $i++)
			{
				$min = $i;

				for ($j = ($i + 1); $j < count($shipping_item_arr); $j++)
				{
					if ($shipping_item_arr[$j]['sellerID'] < $shipping_item_arr[$min]['sellerID']) {
						$min = $j;
					}
				}

				$temp = $shipping_item_arr[$min];
				$shipping_item_arr[$min] = $shipping_item_arr[$i];
				$shipping_item_arr[$i] = $temp;
			}
		// ========== END OF SORTING BY SellerID =====================

			//$counter_testing = 1; // REMOVE THIS AFTER TESTING DONE

			while (count($shipping_item_arr) != 0)
			{
			// ============= SEPARATE ITEMS BY SellerID ===============
				$last_index = (count($shipping_item_arr) - 1);

				$same_seller_arr = array();
				$same_seller_arr[] = $shipping_item_arr[$last_index];
				unset($shipping_item_arr[$last_index]);
				$last_index--;

				for ($i = $last_index; $i >= 0; $i--)
				{
					if ($same_seller_arr[0]['sellerID'] == $shipping_item_arr[$last_index]['sellerID'])
					{
						$same_seller_arr[] = $shipping_item_arr[$last_index];
						unset($shipping_item_arr[$last_index]);
						$last_index--;
					}
				}
			// ========= END OF SEPARATE ITEMS BY SellerID ============

				$order_quantity = count($same_seller_arr);

			// ========== INSERT same_seller_arr TO DB START FROM HERE ======
				
				/*echo "=========== INSERT SHIPPING ITEMS ============<br><br>";
				echo "===== INSERT same_seller_arr TO DB START FROM HERE ======<br><br>";
				echo "Inserted same seller array " . $counter_testing;
				echo ", from " . $same_seller_arr[0]['seller'] . ", contains " . count($same_seller_arr) . " item(s).<br><br>";*/

				// ================= GET SELLER INFO ====================
				$sellerID 		= $same_seller_arr[0]['sellerID'];
				$seller_name 	= $same_seller_arr[0]['seller'];
				$seller_name 	= mysqli_real_escape_string($db, $seller_name);

				$statement = "SELECT * FROM users WHERE userID ='$sellerID'";
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
					echo "Seller Info. Not Found!<br>";
					exit;
				}
				$row = $result->fetch_assoc();

				$seller_email 	= $row['email'];
				$seller_phone	= $row['phone'];
				$seller_address = $row['address'];
				$seller_city 	= $row['city'];
				$seller_state 	= $row['state'];
				$seller_zip 	= $row['zip'];

				$seller_email 	= mysqli_real_escape_string($db, $seller_email);
				$seller_phone 	= mysqli_real_escape_string($db, $seller_phone);
				$seller_address = mysqli_real_escape_string($db, $seller_address);
				$seller_city 	= mysqli_real_escape_string($db, $seller_city);
				$seller_state 	= mysqli_real_escape_string($db, $seller_state);
				$seller_zip 	= mysqli_real_escape_string($db, $seller_zip);
				
				/*echo "Seller ID: " . $sellerID . "<br>";
				echo "Seller   : " . $seller_name . "<br>";
				echo "Email    : " . $seller_email . "<br>";
				echo "Phone    : " . $seller_phone . "<br>";
				echo "Address  : ";
				echo $seller_address	. ", ";
				echo $seller_city	. ", ";
				echo $seller_state 	. ", ";
				echo $seller_zip	. "<br><br>";*/
				// ============ END OF GET SELLER INFO =================

				$doo = date("Y/m/d"); // Date of Order
				$too = date("H:i:s"); // Time of Order

				// ======= INSERTING BUYER & SELLER INFO TO THE TABLE =======
				$statement = "INSERT INTO `order` ( ";
				$statement .= "`exmethod`, `status`, `date_of_order`, `time_of_order`, `order_quantity`, ";
				$statement .= "`buyerID`, `buyer_name`, `buyer_email`, `buyer_phone`, ";
				$statement .= "`shipping_name`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_zip`, `shipping_phone`, ";
				$statement .= "`card_name`, `card_number`, `card_exp`, `card_cvv`, `card_address`, `card_city`, `card_state`, `card_zip`, ";
				$statement .= "`sellerID`, `seller_name`, `seller_email`, `seller_phone`, `seller_address`, `seller_city`, `seller_state`, `seller_zip`) ";
				$statement .= "VALUES ( ";
				$statement .= "'$exmethod', '$status', '$doo', '$too', '$order_quantity', ";
				$statement .= "'$buyerID', '$buyer_name', '$buyer_email', '$buyer_phone', ";
				$statement .= "'$shipping_name', '$shipping_address', '$shipping_city', '$shipping_state', '$shipping_zip', '$shipping_phone', ";
				$statement .= "'$card_name', '$card_number', '$card_exp', '$card_cvv', '$card_address', '$card_city', '$card_state', '$card_zip', ";
				$statement .= "'$sellerID', '$seller_name', '$seller_email', '$seller_phone', '$seller_address', '$seller_city', '$seller_state', '$seller_zip')";
				$result = mysqli_query($db, $statement);
				if (!$result)
				{
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}
				// === END OF INSERTING BUYER & SELLER INFO TO THE TABLE ====

				//$counter_testing++; // REMOVE THIS AFTER DONE TESTING

				//=== GET orderID for inserting items in same_seller_arr ====
				$statement = "SELECT * FROM `order` WHERE `buyerID` = '$buyerID' AND `sellerID` = '$sellerID' AND `date_of_order` = '$doo' AND `time_of_order` = '$too' AND `order_quantity` = '$order_quantity' AND `exmethod` = '$exmethod'";
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
					echo "Order Info. Not Found!<br>";
					exit;
				}
				$row = $result->fetch_assoc();

				$orderID 		= $row['orderID'];
				$order_subtotal = $row['order_subtotal'];

				$recent_orderID_arr[] = $orderID;
				//echo "OrderID: " . $orderID . "<br><br>";

				//======= END OF GET orderID for inserting items ===========

				$item_number = 1;

				for ($i = 0; $i < count($same_seller_arr); $i++)
				{
					$title_item_column 	= 'title_item' . $item_number;
					$author_item_column = 'author_item' . $item_number;
					$genre_item_column 	= 'genre_item' . $item_number;
					$isbn_item_column 	= 'isbn_item' . $item_number;
					$description_item_column = 'description_item' . $item_number;
					$condi_item_column 	= 'condi_item' . $item_number;
					$price_item_column 	= 'price_item' . $item_number;


					$title_item_value 	= $same_seller_arr[$i]['title'];
					$author_item_value 	= $same_seller_arr[$i]['author'];
					$genre_item_value 	= $same_seller_arr[$i]['genre'];
					$isbn_item_value 	= $same_seller_arr[$i]['isbn'];
					$description_item_value = $same_seller_arr[$i]['description'];
					$condi_item_value 	= $same_seller_arr[$i]['condi'];
					$price_item_value 	= $same_seller_arr[$i]['price'];


			        $order_subtotal = $order_subtotal + $same_seller_arr[$i]['price'];					

					$title_item_value = mysqli_real_escape_string($db, $title_item_value);
					$author_item_value = mysqli_real_escape_string($db, $author_item_value);
					$genre_item_value = mysqli_real_escape_string($db, $genre_item_value);
					$isbn_item_value = mysqli_real_escape_string($db, $isbn_item_value);
					$description_item_value = mysqli_real_escape_string($db, $description_item_value);
					$condi_item_value = mysqli_real_escape_string($db, $condi_item_value);
					$price_item_value = mysqli_real_escape_string($db, $price_item_value);

					/*echo $title_item_column . "<br>";
					echo $author_item_column . "<br>";
					echo $genre_item_column . "<br>";
					echo $isbn_item_column . "<br>";
					echo $description_item_column . "<br>";
					echo $condi_item_column . "<br>";
					echo $price_item_column . "<br><br>";

					echo "From same_seller_arr Index: "	. $i . "<br>";
			        echo "Title: " . $title_item_value . "<br>";
			        echo "Author: " . $author_item_value . "<br>";
			        echo "Genre: " . $genre_item_value . "<br>";
			        echo "ISBN: " . $isbn_item_value . "<br>";
			        echo "Description: " . $description_item_value . "<br>";
			        echo "Condition: " . $condi_item_value . "<br>";
			        echo "Price: " . $price_item_value . "<br>";
			        echo "Subtotal: " . $order_subtotal . "<br><br>";*/

					$statement = "UPDATE `order` SET ";
					$statement .= "`$title_item_column` = '$title_item_value', ";
					$statement .= "`$author_item_column` = '$author_item_value', ";
					$statement .= "`$genre_item_column` = '$genre_item_value', ";
					$statement .= "`$isbn_item_column` = '$isbn_item_value', ";
					$statement .= "`$description_item_column` = '$description_item_value', ";
					$statement .= "`$condi_item_column` = '$condi_item_value', ";
					$statement .= "`$price_item_column` = '$price_item_value', ";
					$statement .= "`order_subtotal` = '$order_subtotal' ";
					$statement .= "WHERE `orderID` = '$orderID'";

					$result = mysqli_query($db, $statement);
					if (!$result)
					{
						printf ("<br>Error (%s)", mysqli_error($db));
						print "<br>Error with MySQL";
						exit;
					}

					$item_number++;
				}
			// ============= END OF INSERT same_seller_arr TO DB ============
			
				//echo "========= END INSERT same_seller_arr TO DB ===============<br><br><br><br>";
			} // END OF while (count($shipping_item_arr) != 0)

			$_SESSION['recent_orderID_arr'] = $recent_orderID_arr;
		} // End of Function insert_shipping_items


		public function get_recent_orders($recent_orderID_arr)
		{
			require("dbstuffs.inc");

			$recent_orders_arr = array();

			for ($i = 0; $i < count($recent_orderID_arr); $i++)
			{
				$orderID = $recent_orderID_arr[$i];

				$statement = "SELECT * FROM `order` WHERE `orderID` ='$orderID'";
				$result = mysqli_query($db, $statement);
				if (!$result)
				{
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}

				$numresults = mysqli_num_rows($result);
				$row = $result->fetch_assoc();

				$recent_orders_arr[] = $row;
			}

			$_SESSION['recent_orders_arr'] = $recent_orders_arr;
		} // End Of Function get_recent_orders
// ======================= FOR BUYER ==================================




// ======================= FOR SELLER ==================================
		public function get_sale_pending()
		{
			require("dbstuffs.inc");

			if (session_id() == "") {
				session_start();
			}

			$sellerID = $_SESSION['userID'];
			$awaiting_confirm = "Awaiting Seller Confirmation";
			$awaiting_shipping = "Awaiting Shipping";

			$statement = "SELECT * FROM `order` WHERE `sellerID` ='$sellerID' AND (`status` = '$awaiting_confirm' OR `status` = '$awaiting_shipping')";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$numresults = mysqli_num_rows($result);
			$sale_pending_arr = array();

			if($numresults != 0) {
				while ($numresults != 0)
				{
					$row = $result->fetch_assoc();

					$sale_pending_arr[] = $row;

					$numresults--;
				}
			}

			$_SESSION['sale_pending_arr'] = $sale_pending_arr;
		} // End Of Function get_sale_pending

		public function get_selling_history()
		{
			require("dbstuffs.inc");

			if (session_id() == "") {
				session_start();
			}

			$sellerID 	= $_SESSION['userID'];
			$status 	= "Sold";

			$statement = "SELECT * FROM `order` WHERE `sellerID` ='$sellerID' AND `status` = '$status'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$numresults = mysqli_num_rows($result);
			$selling_history_arr = array();

			if($numresults != 0) {
				while ($numresults != 0)
				{
					$row = $result->fetch_assoc();

					$selling_history_arr[] = $row;

					$numresults--;
				}
			}

			$_SESSION['selling_history_arr'] = $selling_history_arr;
		} // End Of Function get_selling_history

		public function status_updating($orderID)
		{
			require("dbstuffs.inc");

			$status = "Sold";

			$statement = "UPDATE `order` SET ";
			$statement .= "status = '$status' ";
			$statement .= "WHERE `orderID` = '$orderID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}			
		}

		public function get_order_details($orderID)
		{
			//echo "GOT HERE<br>";
			//echo "Order ID: " . $orderID . "<br>";

			require("dbstuffs.inc");

			if (session_id() == "") {
				session_start();
			}

			$statement = "SELECT * FROM `order` WHERE `orderID` ='$orderID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$numresults = mysqli_num_rows($result);

			if($numresults != 0) {
				$row = $result->fetch_assoc();

				$orderID_details = $row;
			}

			$_SESSION['orderID_details'] = $orderID_details;
		}
// ======================= FOR SELLER ==================================


	} // End of Class Order
?>



















