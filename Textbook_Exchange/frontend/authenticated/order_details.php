<?php
	require_once("../../backend/ClassUser.php");
	require_once("../../backend/ClassCart.php");
	require_once("../../backend/ClassOrder.php");

	if (session_id() == '') {
		session_start();
	}

	$user = new User;
	if (!$user->isLoggedIn) {
		die(header("Location: ../login_required.php"));
	}

	$cart = new Cart;
	$c_quan = $_SESSION['cart_quantity'];	

	$order = new Order;
	$sale_pending_quantity = count($_SESSION['sale_pending_arr']);

	if (isset($_SESSION['orderID_details']) && ($_SESSION['orderID_details']['order_quantity'] > 0))
	{
		$orderID_details = $_SESSION['orderID_details'];
	}
	else {
		die(header("Location: order_history.php"));
	}
	$fname=$_SESSION['firstname'];
	$c_quan = $_SESSION['cart_quantity'];
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Order Details</title>
		<link rel="stylesheet" href="/frontend/styles/bootstrap.css">
		<link href = "../styles/order_history_style.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-light">
		      <a class="navbar-brand" href="#">
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

		<h1>
			Order Details
		</h1>


		<br>
		<p class="order_details">Order #: <?php echo $orderID_details['orderID']; ?></p>
		<p class="order_details">Total: $<?php echo $orderID_details['order_subtotal']; ?></p>
		<p class="order_details">
			Quantity:
			<?php 
				echo $orderID_details['order_quantity'];
				
				if ($orderID_details['order_quantity'] == 1) {
					echo " item";
				}
				else {
					echo " items";
				}
			?>
		</p>
		<p class="order_details">Seller: <?php echo $orderID_details['seller_name']; ?></p>
		<p class="order_details">
			Order placed on:
			<?php
				$doo = date($orderID_details['date_of_order'] . " " . $orderID_details['time_of_order']);
				$doo = date('Y/m/d', strtotime($doo));
				$eta = date('Y/m/d', strtotime($doo . ' +7 days'));
				$current_date = date("Y/m/d h:i:s");

				echo $doo . "<br>";
			?>	
		</p>

		<!-- If shipping items, show shipping address & payment method -->
		<?php
		if ($orderID_details['status'] == "Sold")
		{
			if ($orderID_details['exmethod'] == "ship")
			{
		?>
				<p class="order_details">
					<?php

						if ($eta > $current_date)
						{
							echo "(Estimated Arrival: " . $eta . ")";
						}
					?>	
				</p>		
		<?php
				echo "<p class='order_details'>Payment Method: ";
				echo $orderID_details['card_name'] . " &#8211 ";

				$card_number = $orderID_details['card_number'];
				$output_card_number = "&#8729&#8729&#8729&#8729 &#8729&#8729&#8729&#8729 &#8729&#8729&#8729&#8729 " . substr($card_number, -4);
				echo $output_card_number;

				echo "</p>";

				echo "<p class='order_details'>Shipping Information: ";
				echo $orderID_details['shipping_name'] . " &#8211 ";
				echo $orderID_details['shipping_address'] . ", ";
				echo $orderID_details['shipping_city'] . ", ";
				echo $orderID_details['shipping_state'] . ", ";
				echo $orderID_details['shipping_zip'] . " &#8211 ";
				echo $orderID_details['shipping_phone'];

				echo "</p><br>";
			} // END OF if ($orderID_details['exmethod'] == "ship")
			else
			{
				echo "<p class='order_details'>Status: Sold</p>";
			} // END OF else
		} // END OF if ($orderID_details['status'] == "Sold")
		else
		{
			if ($orderID_details['exmethod'] == "ship") {
				echo "<p class='order_details'>Status: The seller will ship your order shortly</p>";
			}
			else {
				echo "<p class='order_details'>Status: The seller will contact you for a meetup shortly</p>";
			}
		}
		?>
		<!-- If shipping items, show shipping address & payment method -->



		<table>

			<tr class="tab_head">
				<th class = "pic">Item</th>
				<th class = "item">Information</th>
				<th class = "ex_meth">Exchange Method</th> 
				<th class = "price">Price</th>
			</tr>	


<?php
		for ($i = 1; $i <= ($orderID_details['order_quantity']); $i++)
		{
			$title_column = "title_item" . $i;
			$author_column = "author_item" . $i;
			$genre_column = "genre_item" . $i;
			$isbn_column = "isbn_item" . $i;
			$description_column = "description_item" . $i;
			$condi_column = "condi_item" . $i;
			$price_column = "price_item" . $i;

			$ex_title_column = "ex_title_item" . $i;
			$ex_author_column = "ex_author_item" . $i;
			$ex_isbn_column = "ex_isbn_item" . $i;
			$ex_price_column = "ex_price_item" . $i;

			$title 	= $orderID_details["$title_column"];
			$author 	= $orderID_details["$author_column"];
			$genre = $orderID_details["$genre_column"];
			$isbn 	= $orderID_details["$isbn_column"];
			$description = $orderID_details["$description_column"];
			$condition = $orderID_details["$condi_column"];
			$price = $orderID_details["$price_column"];

			$ex_title 	= $orderID_details["$ex_title_column"];
			$ex_author 	= $orderID_details["$ex_author_column"];
			$ex_isbn 	= $orderID_details["$ex_isbn_column"];
			$ex_price = $orderID_details["$ex_price_column"];			

			if ($condition == "new") {
				$condi = "Brand New";
			}
			else if ($condition == "likenew") {
				$condi = "Like New";
			}
			else if ($condition == "good") {
				$condi = "Good";
			}
			else {
				$condi = "Acceptable";
			}

			if ($orderID_details['exmethod'] == "local") {
				$exmethod = "Local Pickup";
			}
			else {
				$exmethod = "Shipping";
			}
?>
			<tr class = "dat_cell">
				<td class = "pic">
					<p><?php echo $i ?></p>
				</td>

		<?php
			if (empty($ex_title))
			{
		?>
				<td class = "item">
					<?php
						echo $title . " by " . $author . " (" . $condi . ")<br>";
						echo "ISBN: " . $isbn . "<br>";

						if (!empty($genre)) {
							echo "Genre: " . $genre . "<br>";
						}
						if (!empty($description)) {
							echo "Description: " . $description . "<br>";
						}						
					?>
				</td>

				<td class = "ex_meth">
					<?php echo $exmethod; ?>
				</td>

				<td class = "price">
					<?php echo "$" . $price; ?>
				</td>
			</tr>					
<?php
			}
			else
			{
		?>
				<td class = "item">
					<?php
						echo $title . " by " . $author . " (" . $condi . ")<br>";
						echo "ISBN: " . $isbn . "<br>";
						echo "Price: $" . $price . "<br><br>";

						if (!empty($genre)) {
							echo "Genre: " . $genre . "<br>";
						}
						if (!empty($description)) {
							echo "Description: " . $description . "<br>";
						}

						echo "EXCHANGE WITH<br>";
						echo $ex_title . " by " . $ex_author . " (ISBN: " . $isbn . ")<br>";
						echo "Price: $" . $ex_price . "<br>";
					?>
				</td>

				<td class = "ex_meth">
					<?php echo $exmethod; ?>
				</td>

				<td class = "price">
					<?php
						$diff = $price - $ex_price;
						echo "$" . $diff;
					?>
				</td>
			</tr>		
		<?php		
			}
		} //END OF FOR LOOP
?>
		</table><br><br>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/frontend/js/bootstrap.js"></script>
	</body>
</html>