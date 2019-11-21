<?php
	class Cart
	{
		private $cart_quantity;
		private $item_array = array();

		function __construct()
		{
			require("dbstuffs.inc");

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

			if (session_id() == "") {
				session_start();
			}

			if (isset($_SESSION['userID']))
			{
				$buyerID = $_SESSION['userID'];
				if ($this->is_cart_existed($buyerID)) {
					$this->_setSession($buyerID);
				}
				else {
					$this->cart_creating($buyerID);
				}
			}

			if (isset($_SESSION['cart_quantity'])) {
				$this->_initCart();
			}
		} //End __construct


		//Check if this specific user already had a cart created
		private function is_cart_existed($buyerID)
		{
			require("dbstuffs.inc");

			$statement = "SELECT * FROM cart WHERE buyerID='$buyerID'";

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
		} //End function is_cart_existed


		private function cart_creating($buyerID)
		{
			require("dbstuffs.inc");

			$statement = "INSERT INTO cart (buyerID) VALUES ('$buyerID')";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$this->_setSession($buyerID);		
		} //End function cart_creating


		private function _setSession($buyerID)
		{
			require("dbstuffs.inc");

			$statement = "SELECT * FROM cart WHERE buyerID='$buyerID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$row = $result->fetch_assoc();

			$this->cart_quantity = $row['cart_quantity'];
			$_SESSION['cart_quantity'] = $this->cart_quantity;

			$column_counter = $this->cart_quantity;
			while ($column_counter != 0)
			{
				$itemColumn = 'item' . $column_counter;
				$items[] = $row["$itemColumn"];

				$column_counter--;
			}

			$item_arr = array();
			for ($i = 0; $i < count($items); $i++)
			{
				$sellingID = $items[$i];

				$statement = "SELECT * FROM inventory WHERE sellingID = '$sellingID'";

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
					echo "Book Not Found!<br>";
					exit;
				}

				$row = $result->fetch_assoc();
				$item_arr[] = $row;
			}			

			$this->item_array = $item_arr;
			$_SESSION['item_arr'] = $this->item_array;
		} //End function setSession


		private function _initCart()
		{
			$this->cart_quantity = $_SESSION['cart_quantity'];
			$this->item_array = $_SESSION['item_arr'];
		} //End function initUser


		public function is_empty()
		{
			if ($this->cart_quantity == 0) {
				return true;
			}
			else {
				return false;
			}
		} //End is_empty function


		public function add_an_item($buyerID, $sellingID)
		{
			require("dbstuffs.inc");

			//Check for belongings problem before adding
			$statement = "SELECT * FROM inventory WHERE sellingID='$sellingID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$row = $result->fetch_assoc();

			if ($buyerID == $row['sellerID'])
			{
				die(header("Location: ../frontend/authenticated/cart_adding_failed_belongings.php"));
			}
			//End Checking for belongings

			//Check for duplicate problem before adding
			$statement = "SELECT * FROM cart WHERE buyerID='$buyerID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			$items = array();
			$row = $result->fetch_assoc();

			$column_counter = $this->cart_quantity;
			while ($column_counter != 0)
			{
				$itemColumn = 'item' . $column_counter;
				$items[] = $row["$itemColumn"];

				$column_counter--;
			}
			
			for ($i = 0; $i <= count($items); $i++)
			{
				if ($items[$i] == $sellingID)
				{
					die(header("Location: ../frontend/authenticated/cart_adding_failed_duplicated_item.php"));
				}
			}
			//End Checking for duplicate

			//Inserting new item to Cart Table
			$c_quan = $this->cart_quantity + 1;
			$itemColumn = 'item' . $c_quan;

			$statement = "UPDATE cart ";
			$statement .= "SET cart_quantity = '$c_quan', `$itemColumn` = '$sellingID' ";
			$statement .= "WHERE buyerID = '$buyerID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			} //End Inserting Item

			die(header("Location: ../frontend/authenticated/cart_adding_complete.php"));
		} //End function add_an_item


		public function cart_displaying()
		{
			$_SESSION['item_arr'] = $this->item_array;

			die(header("Location: ../frontend/authenticated/cart.php"));
		} //End function cart_displaying


		public function delete_an_item($buyerID, $item_number, $itemColumn)
		{
			require("dbstuffs.inc");

			if ($item_number == $this->cart_quantity)
			{
				$c_quan = $this->cart_quantity - 1;

				$statement = "UPDATE cart ";
				$statement .= "SET cart_quantity = '$c_quan', `$itemColumn` = NULL ";
				$statement .= "WHERE buyerID = '$buyerID'";

				$result = mysqli_query($db, $statement);
				if (!$result)
				{
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}			
			} //End if function
			else
			{
				$item_last_number = $this->cart_quantity;
				$item_last_column = 'item' . $item_last_number;

				$statement = "SELECT * FROM cart WHERE buyerID='$buyerID'";

				$result = mysqli_query($db, $statement);
				if (!$result)
				{
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}

				$row = $result->fetch_assoc();
				$item_last_value = $row["$item_last_column"];

				$c_quan = $this->cart_quantity - 1;

				$statement = "UPDATE cart ";
				$statement .= "SET cart_quantity = '$c_quan', `$itemColumn` = '$item_last_value', `$item_last_column` = NULL ";
				$statement .= "WHERE buyerID = '$buyerID'";

				$result = mysqli_query($db, $statement);
				if (!$result)
				{
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}
			} //End else function
		} //End function delete_an_item


		//This's for when user placing the order. It will remove all items in the cart, and also remove them from inventory table.
		public function delete_all($buyerID)
		{
			require("dbstuffs.inc");

			//====== GET ITEMS from Cart for REMOVING ===========
			$sellID_arr = array();
			$item_last_number = $this->cart_quantity;

			while ($item_last_number != 0)
			{
				$item_last_column = 'item' . $item_last_number;

				$statement = "SELECT * FROM `cart` WHERE `buyerID` = '$buyerID'";

				$result = mysqli_query($db, $statement);
				if (!$result)
				{
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}

				$row = $result->fetch_assoc();
				$sellID_arr[] = $row["$item_last_column"];

				$item_last_number--;
			}
			//==== END OF GET ITEMS from Cart for REMOVING ========



//============ REMOVING FROM CART ==================
for ($i = 0; $i < count($sellID_arr); $i++)
{
	$sellingID = $sellID_arr[$i];
	//echo "Selling ID:" . $sellingID . "<br><br>";

	$current_number = 10;
	while ($current_number != 0)
	{
		$current_columm = 'item' . $current_number;

		//echo "Current Column: " . $current_columm . "<br>";

		$statement = "SELECT * FROM `cart` WHERE `$current_columm` = '$sellingID'";

		$result = mysqli_query($db, $statement);
		if (!$result)
		{
			printf ("<br>Error (%s)", mysqli_error($db));
			print "<br>Error with MySQL";
			exit;
		}

		$numresults = mysqli_num_rows($result);

		if($numresults != 0)
		{
			while ($numresults != 0)
			{
				//echo "NUM RESULT: " . $numresults . "<br>";
				$row = $result->fetch_assoc();

				$buyerID 		= $row['buyerID'];
				$cart_quantity 	= $row['cart_quantity'];
				$item_number 	= $current_number;
				$item_column 	= $current_columm;				

				/*echo "BuyerID: " . $buyerID . "<br>";
				echo "Cart Quantity: " . $cart_quantity . "<br>";
				echo "Item Number: " . $item_number . "<br>";
				echo "Item Column: " . $item_column . "<br>";*/

				if ($item_number == $cart_quantity)
				{
					$cart_quantity--;

					/*echo "UPDATE cart SET cart_quantity = ";
					echo $cart_quantity . ", " . $item_column . " = ";
					echo "NULL WHERE buyerID = " . $buyerID . "<br>";*/

					$if_statement = "UPDATE `cart` ";
					$if_statement .= "SET `cart_quantity` = '$cart_quantity', `$item_column` = NULL ";
					$if_statement .= "WHERE `buyerID` = '$buyerID'";

					$if_result = mysqli_query($db, $if_statement);
					if (!$if_result)
					{
						printf ("<br>Error (%s)", mysqli_error($db));
						print "<br>Error with MySQL";
						exit;
					}					
				}
				else
				{
					$item_last_number = $cart_quantity;
					$item_last_column = 'item' . $item_last_number;

					$new_statement = "SELECT * FROM `cart` WHERE `buyerID` = '$buyerID'";

					$new_result = mysqli_query($db, $new_statement);
					if (!$new_result)
					{
						printf ("<br>Error (%s)", mysqli_error($db));
						print "<br>Error with MySQL";
						exit;
					}

					$new_row = $new_result->fetch_assoc();
					$item_last_value = $new_row["$item_last_column"];

					$cart_quantity--;

					/*echo "UPDATE cart SET cart_quantity = ";
					echo $cart_quantity . ", " . $item_column . " = ";
					echo $item_last_value . ", " . $item_last_column;
					echo " = NULL WHERE buyerID = " . $buyerID . "<br>";*/

					$else_statement = "UPDATE `cart` ";
					$else_statement .= "SET `cart_quantity` = '$cart_quantity', `$item_column` = '$item_last_value', `$item_last_column` = NULL ";
					$else_statement .= "WHERE `buyerID` = '$buyerID'";

					$else_result = mysqli_query($db, $else_statement);
					if (!$else_result)
					{
						printf ("<br>Error (%s)", mysqli_error($db));
						print "<br>Error with MySQL";
						exit;
					}					
				}

				//echo "<br>";
				$numresults--;
			}
		}
		$current_number--;
	}
	//echo "<br>";
}
//======= END OF REMOVING FROM CART ================


//============== REMOVING FROM INVENTORY ================
for ($i = 0; $i < count($sellID_arr); $i++)
{
	$statement = "DELETE FROM `inventory` WHERE `inventory`.`sellingID` = '$sellID_arr[$i]'";

	$result = mysqli_query($db, $statement);
	if (!$result)
	{
		printf ("<br>Error (%s)", mysqli_error($db));
		print "<br>Error with MySQL";
		exit;
	}				
}
//========== END OF REMOVING FROM INVENTORY =============



		} //End function delete_all
	} //End Class Cart
?>