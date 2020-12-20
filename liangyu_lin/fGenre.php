<?php
include('includes/phpfunctions.php');
// live filter
$q = $_GET['genre'];
$result_array = array();

//query the name & image of the games.
$getID ="";
$query = "SELECT iname, name FROM games WHERE genre = '".$q."'";
$result = mysqli_query($connection, $query);
$results_rows = mysqli_num_rows($result);

//get query result from database and put into JSON array
if ($results_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($result_array, $row);
    }
  }
//converts PHP array or object into JSON format
  echo json_encode($result_array);
