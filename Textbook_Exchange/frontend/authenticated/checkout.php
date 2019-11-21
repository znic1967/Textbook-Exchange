<?php
	require_once("../../backend/ClassUser.php");
	require_once("../../backend/ClassCart.php");
	require_once("../../backend/ClassShipping.php");
	require_once("../../backend/ClassCard.php");
	require_once("../../backend/ClassOrder.php");

	if (session_id() == '') {
		session_start();
	}

	$user = new User;
	if (!$user->isLoggedIn) {
		die(header("Location: ../../frontend/login_required.php"));
	}

	$_SESSION['currentURL'] = "../frontend/authenticated/checkout.php";


	$userID = $_SESSION['userID'];

	$cart = new Cart;
	$item_arr = $_SESSION['item_arr'];
	$c_quan = $_SESSION['cart_quantity'];	

	$pickup_item_arr = array();
	$shipping_item_arr = array();

	$pickup_item_arr = $_SESSION['pickup_item_arr'];
	$shipping_item_arr = $_SESSION['shipping_item_arr'];
	$exchange_item_arr = $_SESSION['exchange_item_arr'];
	$listing_for_exchange = $_SESSION['listing_for_exchange'];

	if (count($shipping_item_arr) != 0)
	{
		$shipping = new Shipping;
		$shipping->print_all_shipping($userID);
		$shipping_arr = $_SESSION['shipping_arr'];

		$card = new Card;
		$card->print_all_cards($userID);
		$card_arr = $_SESSION['card_arr'];
	}

	$order = new Order;
	$sale_pending_quantity = count($_SESSION['sale_pending_arr']);	
	$fname=$_SESSION['firstname'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Checkout</title>
		<link rel="stylesheet" href="/frontend/styles/bootstrap.css">
		<link href = "../styles/checkout_style.css" rel="stylesheet">
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
	              <a class="nav-link" href="#">About</a>
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

		<form method="post" action="../../backend/ordering_process.php">





		<?php
			if (count($exchange_item_arr) != 0)
			{
		?>		
				<h1>Exchange Items</h1>
			<?php
				if (count($exchange_item_arr) == 1)
				{
			?>
				<p>
					We found this book available for exchange, and it's matched with your listings.
				</p>
			<?php		
				}
				else
				{
			?>
				<p>
					We found these books available for exchange, and they're matched with your listings.
				</p>			
			<?php
				}
			?>
				<p>Please review & place your order below. The seller(s) will contact you soon!</p>
				<table>

					<tr class="tab_head">
						<th class = "pic"></th>
						<th class = "item">Item(s)</th>
						<th class = "ex_meth">Exchange Method</th> 
						<th class = "price">Price</th>
					</tr>
		<?php
				for ($i = 0; $i < count($exchange_item_arr); $i++)
				{
					$titl 	= $exchange_item_arr[$i]['title'] ;
					$aut 	= $exchange_item_arr[$i]['author'] ;
					$isbn 	= $exchange_item_arr[$i]['isbn'];
					$seller = $exchange_item_arr[$i]['seller'];
					$prc 	= $exchange_item_arr[$i]['price'];

					$ex_title 	= $listing_for_exchange[$i]['title'];
					$ex_aut 	= $listing_for_exchange[$i]['author'];
					$ex_isbn 	= $listing_for_exchange[$i]['isbn'];
					$ex_prc 	= $listing_for_exchange[$i]['price'];

					$price = $prc - $ex_prc;
					
					if ($exchange_item_arr[$i]['exmethod'] == "local") {
						$exmethod = "Local Pickup";
					}
					else {
						$exmethod = "Shipping";
					}

					if ($exchange_item_arr[$i]['condi'] == "new") {
						$condi = "Brand New";
					}
					else if ($exchange_item_arr[$i]['condi'] == "likenew") {
						$condi = "Like New";
					}
					else if ($exchange_item_arr[$i]['condi'] == "good") {
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
							 echo "Price: $" . $prc . "<br>";
							 echo "<br>EXCHANGE WITH<br>";
							 echo  $ex_title . " by " . $ex_aut . " (";
							 echo "ISBN: " . $ex_isbn . ")<br>";
							 echo "Price: $" . $ex_prc . "<br>";
							?>
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
				</table><br>
		<?php						
			} // END OF if (count($exchange_item_arr) != 0)
		?>	





		<?php
			if (count($pickup_item_arr) != 0)
			{
		?>		
				<h1>Pickup Items</h1>
				
				<p>
					You have 
					<?php
						echo count($pickup_item_arr);
					?>
					pickup item(s) in your cart.
				</p>
				<p>Please review & place your order below. The seller(s) will contact you soon!</p>
				<table>

					<tr class="tab_head">
						<th class = "pic"></th>
						<th class = "item">Item(s)</th>
						<th class = "ex_meth">Exchange Method</th> 
						<th class = "price">Price</th>
					</tr>
		<?php
				for ($i = 0; $i < count($pickup_item_arr); $i++)
				{
					$titl 	= $pickup_item_arr[$i]['title'] ;
					$aut 	= $pickup_item_arr[$i]['author'] ;
					$isbn 	= $pickup_item_arr[$i]['isbn'];
					$seller = $pickup_item_arr[$i]['seller'];
					$price 	= $pickup_item_arr[$i]['price'];
					
					if ($pickup_item_arr[$i]['exmethod'] == "local") {
						$exmethod = "Local Pickup";
					}
					else {
						$exmethod = "Shipping";
					}

					if ($pickup_item_arr[$i]['condi'] == "new") {
						$condi = "Brand New";
					}
					else if ($pickup_item_arr[$i]['condi'] == "likenew") {
						$condi = "Like New";
					}
					else if ($pickup_item_arr[$i]['condi'] == "good") {
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
				</table><br>
		<?php						
			} // END OF if (count($pickup_item_arr) != 0)


			if (count($shipping_item_arr) != 0)
			{
		?>		
				<h1>Shipping Items</h1>

				<p>
					You have 
					<?php
						echo count($shipping_item_arr);
					?>
					shipping item(s) in your cart.
				</p>
				<br>
				<p>REVIEW YOUR ORDER BELOW</p>
				<table>

					<tr class="tab_head">
						<th class = "pic"></th>
						<th class = "item">Item(s)</th>
						<th class = "ex_meth">Exchange Method</th> 
						<th class = "price">Price</th>
					</tr>
		<?php
				for ($i = 0; $i < count($shipping_item_arr); $i++)
				{
					$titl 	= $shipping_item_arr[$i]['title'] ;
					$aut 	= $shipping_item_arr[$i]['author'] ;
					$isbn 	= $shipping_item_arr[$i]['isbn'];
					$seller = $shipping_item_arr[$i]['seller'];
					$price 	= $shipping_item_arr[$i]['price'];
					
					if ($shipping_item_arr[$i]['exmethod'] == "local") {
						$exmethod = "Local Pickup";
					}
					else {
						$exmethod = "Shipping";
					}

					if ($shipping_item_arr[$i]['condi'] == "new") {
						$condi = "Brand New";
					}
					else if ($shipping_item_arr[$i]['condi'] == "likenew") {
						$condi = "Like New";
					}
					else if ($shipping_item_arr[$i]['condi'] == "good") {
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

				<p>REVIEW YOUR SHIPPING ADDRESS BELOW</p>
				<br>
		<?php
				for ($i = 0; $i < count($shipping_arr); $i++)
				{
		?>
					<div class="selected_shipping">
		<?php

					$name = $shipping_arr[$i]['name'];
					$selected_address = $shipping_arr[$i]['address'];
					$city = $shipping_arr[$i]['city'];
					$state = $shipping_arr[$i]['state'];
					$zip = $shipping_arr[$i]['zip'];
					$phone = $shipping_arr[$i]['phone'];

					if ($i == 0) {
						echo "<input type='radio' name='selected_address' value='$i' checked> $name &#8211 $selected_address,  $city,  $state,  $zip &#8211 $phone<br>";
					}
					else {
						echo "<input type='radio' name='selected_address' value='$i'> $name &#8211 $selected_address,  $city,  $state,  $zip &#8211 $phone<br>";
					}
				}
		?>
					</div>
					<br>
					<a href="shipping_adding.php">Add a new address</a>
					<br><br><br><br>

					<p>REVIEW YOUR PAYMENT METHOD BELOW</p>
					<br>
		<?php
					for ($i = 0; $i < count($card_arr); $i++)
					{
		?>
					<div class="selected_card">
		<?php		
						/*echo "Card " . ($i + 1) . "<br>";
						echo "Name on card: "	. $card_arr[$i]['card_name'] . "<br>";
						echo "Card Number: "	. $card_arr[$i]['card_number'] . "<br>";
						echo "Exp: " 			. $card_arr[$i]['card_exp'] . "<br><br>";*/

						$card_name = $card_arr[$i]['card_name'];
						$selected_card_number = $card_arr[$i]['card_number'];
						//$output_selected_card_number = "**** **** **** " . substr($selected_card_number, -4);

						$output_selected_card_number = "&#8729&#8729&#8729&#8729 &#8729&#8729&#8729&#8729 &#8729&#8729&#8729&#8729 " . substr($selected_card_number, -4);

						//$output_selected_card_number = "&#183&#183&#183&#183 &#183&#183&#183&#183 &#183&#183&#183&#183 " . substr($selected_card_number, -4);

						//$output_selected_card_number = "&#9679&#9679&#9679&#9679 &#9679&#9679&#9679&#9679 &#9679&#9679&#9679&#9679 " . substr($selected_card_number, -4);


						if ($i == 0) {
							echo "<input type='radio' name='selected_card_number' value='$selected_card_number' checked> $card_name &#8211 $output_selected_card_number<br>";
						}
						else {
							echo "<input type='radio' name='selected_card_number' value='$selected_card_number'> $card_name &#8211 $output_selected_card_number<br>";
						}
					}
		?>
					</div>
					<br>
					<a href="card_adding.php">Add a credit card</a>
					<br><br><br><br>
		<?php			
			} // END OF if (count($shipping_item_arr) != 0)
		?>
			<input type="submit" value="Place Your Order">
			
		</form>





		<br><br><br><br><br><br>
		
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	    <script type="text/javascript" src="/frontend/js/bootstrap.js"></script>
	</body>
</html>