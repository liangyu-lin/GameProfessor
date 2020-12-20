<?php
//start session
session_start();

//if session is active
if(!isset($_SESSION["username"])){

  header("Location: sign_page.php");
  exit(); }

?>
