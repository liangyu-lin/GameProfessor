<?php
include('includes/phpfunctions.php');

// fetch live search
$name = $_GET['name'];
$result_array = array();

$query="";
if (strlen($name) < 1) {
  // return all
  $query = "SELECT iname,name FROM games";
  $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
  $results_rows = mysqli_num_rows($result) ;
  //get query result from database and put into JSON array
  if ($results_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      //push query results into array
      array_push($result_array, $row);
    }
  }
//converts PHP array or object into JSON format
  echo json_encode($result_array);
} else {
  $query = "SELECT iname,name FROM games WHERE name LIKE '%$name%'";
  $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
  $results_rows = mysqli_num_rows($result);
  //get query result from database and put into JSON array
  if ($results_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      //push query results into array
      array_push($result_array, $row);
    }
  }
//converts PHP array or object into JSON format
  echo json_encode($result_array);
}

?>
