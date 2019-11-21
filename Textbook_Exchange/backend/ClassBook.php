<?php
	class Book
	{
		function __construct()
		{
			require("dbstuffs.inc"); //Connecting to database

			//Create a Table if not exists one
			$statement = "CREATE TABLE IF NOT EXISTS inventory ( ";
			$statement .= "sellingID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ";
			$statement .= "sellerID INT NOT NULL, ";
			$statement .= "seller VARCHAR(255) NOT NULL, ";
			$statement .= "title VARCHAR(255) NOT NULL, ";
			$statement .= "author VARCHAR(255) NOT NULL, ";
			$statement .= "genre VARCHAR(255) NOT NULL, ";
			$statement .= "isbn VARCHAR(255) NOT NULL, ";
			$statement .= "description VARCHAR(255) NOT NULL, ";
			$statement .= "condi VARCHAR(255) NOT NULL, ";
			$statement .= "location VARCHAR(255) NOT NULL, ";
			$statement .= "exmethod VARCHAR(255) NOT NULL, ";
			$statement .= "price DOUBLE NOT NULL)";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			} //End of "Create a Table if not exists one"

//=============== NEW IMPLEMENTATION ============================
			$statement = "SELECT * FROM `inventory` WHERE (accept_exchange = 'Yes') OR (accept_exchange = 'No')";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				$errNo = mysqli_errno($db);
				$errMes = mysqli_error($db);

				if ($errNo == 1054)
				{
					$add_statement = "ALTER TABLE `inventory` ADD ";
					$add_statement .= "(`accept_exchange` VARCHAR(255) NOT NULL DEFAULT 'No', ";
					$add_statement .= "exchange_title VARCHAR(255) NULL, ";
					$add_statement .= "`exchange_author` VARCHAR(255) NULL, ";
					$add_statement .= "`exchange_genre` VARCHAR(255) NULL, ";
					$add_statement .= "`exchange_isbn` VARCHAR(255) NULL) ";

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
		} //End __construct

		/******************* BOOK INSERT *************************/
		public function insert($sellerID_IN, $seller_IN, $title_IN, $author_IN, $genre_IN, $isbn_IN, $description_IN, $condi_IN, $location_IN, $exmethod_IN, $price_IN)
		{
			require("../backend/dbstuffs.inc"); //Connecting to database

			//Create a Table if not exists one
			$statement = "CREATE TABLE IF NOT EXISTS inventory ( ";
			$statement .= "sellingID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ";
			$statement .= "sellerID INT NOT NULL, ";
			$statement .= "seller VARCHAR(255) NOT NULL, ";
			$statement .= "title VARCHAR(255) NOT NULL, ";
			$statement .= "author VARCHAR(255) NOT NULL, ";
			$statement .= "genre VARCHAR(255) NOT NULL, ";
			$statement .= "isbn VARCHAR(255) NOT NULL, ";
			$statement .= "description VARCHAR(255) NOT NULL, ";
			$statement .= "condi VARCHAR(255) NOT NULL, ";
			$statement .= "location VARCHAR(255) NOT NULL, ";
			$statement .= "exmethod VARCHAR(255) NOT NULL, ";
			$statement .= "price DOUBLE NOT NULL)";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			} //End of "Create a Table if not exists one"

			$title_IN  = mysqli_real_escape_string($db, $title_IN);
			$author_IN = mysqli_real_escape_string($db, $author_IN);
			$genre_IN  = mysqli_real_escape_string($db, $genre_IN);
			$isbn_IN   = mysqli_real_escape_string($db, $isbn_IN);
			$description_IN  = mysqli_real_escape_string($db, $description_IN);
			$location_IN = mysqli_real_escape_string($db, $location_IN);
			$price_IN = mysqli_real_escape_string($db, $price_IN);


			//Inserting new Book to inventory Table
			$statement = "INSERT INTO inventory ( ";
			$statement .= "sellerID, seller, title, author, genre, isbn, ";
			$statement .= "description, condi, location, exmethod, price) ";
			$statement .= "VALUES ( ";
			$statement .= "'$sellerID_IN', '$seller_IN', '$title_IN', '$author_IN', '$genre_IN', '$isbn_IN', ";
			$statement .= "'$description_IN', '$condi_IN', '$location_IN', '$exmethod_IN', '$price_IN')";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			} //End Inserting Book

//=============== NEW IMPLEMENTATION ============================
			$statement = "SELECT * FROM `inventory` WHERE `sellerID` = '$sellerID_IN' AND `title` = '$title_IN' AND `author` = '$author_IN' AND `isbn` = '$isbn_IN' AND `condi` = '$condi_IN' AND `exmethod` = '$exmethod_IN' AND `price` = '$price_IN'";
			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}
			$row = $result->fetch_assoc();

			$_SESSION['recent_listing'] = $row;
//=============== NEW IMPLEMENTATION ============================

			die(header("Location: ../frontend/authenticated/listing_complete.php"));
		}
		/*************** END BOOK INSERT ***********************/

		/************** BOOK SEARCH **************************/
		public function search($keyword_IN)
		{
			/*if (empty($keyword_IN))
			{
				die(header("Location: ../homepage.php"));
			}*/
			//Search by ISBN

			if (is_numeric($keyword_IN))
			{
				$this->searchByISBN($keyword_IN);
			}
			//Search by Title
			else
			{
				$str = $keyword_IN;
				$not_num = 0;

				for ($i = 0; $i < strlen($str); $i++)
				{
					if (!is_numeric($i)) {
						$not_num++;
					}
				}				

				if ($not_num > 2) {
					//echo "search by string<br>";
					$this->searchByTitle($keyword_IN);
				}
				else {
					//echo "search by ISBN<br>";
					$this->searchByISBN($keyword_IN);
				}
				
			}
		}
		/************* END BOOK SEARCH *********************/

		/********* BOOK SEARCH by ISBN **********************/
		/********* (Only Exact Search) *****************/
		public function searchByISBN($keyword_IN)
		{
			require("../backend/dbstuffs.inc"); //Connecting to database

			$keyword_IN = mysqli_real_escape_string($db, $keyword_IN);

		/********** $b_statement for EXACT SEARCH ***************/
			$b_statement = "SELECT * FROM inventory WHERE isbn='$keyword_IN'";

			$result = mysqli_query($db, $b_statement);
			if (!$result)
			{
				$errNo = mysqli_errno($db);
				$errMes = mysqli_error($db);

				//Table doesn't exist
				if ($errNo == 1146)
				{
					echo "Table doesn't exist<br>";
					exit;
				}
				else
				{
					//Output MySQL Error Codes & Error Messages
					print "<br>Error with MySQL!<br>";
					printf ("(" . $errNo . ": " . $errMes . ")<br>");
					exit;
				}
			}
		/****** END $b_statement for EXACT SEARCH ******************/

		/******* b_similar_statement for SIMILAR SEARCH **************/
			$b_similar_statement = "SELECT * FROM inventory WHERE isbn LIKE '%".$keyword_IN."%'";

			$similar_result = mysqli_query($db, $b_similar_statement);
			if (!$similar_result)
			{
				$errNo = mysqli_errno($db);
				$errMes = mysqli_error($db);

				//Table doesn't exist
				if ($errNo == 1146)
				{
					echo "Table doesn't exist<br>";
					exit;
				}
				else
				{
					//Output MySQL Error Codes & Error Messages
					print "<br>Error with MySQL!<br>";
					printf ("(" . $errNo . ": <br>" . $errMes . ")<br>");
					exit;
				}
			}
		/**** b_similar_statement for END SIMILAR SEARCH ************/

			$numresults = mysqli_num_rows($result);
			$similar_numresults = mysqli_num_rows($similar_result);

			//If both exact_result & similar_result NOT FOUND, send to Book_Not_Found.html
			if($numresults == 0 && $similar_numresults == 0)
			{
				die(header("Location: ../frontend/book_not_found.php"));
			}

			//Creating empty arrays (Exact & Similar)
			$exact_book_arr = array();
			$similar_book_arr = array();

			//If exact_result Found, set data into exact_book_arr
			if($numresults != 0)
			{
				while ($numresults != 0)
				{
					//Fetch a book selling info row as an associative array
					$b_row = $result->fetch_assoc();

					//Put into Exact_Book_Array, then send to Book_Result class
					$exact_book_arr[] = $b_row;

					$numresults--;
				}
			}

			//If similar_result Found, set data into similar_book_arr
			if($similar_numresults != 0)
			{
				while ($similar_numresults != 0)
				{
					//Fetch a book selling info row as an associative array
					$b_similar_row = $similar_result->fetch_assoc();

					//Put into Similar_Book_Array, then send to Book_Result class
					$similar_book_arr[] = $b_similar_row;					

					$similar_numresults--;
				}				
			}

			//Set $_SESSION['exact_book_arr'] & $_SESSION['similar_book_arr']
			if (session_id() == '')
			{
			session_start();
			}

			$_SESSION['exact_book_arr'] = $exact_book_arr;
			$_SESSION['similar_book_arr'] = $similar_book_arr;

			die(header("Location: ../frontend/search_result.php"));
		}
		/******** END BOOK SEARCH by ISBN *****************/		

		/******* BOOK SEARCH by TITLE ******************/
		/***** (Exact & Similar Search) *************/
		public function searchByTitle($keyword_IN)
		{
			require("../backend/dbstuffs.inc"); //Connecting to database

			$keyword_IN = mysqli_real_escape_string($db, $keyword_IN);

		/************ $b_statement for EXACT SEARCH ***************/
			$b_statement = "SELECT * FROM inventory WHERE title='$keyword_IN'";

			$result = mysqli_query($db, $b_statement);
			if (!$result)
			{
				$errNo = mysqli_errno($db);
				$errMes = mysqli_error($db);

				//Table doesn't exist
				if ($errNo == 1146)
				{
					echo "Table doesn't exist<br>";
					exit;
				}
				else
				{
					//Output MySQL Error Codes & Error Messages
					print "<br>Error with MySQL!<br>";
					printf ("(" . $errNo . ": " . $errMes . ")<br>");
					exit;
				}
			}
		/******** END $b_statement for EXACT SEARCH ****************/

		/******** b_similar_statement for SIMILAR SEARCH ************/
			$b_similar_statement = "SELECT * FROM inventory WHERE title LIKE '%".$keyword_IN."%'";

			$similar_result = mysqli_query($db, $b_similar_statement);
			if (!$similar_result)
			{
				$errNo = mysqli_errno($db);
				$errMes = mysqli_error($db);

				//Table doesn't exist
				if ($errNo == 1146)
				{
					echo "Table doesn't exist<br>";
					exit;
				}
				else
				{
					//Output MySQL Error Codes & Error Messages
					print "<br>Error with MySQL!<br>";
					printf ("(" . $errNo . ": <br>" . $errMes . ")<br>");
					exit;
				}
			}
		/****** b_similar_statement for END SIMILAR SEARCH *********/

			$numresults = mysqli_num_rows($result);
			$similar_numresults = mysqli_num_rows($similar_result);

			//If both exact_result & similar_result NOT FOUND, send to Book_Not_Found.html
			if($numresults == 0 && $similar_numresults == 0)
			{
				die(header("Location: ../frontend/book_not_found.php"));
			}

			//Creating empty arrays (Exact & Similar)
			$exact_book_arr = array();
			$similar_book_arr = array();

			//If exact_result Found, set data into exact_book_arr
			if($numresults != 0)
			{
				while ($numresults != 0)
				{
					//Fetch a book selling info row as an associative array
					$b_row = $result->fetch_assoc();

					//Put into Exact_Book_Array, then send to Book_Result class
					$exact_book_arr[] = $b_row;

					$numresults--;
				}
			}

			//If similar_result Found, set data into similar_book_arr
			if($similar_numresults != 0)
			{
				while ($similar_numresults != 0)
				{
					//Fetch a book selling info row as an associative array
					$b_similar_row = $similar_result->fetch_assoc();

					//Put into Similar_Book_Array, then send to Book_Result class
					$similar_book_arr[] = $b_similar_row;					

					$similar_numresults--;
				}				
			}

			//Set $_SESSION['exact_book_arr'] & $_SESSION['similar_book_arr']
			if (session_id() == '')
			{
			session_start();
			}

			$_SESSION['exact_book_arr'] = $exact_book_arr;
			$_SESSION['similar_book_arr'] = $similar_book_arr;

			die(header("Location: ../frontend/search_result.php"));

		/************ END BOOK SEARCH by TITLE *******************/
		}

		public function get_onsale_books()
		{
			require("dbstuffs.inc");

			if (session_id() == "") {
				session_start();
			}

			$sellerID = $_SESSION['userID'];
			$onsale_books_arr = array();

			$statement = "SELECT * FROM `inventory` WHERE `sellerID` ='$sellerID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}
			
			$numresults = mysqli_num_rows($result);
			if($numresults != 0) {
				while ($numresults != 0)
				{
					$row = $result->fetch_assoc();

					$onsale_books_arr[] = $row;

					$numresults--;
				}
			}

			$_SESSION['onsale_books_arr'] = $onsale_books_arr;
		} // End of function get_onsale_books

		public function deleting_a_listing($sellingID)
		{		
			require("dbstuffs.inc");

		//====== SEARCH & DELETE BY SELLING ID IN CART TABLE ========
			$current_number = 10;

			while ($current_number != 0)
			{
				$current_columm = 'item' . $current_number;

				$statement = "SELECT * FROM `cart` WHERE `$current_columm` = '$sellingID'";

				$result = mysqli_query($db, $statement);
				if (!$result)
				{
					printf ("<br>Error (%s)", mysqli_error($db));
					print "<br>Error with MySQL";
					exit;
				}

				$numresults = mysqli_num_rows($result);
				if($numresults != 0) {
					while ($numresults != 0)
					{
						$row = $result->fetch_assoc();

						$buyerID 		= $row['buyerID'];
						$cart_quantity 	= $row['cart_quantity'];
						$item_number 	= $current_number;
						$item_column 	= $current_columm;

						if ($item_number == $cart_quantity)
						{
							$cart_quantity--;

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
						} //End if function
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
						} //End else function

						$numresults--;
					}
				}

				$current_number--;				
			} // END OF while ($current_number != 0)
		//=== END OF SEARCH & DELETE BY SELLING ID IN CART TABLE ====	

		//============ DELETE THE LISTING FROM inventory ============	
			$statement = "DELETE FROM `inventory` WHERE `inventory`.`sellingID` = '$sellingID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}
		//======== END OF DELETE THE LISTING FROM inventory =========
			
		} // End of function deleting_a_listing

//=============== NEW IMPLEMENTATION ============================
		public function insert_exchange($sellingID, $ex_title, $ex_author, $ex_genre, $ex_isbn)
		{
			require("dbstuffs.inc"); //Connecting to database

			$accept_exchange = "Yes";
			$exchange_title  = mysqli_real_escape_string($db, $ex_title);
			$exchange_author = mysqli_real_escape_string($db, $ex_author);
			$exchange_genre  = mysqli_real_escape_string($db, $ex_genre);
			$exchange_isbn   = mysqli_real_escape_string($db, $ex_isbn);

			$statement = "UPDATE `inventory` SET ";
			$statement .= "accept_exchange = '$accept_exchange', ";
			$statement .= "exchange_title = '$exchange_title', ";
			$statement .= "exchange_author = '$exchange_author', ";
			$statement .= "exchange_genre = '$exchange_genre', ";
			$statement .= "exchange_isbn = '$exchange_isbn' ";
			$statement .= "WHERE `sellingID` = '$sellingID'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				printf ("<br>Error (%s)", mysqli_error($db));
				print "<br>Error with MySQL";
				exit;
			}

			die(header("Location: ../frontend/authenticated/listing_insert_exchange_complete.php"));			
		}
//=============== NEW IMPLEMENTATION ============================		





		/******* BOOK SEARCH by TITLE ******************/
		/***** (Exact & Similar Search) *************/
		public function searchByISBN_str($keyword_IN)
		{
			require("../backend/dbstuffs.inc"); //Connecting to database

			$keyword_IN = mysqli_real_escape_string($db, $keyword_IN);

		/************ $b_statement for EXACT SEARCH ***************/
			$b_statement = "SELECT * FROM inventory WHERE isbn='$keyword_IN'";

			$result = mysqli_query($db, $b_statement);
			if (!$result)
			{
				$errNo = mysqli_errno($db);
				$errMes = mysqli_error($db);

				//Table doesn't exist
				if ($errNo == 1146)
				{
					echo "Table doesn't exist<br>";
					exit;
				}
				else
				{
					//Output MySQL Error Codes & Error Messages
					print "<br>Error with MySQL!<br>";
					printf ("(" . $errNo . ": " . $errMes . ")<br>");
					exit;
				}
			}
		/******** END $b_statement for EXACT SEARCH ****************/

		/******** b_similar_statement for SIMILAR SEARCH ************/
			$b_similar_statement = "SELECT * FROM inventory WHERE isbn LIKE '%".$keyword_IN."%'";

			$similar_result = mysqli_query($db, $b_similar_statement);
			if (!$similar_result)
			{
				$errNo = mysqli_errno($db);
				$errMes = mysqli_error($db);

				//Table doesn't exist
				if ($errNo == 1146)
				{
					echo "Table doesn't exist<br>";
					exit;
				}
				else
				{
					//Output MySQL Error Codes & Error Messages
					print "<br>Error with MySQL!<br>";
					printf ("(" . $errNo . ": <br>" . $errMes . ")<br>");
					exit;
				}
			}
		/****** b_similar_statement for END SIMILAR SEARCH *********/

			$numresults = mysqli_num_rows($result);
			$similar_numresults = mysqli_num_rows($similar_result);

			//If both exact_result & similar_result NOT FOUND, send to Book_Not_Found.html
			if($numresults == 0 && $similar_numresults == 0)
			{
				die(header("Location: ../frontend/book_not_found.php"));
			}

			//Creating empty arrays (Exact & Similar)
			$exact_book_arr = array();
			$similar_book_arr = array();

			//If exact_result Found, set data into exact_book_arr
			if($numresults != 0)
			{
				while ($numresults != 0)
				{
					//Fetch a book selling info row as an associative array
					$b_row = $result->fetch_assoc();

					//Put into Exact_Book_Array, then send to Book_Result class
					$exact_book_arr[] = $b_row;

					$numresults--;
				}
			}

			//If similar_result Found, set data into similar_book_arr
			if($similar_numresults != 0)
			{
				while ($similar_numresults != 0)
				{
					//Fetch a book selling info row as an associative array
					$b_similar_row = $similar_result->fetch_assoc();

					//Put into Similar_Book_Array, then send to Book_Result class
					$similar_book_arr[] = $b_similar_row;					

					$similar_numresults--;
				}				
			}

			//Set $_SESSION['exact_book_arr'] & $_SESSION['similar_book_arr']
			if (session_id() == '')
			{
			session_start();
			}

			$_SESSION['exact_book_arr'] = $exact_book_arr;
			$_SESSION['similar_book_arr'] = $similar_book_arr;

			die(header("Location: ../frontend/search_result.php"));

		/************ END BOOK SEARCH by TITLE *******************/
		}
	} // End class Book
?>