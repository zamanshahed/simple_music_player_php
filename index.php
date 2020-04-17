<?php
require_once('connection.php');
session_start();
if (isset($_SESSION['use'])) {	//checking if user is already logged in, if so, redeirect to home page
	header('Location:songs.php');
}

if (isset($_POST['login'])) {		//when the user clicked login button..
	$user = $_POST['user'];
	$password = md5($_POST['password']);
	$sql = "SELECT id from waver where name = '$user' and pass = '$password' ";
	$result = mysqli_query($con, $sql);

	if (mysqli_fetch_assoc($result)) {
		$_SESSION['use'] = $user;
		header("location:songs.php");
	} else {
		header("location:index.php?Invalid= Please Enter Correct User Name and Password ");
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Login now!</title>
	<link href="https://fonts.googleapis.com/css?family=ABeeZee|Trade+Winds&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
	<form action="" method="post">

		<h1 class="banner">WAVE:LOGIN</h1>
		<div class="container">
			<input type="text" name="user" placeholder="User Name" require>
			<input type="password" name="password" placeholder="Password" required>
			<input type="submit" class="btn" value="Login" name="login">
	<button class="btn" onclick="window.location='register.php'">REGISTER NEW ACCOUNT</button>
		</div>
	</form>
</body>

</html>