<?php
	require_once("../backend/ClassUser.php");
  require_once("../backend/ClassCart.php");
  require_once("../backend/ClassOrder.php");

  $cart = new Cart;

  $item_arr = $_SESSION['item_arr'];
  $c_quan = $_SESSION['cart_quantity'];

  if (session_id() == '')
  {
    session_start();
  }

  $exact_book_arr = $_SESSION['exact_book_arr'];
  $similar_book_arr = $_SESSION['similar_book_arr'];

  $order = new Order;
  $sale_pending_quantity = count($_SESSION['sale_pending_arr']);    

  //unset($_SESSION['exact_book_arr']);
 // unset($_SESSION['similar_book_arr']);

  

  $fname=$_SESSION['firstname'];
  $exact_total=count($exact_book_arr);
  $similar_total=count($similar_book_arr);
  $similar_col_start=$exact_total%3;

  $user = new User;
  if (!$user->isLoggedIn)
  {
    $isLoggedIn=0;
    $_SESSION['currentURL'] = "../frontend/search_result.php"; 
  }
  else
  {
    $isLoggedIn=1;
  }
?>
<!-- ============================================== -->

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../frontend/styles/bootstrap.css">
    <link href = "../frontend/styles/search_page.css" rel="stylesheet">

    <title>BookExchange</title>
    
  </head>
  <body>
    <div class="navimg">
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
              <a class="nav-link" href="/homepage.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/frontend/aboutUs.php">About</a>
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
              <div id="dropCnt" class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"></div>
            </li>
          </ul>
        </div>
    </nav>
  </div>
    <h1>Search Results</h1>
    <div class="container-fluid">
    	<h2>Exact Results</h2>
    	<p><?php
    		if ($exact_total==0)
    		{
    			echo "No Results.<br>";
    		}
    	?></p>
      <div class="row">
        <div class="col-sm">
          <div class="bookcol" id="ebookcol1"></div>
        </div>
        <div class="col-sm">
          <div class="bookcol" id="ebookcol2"></div>
        </div>
        <div class="col-sm">
          <div class="bookcol" id="ebookcol3"></div>
      </div>
    </div>
</div>
	<div class="container-fluid">
	   	<h2>Similar Results</h2>

	   	<p><?php
    		if ($similar_total==0)
    		{
    			echo "No Results.<br>";
    		}
    	?></p>
	   <div class="row">
        <div class="col-sm">
          <div class="bookcol" id="sbookcol1"></div>
        </div>
        <div class="col-sm">
          <div class="bookcol" id="sbookcol2"></div>
        </div>
        <div class="col-sm">
          <div class="bookcol" id="sbookcol3"></div>
        </div>
      </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../frontend/js/bootstrap.js"></script>
    <script>
      $(document).ready(function(){
        var etotal="<?php echo $exact_total?>";
        var ary =<?php echo json_encode($exact_book_arr)?>; //Converts php array to js array
        for (i=0;i<etotal;i=i+3)
        {
          var txt="";
          var sid=ary[i]['sellingID'];
          var uid=ary[i]['userID'];

          txt+= "Title: " + ary[i]['title'] + "<br>";
          txt+= "Author: " + ary[i]['author'] + "<br>";
          txt+= "Genre: " + ary[i]['genre'] + "<br>";
          txt+= "ISBN: " + ary[i]['isbn'] + "<br>";
          txt+= "Description: " + ary[i]['description'] + "<br>";
          txt+= "Condition: " + ary[i]['condi'] + "<br>";
          txt+= "Exchange Method: " + ary[i]['exmethod'] + "<br>";
          txt+= "Price: $" + ary[i]['price'] + "<br>";
          //console.log(sid);
          var book_container = $(document.createElement('div'));
          var description = "<p>" + txt + "</p>";
          var img = $(document.createElement('img'));
          img.attr('src', '../img/book.png');

          $form= $('<form  action="../backend/cart_adding_process.php" method="post"></form>');
          $form.append('<input class="cartbtn" type="submit" name="someAction" value="Add to Cart" />');
          $form.append('<input type="hidden" name="sellingID" value="'+sid+'"/>');
          //$form.append('<input type="hidden" name="uid" value="'+uid+'"/>');
          img.appendTo(book_container);
          book_container.append(description);
          $form.appendTo(book_container);
          book_container.appendTo('#ebookcol1');
        }
        for (i=1;i<etotal;i=i+3)
        {
          var txt="";
          var sid=ary[i]['sellingID'];
          var uid=ary[i]['userID'];

          txt+= "Title: " + ary[i]['title'] + "<br>";
          txt+= "Author: " + ary[i]['author'] + "<br>";
          txt+= "Genre: " + ary[i]['genre'] + "<br>";
          txt+= "ISBN: " + ary[i]['isbn'] + "<br>";
          txt+= "Description: " + ary[i]['description'] + "<br>";
          txt+= "Condition: " + ary[i]['condi'] + "<br>";
          txt+= "Exchange Method: " + ary[i]['exmethod'] + "<br>";
          txt+= "Price: $" + ary[i]['price'] + "<br>";
          //console.log(sid);
          var book_container = $(document.createElement('div'));
          var description = "<p>" + txt + "</p>";
          var img = $(document.createElement('img'));
          img.attr('src', '../img/book.png');

          $form= $('<form  action="../backend/cart_adding_process.php" method="post"></form>');
          $form.append('<input class="cartbtn" type="submit" name="someAction" value="Add to Cart" />');
          $form.append('<input type="hidden" name="sellingID" value="'+sid+'"/>');
          //$form.append('<input type="hidden" name="uid" value="'+uid+'"/>');
          img.appendTo(book_container);
          book_container.append(description);
          $form.appendTo(book_container);
          book_container.appendTo('#ebookcol2');
        }
        for (i=2;i<etotal;i=i+3)
        {
          var txt="";
          var sid=ary[i]['sellingID'];
          var uid=ary[i]['userID'];

          txt+= "Title: " + ary[i]['title'] + "<br>";
          txt+= "Author: " + ary[i]['author'] + "<br>";
          txt+= "Genre: " + ary[i]['genre'] + "<br>";
          txt+= "ISBN: " + ary[i]['isbn'] + "<br>";
          txt+= "Description: " + ary[i]['description'] + "<br>";
          txt+= "Condition: " + ary[i]['condi'] + "<br>";
          txt+= "Exchange Method: " + ary[i]['exmethod'] + "<br>";
          txt+= "Price: $" + ary[i]['price'] + "<br>";
          //console.log(sid);
          var book_container = $(document.createElement('div'));
          var description = "<p>" + txt + "</p>";
          var img = $(document.createElement('img'));
          img.attr('src', '../img/book.png');

          $form= $('<form  action="../backend/cart_adding_process.php" method="post"></form>');
          $form.append('<input class="cartbtn" type="submit" name="someAction" value="Add to Cart" />');
          $form.append('<input type="hidden" name="sellingID" value="'+sid+'"/>');
          //$form.append('<input type="hidden" name="uid" value="'+uid+'"/>');
          img.appendTo(book_container);
          book_container.append(description);
          $form.appendTo(book_container);
          book_container.appendTo('#ebookcol3');
        }
      //======================================================================================
      //Similar Results ==================================
        var stotal="<?php echo $similar_total?>";
        var ary2 =<?php echo json_encode($similar_book_arr)?>; //Converts php array to js array
        for (i=0;i<stotal;i=i+3)
        {
          var txt="";
          var sid=ary2[i]['sellingID'];
          var uid=ary2[i]['userID'];

          txt+= "Title: " + ary2[i]['title'] + "<br>";
          txt+= "Author: " + ary2[i]['author'] + "<br>";
          txt+= "Genre: " + ary2[i]['genre'] + "<br>";
          txt+= "ISBN: " + ary2[i]['isbn'] + "<br>";
          txt+= "Description: " + ary2[i]['description'] + "<br>";
          txt+= "Condition: " + ary2[i]['condi'] + "<br>";
          txt+= "Exchange Method: " + ary2[i]['exmethod'] + "<br>";
          txt+= "Price: $" + ary2[i]['price'] + "<br>";
          //console.log(sid);
          var book_container = $(document.createElement('div'));
          var description = "<p>" + txt + "</p>";
          var img = $(document.createElement('img'));
          img.attr('src', '../img/book.png');

          $form= $('<form  action="../backend/cart_adding_process.php" method="post"></form>');
          $form.append('<input class="cartbtn" type="submit" name="someAction" value="Add to Cart" />');
          $form.append('<input type="hidden" name="sellingID" value="'+sid+'"/>');
          //$form.append('<input type="hidden" name="uid" value="'+uid+'"/>');
          img.appendTo(book_container);
          book_container.append(description);
          $form.appendTo(book_container);
          book_container.appendTo('#sbookcol1');
        }
        for (i=1;i<stotal;i=i+3)
        {
          var txt="";
          var sid=ary2[i]['sellingID'];
          var uid=ary2[i]['userID'];

          txt+= "Title: " + ary2[i]['title'] + "<br>";
          txt+= "Author: " + ary2[i]['author'] + "<br>";
          txt+= "Genre: " + ary2[i]['genre'] + "<br>";
          txt+= "ISBN: " + ary2[i]['isbn'] + "<br>";
          txt+= "Description: " + ary2[i]['description'] + "<br>";
          txt+= "Condition: " + ary2[i]['condi'] + "<br>";
          txt+= "Exchange Method: " + ary2[i]['exmethod'] + "<br>";
          txt+= "Price: $" + ary2[i]['price'] + "<br>";
          //console.log(sid);
          var book_container = $(document.createElement('div'));
          var description = "<p>" + txt + "</p>";
          var img = $(document.createElement('img'));
          img.attr('src', '../img/book.png');

          $form= $('<form  action="../backend/cart_adding_process.php" method="post"></form>');
          $form.append('<input class="cartbtn" type="submit" name="someAction" value="Add to Cart" />');
          $form.append('<input type="hidden" name="sellingID" value="'+sid+'"/>');
          //$form.append('<input type="hidden" name="uid" value="'+uid+'"/>');
          img.appendTo(book_container);
          book_container.append(description);
          $form.appendTo(book_container);
          book_container.appendTo('#sbookcol2');
        }
        for (i=2;i<stotal;i=i+3)
        {
          var txt="";
          var sid=ary2[i]['sellingID'];
          var uid=ary2[i]['userID'];

          txt+= "Title: " + ary2[i]['title'] + "<br>";
          txt+= "Author: " + ary2[i]['author'] + "<br>";
          txt+= "Genre: " + ary2[i]['genre'] + "<br>";
          txt+= "ISBN: " + ary2[i]['isbn'] + "<br>";
          txt+= "Description: " + ary2[i]['description'] + "<br>";
          txt+= "Condition: " + ary2[i]['condi'] + "<br>";
          txt+= "Exchange Method: " + ary2[i]['exmethod'] + "<br>";
          txt+= "Price: $" + ary2[i]['price'] + "<br>";
          //console.log(sid);
          var book_container = $(document.createElement('div'));
          var description = "<p>" + txt + "</p>";
          var img = $(document.createElement('img'));
          img.attr('src', '../img/book.png');

          $form= $('<form  action="../backend/cart_adding_process.php" method="post"></form>');
          $form.append('<input class="cartbtn" type="submit" name="someAction" value="Add to Cart" />');
          $form.append('<input type="hidden" name="sellingID" value="'+sid+'"/>');
          //$form.append('<input type="hidden" name="uid" value="'+uid+'"/>');

          img.appendTo(book_container);
          book_container.append(description);
          $form.appendTo(book_container);
          book_container.appendTo('#sbookcol3');
        }
        var loggedIn="<?php echo $isLoggedIn?>";
        console.log(loggedIn);
        if(loggedIn==0){
          $content1= $('<a class="dropdown-item" href="/frontend/login.html">Login</a>');
          $content1.appendTo('#dropCnt');
          $content2=$('<a class="dropdown-item" href="/frontend/signup.html">Create Account</a>');
          $content2.appendTo('#dropCnt');

          $crt=$('<a class="nav-link" href="#NotLoggedIn">Cart</a>');
        }
        else{
          $content1= $('<a class="dropdown-item" href="#profile">Profile</a>');
          $content1.appendTo('#dropCnt');
          $content2=$('<a class="dropdown-item" href="/backend/signout_process.php">Logout</a>');
          $content2.appendTo('#dropCnt');

          $crt=$('<a class="nav-link" id="carticon" data-badge="<?php echo $c_quan?>"" href="/frontend/authenticated/cart.php">Cart</a>');
        }
        $crt.appendTo('#cartbtn');

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
</html>    