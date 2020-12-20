<?php
	include('includes/phpfunctions.php');
	session_start();
	$username = $_SESSION['username'];

	// get like input from detail page and insert into database
	if(!empty($_GET)) {
 	$game = $_GET['game'];

 	$query = "select * from favourite where uid = '$username' and game = '$game'";
 	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$rows = mysqli_num_rows($result);
	echo $rows;
//check if the case exists in database, if yes delete; if not insert.
	if ($rows >= 1) {
		$query = "delete from favourite where uid = '$username' and game = '$game'";
		echo $query;
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

	}else{
	//if data not exist, insert info
		$query = "insert into favourite (uid, game) value ('$username','$game')";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

 	}

}

?>
