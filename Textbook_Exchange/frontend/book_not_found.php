<?php
  require_once("../backend/ClassUser.php");
  require_once("../backend/ClassCart.php");
  require_once("../backend/ClassOrder.php");

  $cart = new Cart;
  $c_quan = $_SESSION['cart_quantity'];
  if (session_id() == '')
    {
      session_start();
    }
  $user = new User;
  if (!$user->isLoggedIn)
  {
    $isLoggedIn=0;
  }
  else
  {
    $isLoggedIn=1;
  }

  $order = new Order;
  $sale_pending_quantity = count($_SESSION['sale_pending_arr']);
  
  $fname=$_SESSION['firstname'];
  $c_quan = $_SESSION['cart_quantity'];
?>
<!-- ============================================== -->
<!DOCTYPE html>
<html>
	<head >
		<meta charset="utf-8">
		<title>Search Result</title>
		<link rel="stylesheet" href="/frontend/styles/bootstrap.css">
		<link href = "styles/general.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">		
	</head>

	<body>

		<nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="/homepage.php">
            <img src="/img/logo_v8.png" alt="BookExchange">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="/homepage.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/frontend/AboutUs.php">About</a>
              </li>
<?php
  if (!$user->isLoggedIn)
  {
?>
            <li class="nav-item">
              <a class="nav-link" href="/frontend/authenticated/listing.php" id="sellbtn">Sell</a>
            </li>
            </li>
              <li class="nav-item" id="cartbtn">
            </li>            
<?php
  }
  else
  {
?>
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
<?php
  }
?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Hello, 
                  <?php 
                    if($isLoggedIn){
                      echo $fname;
                    }
                    else echo "Guest";
                  ?>
                </a>
                <div id="dropCnt" class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <!-- <div id="dropCnt"></div> -->
                </div>
              </li>
            </ul>
          </div>
    </nav>

    <div class="options">
		<h2>Book Not Found</h2>
		<p>This book is not available for sale yet.</p>
		<a href="/homepage.php">Continue Shopping</a>
	</div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/frontend/js/bootstrap.js"></script>
    <script>
      $(document).ready(function(){
        var loggedIn="<?php echo $isLoggedIn?>";
        console.log(loggedIn);
        if(loggedIn==0){
          $content1= $('<a class="dropdown-item" href="/backend/login_process.php">Login</a>');
          $content1.appendTo('#dropCnt');
          $content2=$('<a class="dropdown-item" href="/frontend/signup.html">Create Account</a>');
          $content2.appendTo('#dropCnt');

          $crt=$('<a class="nav-link" href="#NotLoggedIn">Cart</a>');
        }
        else{
          $content1= $('<a class="dropdown-item" href="/frontend/profilePage.php">Profile</a>');
          $content1.appendTo('#dropCnt');

          $content2= $('<a class="dropdown-item" href="/frontend/authenticated/order_history.php">Your Orders</a>');
          $content2.appendTo('#dropCnt');

          $content3=$('<a class="dropdown-item" href="/backend/signout_process.php">Logout</a>');
          $content3.appendTo('#dropCnt');

          $crt=$('<a class="nav-link" id="carticon" data-badge="<?php echo $c_quan?>"" href="/frontend/authenticated/cart.php">Cart</a>');
        }
        $crt.appendTo('#cartbtn');

    });

    </script>
		
	</body>
</html>    