<?php
  require_once("../backend/ClassUser.php");

  require_once("../backend/ClassCart.php");
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

  $fname=$_SESSION['firstname'];
  $c_quan = $_SESSION['cart_quantity'];
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Team Section</title>
  <link rel="stylesheet" href="/frontend/styles/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/frontend/styles/AboutUsStyle.css">


</head>
Of 
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
              <li class="nav-item">
                <a class="nav-link" href="/frontend/authenticated/listing.php" id="sellbtn">Sell</a>
              </li>
              <li class="nav-item" id="cartbtn">
              </li>
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

	<div class="team-section">
		<h1>Our Team</h1>
		
		<div class ="ps" >
			<a href="#p1"><img src="../img/testimonial.png" alt=""></a>
			<a href="#p2"><img src="../img/testimonial.png" alt=""></a>
			<a href="#p3"><img src="../img/testimonial.png" alt=""></a>
			<a href="#p4"><img src="../img/testimonial.png" alt=""></a>
			<a href="#p5"><img src="../img/testimonial.png" alt=""></a>
		</div>
        <div class"section" id="p1">
        	<span class ="name">Mike</span>
        	<span class="border"></span>
        	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. L</p>	
        </div>
        <div class"section" id="p2">
        	<span class ="name">Patrick</span>
        	<span class="border"></span>
        	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. L</p>
        	
        </div>
        <div class"section" id="p3">
        	<span class ="name">Zack</span>
        	<span class="border"></span>
        	<p>From a young age it was obvious I would become an engineer. Sky high Lego creations transitioned to complex robotics projects and soon enough I began studying computer engineering. I hope my passion for technology and increasing computer knowledge will land me an engineering position here in Silicon Valley.</p>
        <div class"section" id="p4">
        	<span class ="name">Derick</span>
        	<span class="border"></span>
        	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. L</p>
        </div>
        <div class"section" id="p5">
        	<span class ="name">Chuefeng</span>
        	<span class="border"></span>
        	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. L</p>
        </div>
        	
        </div>

	</div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/frontend/js/bootstrap.js"></script>
    <script>
      $(document).ready(function(){
        var loggedIn="<?php echo $isLoggedIn?>";
        console.log(loggedIn);
        if(loggedIn==0){
          $content1= $('<a class="dropdown-item" href="/frontend/login.html">Login</a>');
          $content1.appendTo('#dropCnt');
          $content2=$('<a class="dropdown-item" href="/frontend/signup.html">Create Account</a>');
          $content2.appendTo('#dropCnt');

          $crt=$('<a class="nav-link" href="#NotLoggedIn">Cart</a>');
          $("#cartbtn").click(function(){
          alert("Please login to view cart.");
          });
        $("#sellbtn").click(function(){
          event.preventDefault();
          alert("Please login to sell items.");
          });
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