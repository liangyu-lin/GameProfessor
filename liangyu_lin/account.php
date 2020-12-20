<?php
//get database connection
require('includes/phpfunctions.php');
//get session not active
include('includes/sessionNotActive.php');
?>

<?php
$changed = "";
//get input for new username, passwords, and emails.
if (isset($_POST['ai_username'])){

	$userName = stripcslashes($_POST['ai_username']);
	$userName = mysqli_real_escape_string($connection, $userName);

	$userEmail = stripcslashes($_POST['ai_email']);
	$userEmail = mysqli_real_escape_string($connection, $userEmail);

	$userPassword = stripcslashes($_POST['ai_password']);
	$userPassword = mysqli_real_escape_string($connection, $userPassword);

//query corresponding email base on username
	$query = "SELECT * FROM `members` WHERE  email = '$userEmail'";
	//	echo $query;

	//find the record
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	//find how many records from database
	$rows = mysqli_num_rows($result);
	// echo $rows;

	//if find a corresponding record, query database and update.
	if ($rows == 1) {


		$query = "UPDATE `members` SET username = '$userName', pwd = '".md5($userPassword)."' WHERE email = '$userEmail'";
		// echo $query;
		$result = mysqli_query($connection, $query);
		if ($result) {


			$changed = "Successfully, changed";
			$_SESSION['username'] = $userName;
		}else{
			//if account is already registered display a message.
			$changed = "Username is already registered, try a different name.";
		}
	}
}

?>

<?php

//get usename from session
$name =$_SESSION['username'];
$query = "SELECT * FROM `members` WHERE username='$name'";

//connect database and recieve data
$result = mysqli_query($connection, $query) or die (mysqli_error($connection));
$rows = mysqli_num_rows($result);

//find record and assign to variables
$row = $result->fetch_assoc();
$username = $row['username'];
$email = $row['email'];
$pwd = $row['pwd'];

?>
<!DOCTYPE html>
<html>
<head>
	<!--Google Fonts Roboto -->
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
	<title></title>

	<style type="text/css">
	body{
		margin: 0;
		font-family: 'Roboto', sans-serif;
		/* For browsers that do not support gradients */
		background-image: linear-gradient(-45deg, #7b2cbf, #9d4edd, #23A6D5, #23D5AB);
		background-size: 400% 1200%;
		position: relative;
		animation: change 10s ease-in-out infinite;
		color: white;
	}
	nav{
		/*position: fixed;*/
		width: 100%;
		height: 4em;
		background-color: black;
		display: flex;
		justify-content: space-between;
		z-index: 1;
		top: 0;
		left: 0;
		font-family: 'Roboto', sans-serif;
	}
	nav div{

		margin: auto 1em;
	}
	nav a{
		color: white;
		text-decoration: none;
	}
	nav a:hover{
		border-bottom: 1px solid white;
		transition: 0.3s;
		/*transform: scale(1.1);*/
		cursor: pointer;
	}

	h2{
		/*border: 1px solid red;*/
		text-align: center;
		margin-top: 60px;
	}
	h4{
		text-align: center;
		margin-top: 50px;
	}
	form{
		/*border: 1px solid red;*/
		/*width: 40%;*/
	}
	label{
		/*border: 1px solid red;*/
		display: block;
		width: 40%;
margin:5px auto;
		font-size: 0.8em;
	}
	input{
		border: 1px solid black;
		display: block;
		width: 40%;
		height: 30px;
		margin-left: auto;
		margin-right: auto;
		margin-bottom: 2em;
		border-radius: 5px;
		padding-left: 8px;
	}
	input:focus{
		outline:none;
	}
	input:nth-child(5){
		border: 1px solid lightgray;
	}
	.button input{
		/*border: 1px solid red;*/
		width: 20%;
		cursor: pointer;
		background-color: #091221;
		color: white;
		letter-spacing: 2px;
		border: none;
	}
	.button input:hover{
		color: white;
		background-color: #00AEFF;
	}
	/*background animation from https://www.youtube.com/watch?v=fBRzD6dwJfw*/
	@keyframes change {
		0% {
			background-position: 0 50%;
		}

		50% {
			background-position: 100% 50%;
		}

		100% {
			background-position: 0 50%;
		}
	}

	</style>
</head>
<body>
	<div class="header">
		<nav>
			<div><a href="home_page.php">Game Professor</a></div>
			<div><a href="logout.php">Sign Out</a></div>
		</nav>
	</div>

	<h2>Account Information</h2>

<!--input form-->
	<form action="account.php" method="post">
		<h4>Change Username</h4>
		<label>Username</label>
		<input type="text" name="ai_username" value= <?php echo $username;?> >

		<label>Email address</label>
		<input type="email" name="ai_email" readonly value= <?php echo $email;?> >
		<h4>Change Password</h4>
		<label>Password</label>
		<input type="password" name="ai_password" value= <?php echo $pwd;?>>

		<!--create user account by entering the form and enter it to file-->

		<div class="button">
			<input type="submit" name="submit" value="SAVE INFO">
		</div>
		<?php
		echo "<p style = 'text-align:center;'>".$changed."</p>";
		?>
	</form>


</body>
</html>
