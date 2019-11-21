<?php
	class User
	{
		public $userID;
		public $firstname;
		public $lastname;
		public $email;
		public $address;
		public $city;
		public $state;
		public $zip;
		public $location;
		public $phone;
		public $isLoggedIn = false;

		//(pg. 610)
		//The constructor for the User class first checks to see if the session is
		//started (this will be a common theme for most of the functions in the class).
		function __construct()
		{
			require("dbstuffs.inc");

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

			if (session_id() == "")
			{
				session_start();
			}
			
			if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true)
			{
				$this->_initUser();
			}
		} //end __construct

		//(pg. 610)
		//The initUser function grabs the user’s information from the session
		//and sets each of the elements of their information asproperties.
		private function _initUser()
		{
			if (session_id() == "")
			{
				session_start();
			}

			$this->userID = $_SESSION['userID'];
			$this->firstname = $_SESSION['firstname'];
			$this->lastname = $_SESSION['lastname'];
			$this->email = $_SESSION['email'];
			$this->address = $_SESSION['address'];
			$this->city = $_SESSION['city'];
			$this->state = $_SESSION['state'];
			$this->zip = $_SESSION['zip'];
			$this->location = $_SESSION['location'];
			$this->phone = $_SESSION['phone'];
			$this->isLoggedIn = $_SESSION['isLoggedIn'];
		} //end function initUser

		//(pg.610)
		//The authenticate function is used to check the credentials entered on the
		//form against what’s in the database. A database connection is created and a
		//query is built using the e-mail address entered on the login form. If no user
		//is found with that e-mail address, an error is logged behind the scenes and
		//false is returned from the function.
		public function authenticate($usernameIN,$passwordIN)
		{
			//Connect to the Database
			$host = 'localhost';
			$user = 'admin';
			$pwd = 'admin';
			$dbname = 'TxtExDB';

			$db = mysqli_connect($host, $user, $pwd, $dbname);

			//Check if Database is connected
			if(!$db)
			{
				print "<h1>Unable to Connect to MySQL</h1>";
				return false;
				exit;
			}

			$usernameIN = mysqli_real_escape_string($db, $usernameIN);
			$passwordIN = mysqli_real_escape_string($db, $passwordIN);

			$statement = "SELECT * FROM users WHERE username='$usernameIN' AND password='$passwordIN'";

			$result = mysqli_query($db, $statement);
			if (!$result)
			{
				$errNo = mysqli_errno($db);
				$errMes = mysqli_error($db);

				//Table doesn't exist, request user to create an account
				if ($errNo == 1146)
				{
					die(header("Location: ../frontend/signup_required.html"));
				}
				else
				{
					//Output MySQL Error Codes & Error Messages
					print "<br>Error with MySQL!<br>";
					printf ("(" . $errNo . ": " . $errMes . ")<br>");
					return false;
					exit;
				}
			}

			$numresults = mysqli_num_rows($result);
			if($numresults != 1)
			{
				//Send user back to login_failed.html
				die(header("Location: ../frontend/login_failed.html"));
			}

			//Fetch a result row as an associative array (Object oriented style)
			$row = $result->fetch_assoc();

			$this->userID = $row['userID'];
			$this->firstname = $row['firstname'];
			$this->lastname = $row['lastname'];
			$this->email = $row['email'];
			$this->address = $row['address'];
			$this->city = $row['city'];
			$this->state = $row['state'];
			$this->zip = $row['zip'];
			$this->location = $row['location'];
			$this->phone = $row['phone'];
			$this->isLoggedIn = true;

			$this->_setSession();

			return true;
		} //end function authenticate

		//(pg. 610)
		//With the user successfully authenticated, set the various details from the
		//database into properties and call the setSession() function. The setSession()
		//function takes the properties and sets them into the session so that
		//they can be used on other pages of the application.
		private function _setSession()
		{
			if (session_id() == ‘’)
			{
				session_start();
			}

			$_SESSION['userID'] = $this->userID;
			$_SESSION['firstname'] = $this->firstname;
			$_SESSION['lastname'] = $this->lastname;
			$_SESSION['email'] = $this->email;
			$_SESSION['address'] = $this->address;
			$_SESSION['city'] = $this->city;
			$_SESSION['state'] = $this->state;
			$_SESSION['zip'] = $this->zip;
			$_SESSION['location'] = $this->location;
			$_SESSION['phone'] = $this->phone;
			$_SESSION['isLoggedIn'] = $this->isLoggedIn;
		} //end function setSession

		//Signout Function
		public function signout() {
			$this->isLoggedIn = false;

			if (session_id() == '') {
				session_start();
			}

			$_SESSION['isLoggedIn'] = false;

			session_destroy();
		} //End of Signout
	} // End class User
?>