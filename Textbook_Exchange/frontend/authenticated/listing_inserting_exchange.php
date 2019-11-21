<?php
	require_once("../../backend/ClassUser.php");
	require_once("../../backend/ClassCart.php");
	require_once("../../backend/ClassOrder.php");

	if (session_id() == '') {
		session_start();
	} 

	$cart = new Cart;
	$c_quan = $_SESSION['cart_quantity'];

	$order = new Order;
	$sale_pending_quantity = count($_SESSION['sale_pending_arr']);

	$user = new User;
	if (!$user->isLoggedIn)
	{
		$_SESSION['currentURL'] = "listing_displaying_process.php";

		die(header("Location: ../login_required.php"));
	}
	$fname=$_SESSION['firstname'];

//=============== NEW IMPLEMENTATION ============================
	$recent_sellingID = $_SESSION['recent_listing']['sellingID'];
//=============== NEW IMPLEMENTATION ============================	
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Selling</title>
		<link rel="stylesheet" href="/frontend/styles/bootstrap.css">
		<link href = "../styles/listing_style.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>


		<!-- ======== SIDENAV for Selling ==== -->
		<nav class="sidenav">
			<div class="sidenav_box">
				<ul>

					<div class="active_sidenav_box">
						<li>
							<a href="../../frontend/authenticated/listing.php">
								<i class="fa fa-usd fa-2x"></i>
								<span class="nav-text">
									Sell Your Book
								</span>
							</a>
						</li>
					</div>

					<li>
						<a href="../../frontend/authenticated/manage_listing.php">
							<i class="fa fa-list fa-2x"></i>
							<span class="nav-text">
								Manage Selling
							</span>
						</a>
					</li>

					<li>
						<a href="listing_selling_history.php">
							<i class="fa fa-history fa-2x"></i>
							<span class="nav-text">
								Selling History
							</span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
		<!-- ======== SIDENAV for selling ==== -->


		

	<nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="/frontend/authenticated/authenticated_homepage.php">
          <img src="/img/logo_v8.png" alt="BookExchange">
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
                <a class="dropdown-item" href="/frontend/profilePage.php"">Profile</a>
                <a class="dropdown-item" href="order_history.php">Your Orders</a>
                <a class="dropdown-item" href="/backend/signout_process.php">Logout</a>
              </div>
            </li>
          </ul>
        </div>
    </nav>


	<h1>Insert your desired book for exchange</h1>

		<form method="post" action="../../backend/listing_insert_exchange_process.php">

			<table>

				<tr>
					<td>Book Title</td>
					<td><input type="text" placeholder="Book Title" name="ex_title"></td>
				</tr>

				<tr>
					<td>Author</td>
					<td><input type="text" placeholder="Author" name="ex_author"></td>
				</tr>

				<tr>
					<td>Genre</td>
					<td><input type="text" placeholder="Genre" name="ex_genre"></td>
				</tr>

				<tr>
					<td>ISBN#</td>
					<td><input type="text" placeholder="ISBN#" name="ex_isbn"></td>
				</tr>

			</table>

			<input type="hidden" name="sellingID" value="<?php echo htmlspecialchars($recent_sellingID); ?>">			

			<input type="submit" value="Add to your listing">

		</form>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	    <script type="text/javascript" src="/frontend/js/bootstrap.js"></script>
	</body>
</html>