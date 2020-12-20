<?php
//session start
session_start();

//check session is active or not
if (isset($_SESSION["username"])) {
	# code...
	header("Location: visitorHomeGamelist.php");
	exit();
}
?>
