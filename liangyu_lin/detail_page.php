<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Game Detail</title>

  <!--top nav css style sheet-->
  <link href="css/topnav.css" rel="stylesheet"/>
  <!-- jquery import -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- fonts links list -->
  <!-- like thumbs -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- add JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
  <?php
  //include php functionality
  include('includes/phpfunctions.php') ;
  session_start();
  ?>

  <!--Nav Bar-->
  <div class="header">
    <nav>
      <div><a href="home_page.php">Game Professor</a></div>
      <?php
      //check if user is logged in, if logged in show account and logout; if not show sign in
      if (isset($_SESSION['username'])) {
        # code...
        echo "<div>
        <a href='account.php' style='margin-right: 1em;'>Account</a>
        <a href='logout.php'>Sign Out</a>
        </div>";
      }else{
        echo "<div><a href='sign_page.php'>Sign In</a></div>";
      }

      ?>

    </nav>
  </div>

  <?php


  //get session variable game name from the previous page
  $Reviews = $_GET['varname'];



  // query all column from the selected movie
  $queryGames = "SELECT * FROM games where name = '$Reviews' ";
  $result = mysqli_query($connection,$queryGames);

  while($row = mysqli_fetch_assoc($result)) {
    // assign value to the variable, it will be used for display purpose

    $genre = $row['genre'];
    $description = $row['description'];
    $image = $row['image'] ;
  }


  ?>



  <!-- product page body = item detail + image -->
  <div class="main">
    <section class="main-top">
      <?php
      // display game image
      echo '<div class="top-left-image">
      <img src="data:image/jpeg;base64,'.base64_encode( $image ).'"
      </div>';

      ?>

      <div class="top-right-text">

        <p>Massively Multiplayer Games</p>
          <!--display database query-->
        <h1><?php echo  $Reviews;?></h1>
        <p><?php  echo  $genre ;?></p>
        <p><?php echo $description?></p>




        <?php
        //query like database
        if (isset($_SESSION['username'])) {
          # code...
          $username = $_SESSION['username'];
          $game = $Reviews;
          $query = "select * from favourite where uid = '$username' and game = '$game'";
          $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
          $rows = mysqli_num_rows($result);

          //  check like data status in database, initial set to 1 = like
          if ($rows >= 1) {
            // if liked , member can dislike
            echo"<div><button class='like' onclick='changeColor(this)'>Dislike</button></div>";

          }else{
            //if disliked, user can like game
            echo"<div><button class='like' onclick='changeColor(this)'>Like</button></div>";
          }
        }

        ?>

      </div>
      <script type="text/javascript">
      //onclick, change like button status color and text.
      function changeColor(obj){
        if (obj.innerHTML == "Like") {
          obj.innerHTML = "Dislike";
          obj.style.background = "white";
          obj.style.color = "black";
        }else{
          obj.innerHTML = "Like";
          obj.style.background = "pink";
          obj.style.color = "white";
        }

      }
      </script>

    </section>

    <script type="text/javascript">

    //jquery
    //onclick pass game name to getlike.phpfile
    $(".like").on("click", function(){
      var game = "<?php echo $Reviews;?>";
      console.log(game);
      $.ajax({
        type:"GET",
        url:"getlike.php",
        data:{"game": game},

      }).done();
    })
    </script>

    <!-- write review part -->
    <?php
    date_default_timezone_set('America/Vancouver');
    include 'includes/comments.inc.php';
    ?>

    <div class="write-review">
      <h2>Write a Review</h2>
    </div>

    <?php
    //if user is logged in, they can comment.
    if (isset($_SESSION['username'])) {
      # code...
      echo "<div class='text-review'>
      <p>Please describe what you liked or disliked about this game and whether you recommend it to others.</p>
      </div>";
      echo "<form method='POST' action='".setComments($connection)."'>
      <input type='hidden' name='uid' value='". $_SESSION['username']. "'>
      <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
      <input type='hidden' name='game' value='".$Reviews. "'>
      <textarea class='review' name='message' rows='4' cols='50'> </textarea>

      <button class='postReview' type='submit' name='commentSubmit'>Comment</button>
      </form>";
    }else{
      //if user is not logged in, they cannot comment, but will be able to view comments.
      echo "<div class='text-review'>
      <p>Please sign up an account to leave your comments!</p>
      </div>";
    }


    ?>


    <!-- set time for comments -->
    <!-- user review part -->
    <div class="sub-title">
      <h2>Most Helpful Reviews</h2>
    </div>
    <?php
    getComments($connection);
    ?>


  </body>
  </html>



<!--css for detail page-->
  <style>
  /* like thumbs */
  .post-info{
    margin: 10px auto 0px;
    padding: 5px;
  }
  .fa{
    font-size: 1.4em;
  }
  .fa-thumbs-down, .fa-thumbs-o-down{
    transform: rotateY(180deg);
  }
  .logged_in_user{
    padding: 10px 30px 0px;
  }
  i{
    color: blue;
  }

  /* comment box */
  .comment-box{
    margin-left: 10%;
    width: 77%;
    padding: 20px;
    margin-bottom: 4px;
    background-color: #fff;
    border-radius: 4px;
  }
  .comment-box p{
    font-family: arial;
    font-size: 14px;
    line-height: 16px;
    color: #282828;
    font-weight: 100;
  }
  /*product page body = item detail + image*/
  body{
    background-color: #1F1F1F;
    margin-top: 10%;
  }

  .main{
    width: 100%;
    margin: 1em 0;

  }
  .main-top{
    display: flex;
    justify-content: center;
    padding-bottom: 1em;
  }
  .top-left-image{
    display: flex;
    justify-content: space-around;
    margin-left: 0;
  }
  .top-left-image img{
    /* width: 400px;
    height: 500px; */
    width: 35%;
    height: 90%;
    margin-left: 10%;
  }
  .top-right-text{
    margin-right: 10%;
    padding-top: 5em;
    flex-basis: 40%;
    /* font-family: 'roboto'; */
    margin-left: 2em;
    color: white;
  }
  .top-right-text p:nth-child(1){
    font-size: 1.5em;
    margin-bottom: 0;
  }
  .product-popular-level{
    margin-top: 0;
  }
  .product-popular-level>i{
    color: #FDA118;
  }
  .top-right-text h1{

    width: 80%;
    font-size: 2em;
    font-family: 'Raleway', sans-serif;
  }
  .top-right-text p:nth-child(4){
    word-spacing: 2px;
    font-family: 'Quicksand', sans-serif;
  }
  .top-right-text p:nth-child(5){
    font-size: 14px;
    word-spacing: 2px;
    font-family: 'Quicksand', sans-serif;
    color: #BFBFBF;
  }
  .top-right-text p:nth-child(6){
    font-size: 14px;
    word-spacing: 2px;
    font-family: 'Quicksand', sans-serif;
    color: #BFBFBF;
  }
  .top-right-text p:nth-child(7){
    font-size: 14px;
    word-spacing: 2px;
    font-family: 'Quicksand', sans-serif;
    color: #BFBFBF;
  }
  .top-right-text p:nth-child(8){
    font-size: 14px;
    word-spacing: 2px;
    font-family: 'Quicksand', sans-serif;
    color: #BFBFBF;
  }
  .top-right-text p:nth-child(9){
    font-size: 14px;
    word-spacing: 2px;
    font-family: 'Quicksand', sans-serif;
    color: #BFBFBF;
  }

  /* add to favourite button */
  button{
    font-size: 15px;
    padding: 10px;

  }
  button:hover{
    background-color: #D2D2D2;

  }

  /* user review part */
  .sub-title h2{
    color: white;
    display: flex;
    justify-content: space-between;
    width: 80%;
  }
  .sub-title{
    display: flex;
    justify-content: space-between;
    width: 80%;
    margin: 1em auto;
    padding-top: 1em;
    padding-bottom: 1em;
    border-bottom: 1px solid #E1E1E1;
  }


  /* write a review part */
  .write-review{
    display: flex;
    justify-content: space-between;
    width: 80%;
    margin: 1em auto;
    padding-top: 1em;
    padding-bottom: 1em;
    border-bottom: 1px solid #E1E1E1;
  }
  .write-review h2{
    color: white;
    display: flex;
    justify-content: space-between;
    width: 80%;

    padding-top: 1em;


  }
  .text-review p{
    color: #a1a1a1;
    display: flex;
    justify-content: space-between;
    width: 80%;
    margin: 1em auto;
    padding-top: 1em;
    padding-bottom: 1em;
  }
  .review{
    color: #a1a1a1;
    display: flex;
    justify-content: space-between;
    width: 80%;
    margin: 1em auto;
    padding-top: 1em;
    padding-bottom: 1em;
  }
  .postReview{
    margin-top: 1em;
    margin-left: 10%;

  }
  .button-nav-page{
    color: white;
    text-decoration: none;
    border: 1px solid white;
    padding: 7px;
  }

</style>
