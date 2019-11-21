<?php
  require_once("../backend/ClassUser.php");
  require_once("../backend/ClassCart.php");
  require_once("../backend/ClassBook.php");
  require_once("../backend/ClassOrder.php");

  if (session_id() == '')
  {
    session_start();
  }

  $user = new User;
  if (!$user->isLoggedIn)
  {
    $isLoggedIn=0;
    die(header("Location: ../login_required.php"));
  }
  else
  {
    $isLoggedIn=1;
  }

  $book = new Book;
  $book->get_onsale_books();
  $onsale_books_arr = $_SESSION['onsale_books_arr'];
  $total_books=count($onsale_books_arr);

  $order = new Order;
  $sale_pending_quantity = count($_SESSION['sale_pending_arr']);

  $cart = new Cart;

  $fname=$_SESSION['firstname'];
  $lname=$_SESSION['lastname'];
  $c_quan = $_SESSION['cart_quantity'];
  $uid=$_SESSION['userID'];
?>

<!DOCTYPE HTML>

<html>

<head>
  <meta charset="utf-8">
  <title>Profile</title>
  <link rel="stylesheet" href="/frontend/styles/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="/frontend/styles/ProfilePage_Style.css">
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
                  Hello, 
                  <?php 
                    if($isLoggedIn){
                      echo $fname;
                    }
                    else echo "Guest";
                  ?>
                </a>
                <div id="dropCnt" class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                </div>
              </li>
            </ul>
          </div>
    </nav>
<!-- Profile Page , Modal -->
<div class="profile-container">
  <div class="row">
  <div class="col-md-4">
    <img src="../img/testimonial.png" class="img-responsive" width="100" height="100" />
  </div>
  <div class="col-md-8 profile-info">
    <h4 class="user-name"><?php echo $fname." ".$lname?></h4>
    <h5 class="user-mail"><i><?php echo $_SESSION['email']?></i></h5>
    <h5 class="user-company"> College Student</h5>
  </div>
</div>
  <br><br>
  <div class="row more-info">
  <div class="col-md-6">
    <h5><b>Student</b></h5>
    <p>San Jose State University</p>
  </div>
    <div class="col-md-6">
      <h5><b>Book Selling</b></h5>
      <div id="listedBooks"></div> <!--Books inserted from script-->
    </div>
  </div>
   <div class="row more-info">
      <div class="col-md-6">
        <h5><b>Contact</b></h5>
        <p>Location: San Jose </p> <!-- </3 -->
      </div>
        <div class="col-md-6">
          <h5><b>Phone Number</b></h5>
          <p><?php echo $_SESSION['phone'];?></p>
      </div>
  </div>
  <br>
  <div class="row">
    <div id="einfo"><h5>Edit Info</h5>
  </div>
  <br/><br/>
</div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/frontend/js/bootstrap.js"></script>
    <script>
      $(document).ready(function(){
        var loggedIn="<?php echo $isLoggedIn?>";
        //console.log(loggedIn);
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
        
        $("#einfo").click(function(){
          alert("This is just a dummy profile page.\nEditing not implemented yet.");
        });


        //Book Generator
        var bary =<?php echo json_encode($onsale_books_arr)?>;
        var total="<?php echo $total_books?>";
        //console.log(total);
        if(total==0){

          $bks=$('You haven\'t listed any books.');
          $bks.appendTo('#listedBooks');
        }
        else{
          for (i=0; i<total; i=i+1)
          {

            var title=bary[i]['title'];
            var eTitle = "<p>" + title + "</p>";
            $('#listedBooks').append(eTitle);
            console.log(title);
          }
        }
    });
    </script>
</body>

</html>