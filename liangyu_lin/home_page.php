<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Game Professor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--Google Fonts Roboto -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <!--sidemenu css style sheet-->
  <link href="css/sidemenu.css" rel="stylesheet"/>
  <!--top nav css style sheet-->
  <link href="css/topnav.css" rel="stylesheet"/>

  <!--Animate.css reference: https://animate.style/-->
  <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Font Awesome, Reference: https://fontawesome.com/how-to-use/on-the-web/setup/hosting-font-awesome-yourself -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

  <!-- BootStrap CSS Reference: https://getbootstrap.com/-->
  <link rel="stylesheet" href="css/bootstrap-grid.min.css">

  <!--css to hide uwanted classes -->
  <style>
  .noShow {
    display: none;
  }
  </style>

  <!-- BootStrap JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  <script type="text/javascript">
  //pagination at homepage
  var offset = 8;
  //display json arry and add paging function
  function displayResult(p, displayArea, pageArea) {

    var str = '';

    //p is the page# starting from 0, offset is the number of items.
    var start = p * offset;
    // get stop point by checking item array length
    var stop = p * offset + offset > result.length ? result.length : p * offset + offset;

    //start = 0, paging function for users to go to the next page
    for (i = start; i < stop; i++) {

      str += '<div class="gameCards"><div class="card"><img src="images/'+result[i].iname+'"/><form method="get" action="detail_page.php"><input type="hidden" name="varname" value="Reviews"><p><input type="submit" name="varname" value="'+result[i].name+'" class="itembuttons"  /></p></form></div></div>';
    }

    // offset = (page - 1) * itemsPerPage + 1
    document.getElementById(displayArea).innerHTML = str;
    //current page
    var pages = "";
    //display the number of needed pages by rounding up the remainder
    // if pages are not enough add 1 page
    for (i = 0; i < Math.ceil(result.length / offset); i++) {
    //set the location for displaying content and page numbers
      if (p == i) {
        pages += " <a href=\"javascript:void(0)\" class=\"pages currentPage\"onclick=\"displayResult(" + i + ",'"+displayArea+"', '"+pageArea+"');\">" + (i + 1) + "</a>";
      } else {
        s = "'" + displayArea + "'";
        pages += " <a href=\"javascript:void(0)\" class=\"pages\" onclick=\"displayResult(" + i + ",'"+displayArea+"', '"+pageArea+"');\">" + (i + 1) + "</a>";
      }

    }
    console.log(page);
    //update pageArea to pages
    document.getElementById(pageArea).innerHTML = pages

  }
  </script>

  <?php

  //include php functionality
  include('includes/phpfunctions.php');
  session_start();
  ?>
</head>


<body>

  <!--Nav Bar-->
  <div class="header">
    <nav>
      <div><a href="home_page.php">Game Professor</a></div>

      <?php
      //check if user is logged in, if logged in display logout and account. If not, display signin
      if (isset($_SESSION['username'])) {
        # code...

        echo
        "<div>
        <a href='account.php' style='margin-right: 1em;' >Account</a>

        <a href='logout.php'>Sign Out</a>
        </div>";
      }else{
        echo "<div><a href='sign_page.php'>Sign In</a></div>";
      }

      ?>

    </nav>
  </div>


  <!--Page layout using bootstrap framework -->
  <div class="container-fluid">


    <!-- create side-menu and searchbar for the website -->
    <div class="row">
      <!-- Sidemenu for finding games. The side menu will take 2/12 of the screen-->
      <div class="sidemenu col-md-2">

        <!-- search bar for searching games -->
        <form method="post">
          <div class="srch">
            <input type="text" id="searchText" name="search" placeholder="Search for Games..."  onKeyUp="searchGames()"/>
            <!-- <input type="submit" name="src" value="s" class="search-btn" -->
            <div class="search-btn">
              <i class="fas fa-search" aria-hidden="true"></i>
            </div>
          </div>
        </form>

        <br>
        <br>

        <!-- the side-menu will take 2/12 of the screen -->
        <ul>
          <li><button class="liAction" value ="Action" name="genre" onclick="showGenre(this.value)">Action</button></li>
          <li><button class="liAdventure" value ="Adventure" name="genre" onclick="showGenre(this.value)">Adventure</button></li>
          <li><button class="liRolePlaying" value ="RPG" name="genre" onclick="showGenre(this.value)">Role Playing</button></li>
          <li><button class="liStrategy" value ="Strategy" name="genre" onclick="showGenre(this.value)">Strategy</button></li>
          <li><button class="liSports" value ="Sports" name="genre" onclick="showGenre(this.value)">Sports</button></li>
        </ul>
      </div>

      <!-- the game list will take 10/12 of the screen -->
      <!-- this echos the name of the page that user is on. Source: https://www.youtube.com/watch?v=Hx7rz56JInU-->
      <div class="subtitle col-md-10">
        <div class="text-center">
          <?php
          if (isset($_SESSION['username'])) {
            # code...
            echo "<h1 class='animate__animated animate__fadeIn'>Welcome to Game Professor, " . $_SESSION['username'] . "!</h1>";
          }else{
            echo " <h1 class='animate__animated animate__fadeIn'>Welcome to Game Professor...</h1>";
          }

          ?>

        </div>

        <!--display page number-->
        <div id="page" style="text-align:right;"></div>

        <!--h3 for all games-->
        <h3 id="gameGenre">All Games</h3>

        <!--display genre filter results here-->
        <div id="Genres"></div>


        <!--display search results here-->
        <div id="result">

          <?php
          //get all the games from the database
          $result_array = array();
          $query = "SELECT iname,name FROM games";
          $result = mysqli_query($connection, $query);
          $results_rows = mysqli_num_rows($result);
          if ($results_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              array_push($result_array, $row);
            }
          }
          //display all the game from above query by JSON
          echo'<script>
          var raw = \''.json_encode($result_array).'\';
          var result = $.parseJSON(raw);

          displayResult(0, "result", "page");
          </script>';
          ?>

        </div>
        <?php
        if (isset($_SESSION['username'])) {
          //display h3 tag for liked games
          echo "<h3 id='likeH3head' style='margin-top: 900px;'>Liked Games</h3>";
          //get like query
          $query = "SELECT favourite.uid as name, iname, name FROM favourite, games, members WHERE favourite.uid = members.username and favourite.game = games.name and favourite.uid = '".$_SESSION['username']."'";
          $result = mysqli_query($connection, $query);


          //display the results
          while($row = mysqli_fetch_array($result))
          {
            echo '<div class="gameCards">
            <div class="card">
            <img src="images/'.$row['iname'].'"/>
            <form method="get" action="detail_page.php">
            <input type="hidden" name="varname" value="Reviews">
            <p><input type="submit" name="varname" value="'. $getID = $row['name']. '" class="itembuttons"  /></p>
            </form>
            </div>
            </div>';


          }
        }
        ?>


      </div>
    </div>
  </div>


  <script>
  // paging




  //search games and update page display results based on search input.
  var result;
  function searchGames(){
    var searchText = document.getElementById("searchText").value;
    var xmlhttp = new XMLHttpRequest();
    var url = "fetch.php?name=" + searchText;

    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4) {
        if (xmlhttp.status == 200) {
          // console.log(this.responseText);
          //parses JSON string, constructing the object described by the string
          result = $.parseJSON(this.responseText);
          // if items greater than 8 display result in pages.
          if (result.length > 0) {
            displayResult(0, 'result', 'page');
          }

          // document.getElementById("result").innerHTML = xmlhttp.responseText;
        } else {
          alert('There was a problem with the request.');
        }
      }
    }
    //specifies the type of request, GET, the file location, async true
    xmlhttp.open("GET", url, true);
    //Sends the request to the server
    xmlhttp.send();
  }


  //filter games based on genre and update page display results using ajax.
  function showGenre(str) {
    if (str == "") {
      document.getElementById("Genres").innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // console.log(this.responseText);
          //parses JSON string, constructing the object described by the string
          result = $.parseJSON(this.responseText);
          //console.log(result);
          if (result.length > 0) {
            displayResult(0, 'Genres', 'page');
          }

          //hides search results and search bar
          hideResults();

          // change h3 Heading;
          var h3Heading = document.getElementById('gameGenre')
          h3Heading.innerText = str;
        }
      };
      //specifies the type of request, GET, the file location, async true
      xmlhttp.open("GET","fGenre.php?genre="+str,true);
      xmlhttp.send();
    }
  }


  // add css display none class to hide unwanted classes
  function hideResults(){

    var hideResults = document.getElementById("result");
    hideResults.classList.add("noShow");
    var hideSearch = document.querySelector(".srch");
    hideSearch.classList.add("noShow");
  }


</script>

</body>
</html>
