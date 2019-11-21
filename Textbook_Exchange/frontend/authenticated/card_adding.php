<?php
	require_once("../../backend/ClassUser.php");
	require_once("../../backend/ClassCart.php");
	require_once("../../backend/ClassOrder.php");

	if (session_id() == '') {
		session_start();
	} 

	$cart = new Cart;
	$c_quan = $_SESSION['cart_quantity'];

	$user = new User;
	if (!$user->isLoggedIn)
	{
		die(header("Location: ../login_required.php"));
	}
	$fname=$_SESSION['firstname'];
	$order = new Order;
	$sale_pending_quantity = count($_SESSION['sale_pending_arr']);	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Payment Method</title>
		<link rel="stylesheet" href="/frontend/styles/bootstrap.css">
		<link href = "../styles/card_adding_style.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>

		<nav class="navbar navbar-expand-lg navbar-light">
		      <a class="navbar-brand" href="/frontend/authenticated/authenticated_homepage.php">
		        <img id="altlogo" src="/img/logo_v8.png" alt="BookExchange">
		      </a>
		      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
		        <span class="navbar-toggler-icon"></span>
		      </button>

		      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
		        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
		          <li class="nav-item">
		            <a class="nav-link" href="/frontend/authenticated/authenticated_homepage.php">Home</a>
		          </li>
		          <li class="nav-item">
		            <a class="nav-link" href="/frontend/aboutUs.php">About</a>
		          </li>

			<li class="nav-item">
		<!-- ==== FIXING FOR cartion (SELLING) DISPLAYING PROCESS ============
	<a class="nav-link" href="/frontend/authenticated/listing.php">Sell</a>
		========= FIXING FOR cartion (SELLING) DISPLAYING PROCESS ======= -->

<?php
	if ($sale_pending_quantity == 0)
	{
		echo "<a class='nav-link' href='../../backend/listing_displaying_process.php'>Sell</a>";
	}
	else
	{
		echo "<a class='nav-link' id='carticon' data-badge='$sale_pending_quantity' href='../../backend/listing_displaying_process.php'>Sell</a>";
	}				
?>
			</li>

			<li class="nav-item"> 
			<!-- ==== FIXING FOR cartion (CART) DISPLAYING PROCESS ===========
				<a class="nav-link" id="carticon" data-badge='<?php //echo $c_quan?>' href="/frontend/authenticated/cart.php">Cart</a>
			========= FIXING FOR cartion (CART) DISPLAYING PROCESS ======= -->
<?php
	if ($cart->is_empty())
	{
		echo "<a class='nav-link' href='../../backend/cart_displaying_process.php'>Cart</a>";
	}
	else
	{
		echo "<a class='nav-link' id='carticon' data-badge='$c_quan' href='../../backend/cart_displaying_process.php'>Cart</a>";
	}
?>
			</li>

		          <li class="nav-item dropdown">
		            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		              Hello, <?php echo $fname?>
		            </a>
		            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
		              <a class="dropdown-item" href="/frontend/profilePage.php">Profile</a>
		              <a class="dropdown-item" href="order_history.php">Your Orders</a>
		              <a class="dropdown-item" href="/backend/signout_process.php">Logout</a>
		            </div>
		          </li>
		        </ul>
		      </div>
		</nav>

		<div class="row">
	    	<div class="col-sm" id="maincol">
	    		<div class="options">
		    		<h2>Payment Method</h2>
				</div>
				<form class="formCnt" method="post" action="/backend/card_inserting_process.php">
					<div class="row"><input type="text" placeholder="Name on card" name="card_name"></div>
					<div class="row"><input type="text" placeholder="Card number" name="card_number"></div>
					<div class="row"><input type="date" placeholder="Expiration date" name="card_exp"></div>
					<div class="row"><input type="text" placeholder="CVV" name="card_cvv"></div>
					<div class="row"><input type="text" placeholder="Address" name="card_address"></div>
					<div class="row"><input type="text" placeholder="City" name="card_city"></div>
					<div class="row"><input type="text" placeholder="State" name="card_state"></div>
					<div class="row"><input type="text" placeholder="Zip" name="card_zip"></div>
					<div id="btnpad">
						<button class="sButton" type="submit"> Add Payment Method </button>
					</div>
				</form>
			</div>	
		</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/frontend/js/bootstrap.js"></script>
	</body>
</html>