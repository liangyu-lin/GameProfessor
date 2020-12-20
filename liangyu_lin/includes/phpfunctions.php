<?php



/*Database conenction*/
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "liangyu_lin";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Test if conenction succeeded
if (mysqli_connect_errno()){
  //if connection failed, skip php code and print error.
  die("Database connection failed: " . mysqli_connect_errno() . "(" . mysqli_connect_errno() . ")");
} else {

  //echo "DB Connection successful";
}


 ?>
