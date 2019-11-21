<?php
	require_once("../../backend/ClassUser.php");
	require_once("../../backend/ClassCart.php");
	require_once("../../backend/ClassOrder.php");

	if (session_id() == '') {
		session_start();
	}

	$user = new User;
	if (!$user->isLoggedIn)
	{
		$_SESSION['currentURL'] = "../frontend/authenticated/cart.php";

		die(header("Location: ../login_required.php"));
	}

	$cart = new Cart;
	if ($cart->is_empty()) {
		die(header("Location: cart_empty.php"));
	}

	$item_arr = $_SESSION['item_arr'];
	$c_quan = $_SESSION['cart_quantity'];

	$order = new Order;
	$sale_pending_quantity = count($_SESSION['sale_pending_arr']);	

	$fname=$_SESSION['firstname'];
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cart</title>
		<link rel="stylesheet" href="/frontend/styles/bootstrap.css">
		<link href = "../styles/cart_style.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>
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
		      <a class="dropdown-item" href="/frontend/profilePage.php">Profile</a>
		      <a class="dropdown-item" href="order_history.php">Your Orders</a>
		      <a class="dropdown-item" href="/backend/signout_process.php">Logout</a>
		    </div>
		  </li>
		</ul>
	  </div>
	</nav>


		<table>

			<tr class="tab_head">
				<th class = "pic"></th>
				<th class = "item">Item(s)</th>
				<th class = "ex_meth">Exchange Method</th> 
				<th class = "price">Price</th>
			</tr>

			<?php

				$item_number = count($item_arr); //NEED THIS FOR DELETING AN ITEM
				//$tot_price = 0;

				for ($i = 0; $i < count($item_arr); $i++)
				{
					$titl 	= $item_arr[$i]['title'] ;
					$aut 	= $item_arr[$i]['author'] ;
					$isbn 	= $item_arr[$i]['isbn'];
					$seller = $item_arr[$i]['seller'];
					$price 	= $item_arr[$i]['price'];
					
					if ($item_arr[$i]['exmethod'] == "local") {
						$exmethod = "Local Pickup";
					}
					else {
						$exmethod = "Shipping";
					}

					if ($item_arr[$i]['condi'] == "new") {
						$condi = "Brand New";
					}
					else if ($item_arr[$i]['condi'] == "likenew") {
						$condi = "Like New";
					}
					else if ($item_arr[$i]['condi'] == "good") {
						$condi = "Good";
					}
					else {
						$condi = "Acceptable";
					}

					$tot_price = $tot_price + $price;
			?>
				
					<tr class = "dat_cell">
						<td class = "pic">
							<img src="../../img/book.png" alt="Book Image">
						</td>

						<td class = "item">
							<?php
							 echo $titl . " by " . $aut . " (" . $condi . ")<br>";
							 echo "ISBN: " . $isbn . "<br>";
							 echo "Sold by: " . $seller . "<br>";
							?>
							<form method="post" action="../../backend/cart_deleting_process.php">
								<input type="hidden" name="item_number" value="<?php echo htmlspecialchars($item_number); ?>">   

							<?php
								$item_number--;
							?>

								<input type="submit" value="Delete this item">
							</form>				
						</td>

						<td class = "ex_meth">
							<?php
								echo $exmethod;
							?>
						</td>

						<td class = "price">
							<?php
								echo "$" . $price;
							?>
						</td>
					</tr>

			<?php
				}
			?>


			<tr class = "dat_cell">
				<td class = "pic">
				</td>

				<td class = "item">
				</td>

				<td class = "sub_tot">
					<?php
						if (count($item_arr) == 1) {
							echo "Subtotal (" . count($item_arr) . " item):";
						}
						else {
							echo "Subtotal (" . count($item_arr) . " items):";
						}
					?>
				</td>

				<td class = "tot_price">
					<?php
						echo "$" . $tot_price;
					?>
				</td>
			</tr>

		</table>

		<form method="post" action="../../backend/checkout_process.php">
			<input type="submit" value="Proceed to checkout">	
		</form>

		<br><br><br><br><br><br>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/frontend/js/bootstrap.js"></script>
	</body>
</html>