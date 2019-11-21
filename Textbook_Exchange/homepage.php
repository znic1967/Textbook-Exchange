<?php
  require_once("backend/ClassUser.php");

  $user = new User;

  if ($user->isLoggedIn)
  {
    die(header("Location: frontend/authenticated/authenticated_homepage.php"));
  }
?>

<!DOCTYPE html>
<html>
	<head >
		<meta charset="utf-8">
		<title>Textbook Exchange</title>
		<link rel="stylesheet" href="/frontend/styles/bootstrap.css">
    <link href = "/frontend/styles/homepage_style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="homepage.php">
            <img src="/img/logo_v8.png" alt="BookExchange">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="homepage.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/frontend/AboutUs.php">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/frontend/authenticated/listing.php" id="sellbtn">Sell</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#NotLoggedIn" id="cartbtn">Cart</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Hello, Guest
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="/frontend/login.html">Login</a>
                  <a class="dropdown-item" href="/frontend/signup.html">Create Account</a>
                </div>
              </li>
            </ul>
          </div>
    </nav>

    <form class="search_bar" style="margin:auto;max-width:700px" method="post" action="backend/search_process.php">
      <input type="text" placeholder="Enter Titles or ISBN #" name="keyword">
      <button type="submit"> <i class="fa fa-search"></i> </button>
    </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/frontend/js/bootstrap.js"></script>

    <script>
      $(document).ready(function(){
      $("#cartbtn").click(function(){
          alert("Please login to view cart.");
        });
      $("#sellbtn").click(function(){
          event.preventDefault();
          alert("Please login to sell items.");
        });
    });
    </script>
	</body>
</html>