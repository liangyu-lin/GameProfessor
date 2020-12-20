
<!--get data from txt file-->

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

</head>
<body>
	<?php
	//connect to database
	require('includes/phpfunctions.php');
	//check session active
	include('includes/sessionActiveCheck.php');
	?>
	<!--Nav Bar-->
	<div class="header">
		<nav>
			<div><a href="home_page.php">Game Professor</a></div>
			<div><a href="sign_page.php">Sign In</a></div>
		</nav>
	</div>


	<h1>Game Professor</h1>

	<!--Login Form-->
	<div class="main">
		<div class="left-login">
			<h2>Login</h2>
			<form action="sign_page.php" method="post">
				<label>Email address<br/></label>
				<input type="email" name="lg_email">

				<label>Password<br/></label>
				<input type="password" name="lg_password">

				<!--Login PHP-->

				<div class="button">
					<input type="submit" name="Login" value="LOGIN">
				</div>
			</form>

			<?php
			//if get value from input
			if (isset($_POST['lg_email'])) {
			 	//data cleaning
			 	$loginEmail = stripcslashes($_POST['lg_email']);
			 	$loginEmail = mysqli_real_escape_string($connection, $loginEmail);

			 	$loginPassword = stripcslashes($_POST['lg_password']);
			 	$loginPassword = mysqli_real_escape_string($connection, $loginPassword);

				//query email and password from database
			 	$query = "SELECT * FROM `members` WHERE email='$loginEmail'
    			and pwd='".md5($loginPassword)."'";
    			$result = mysqli_query($connection, $query) or die (mysqli_error($connection));
    			$rows = mysqli_num_rows($result);

					//if there is a record, then login
    			if($rows == 1){
    				$row = $result->fetch_assoc();
    				$_SESSION['username'] = $row['username'];
    				// print_r($_SESSION);
    				header("Location: home_page.php");
    			}else{
						//if not, display error message
    				echo "<p>email/password is incorrect</p>";
    			}
				}


			?>

		</div>

		<!--Sign up account PHP-->
		<div class="right-signup">
			<h2>Create Account</h2>
			<form action="sign_page.php" method="post">
				<label>Username<br/></label>
				<input type="text" name="rg_username" required>

				<label>Email address<br/></label>
				<input type="email" name="rg_email" required>

				<label>Password<br/></label>
				<input type="password" name="rg_password" required>

				<!--create user account by entering the form and enter it to file-->

				<div class="button">
					<input type="submit" name="submit" value="CREATE">
				</div>

			</form>
			<?php


				if (isset($_POST['rg_username'])){
					//data cleaning, assign value to variable
					$userName = stripcslashes($_POST['rg_username']);
					$userName = mysqli_real_escape_string($connection, $userName);

					$userEmail = stripcslashes($_POST['rg_email']);
					$userEmail = mysqli_real_escape_string($connection, $userEmail);

					$userPassword = stripcslashes($_POST['rg_password']);
					$userPassword = mysqli_real_escape_string($connection, $userPassword);

					//check data from database
					$query = "SELECT * FROM `members` WHERE username = '$userName' or email = '$userEmail'";
					//echo $query;
					$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
					$rows = mysqli_num_rows($result);

					// if data exist
					if ($rows >= 1) {


						echo "<p>Username/Email already exist</p>";
					}else{
						//if data not exist, insert info
						$query = "INSERT INTO `members` (username, email, pwd) VALUES ('$userName', '$userEmail', '".md5($userPassword)."')";

						$result = mysqli_query($connection, $query);
						if ($result) {
							//sucessful message
							echo "<p style = 'color:green'>Successfully, please login.</p>";
						}
					}
				}

			?>
		</div>

	</body>
	</html>
