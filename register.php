<?php

	session_start();
	include_once('connection.php');

	$_SESSION['message']='';

	if ($_SERVER['REQUEST_METHOD']=='POST') {
		if ($_POST['pass']==$_POST['repass']) {
			$username = $_POST['username'];
			$email = $_POST['email'];
			$pass = md5($_POST['pass']);


			$_SESSION['username']=$username;

					$sql="INSERT INTO `waver`( `name`, `email`, `pass`) VALUES  ('$username', '$email', '$pass')";
					if (mysqli_query($con, $sql)) {
						$_SESSION['message']='Registration Successfull!';
						echo "<script type='text/javascript'>
							alert('Registration Successfull!'');
						</script>";
						header("location:index.php");
					}
					else
					{
						$_SESSION['message']="Error occured after the register query!";
					}
		}
		else{
			$_SESSION['message']="Two Passwords did not match";
		}
	}
?>







<!DOCTYPE html>
<html>
<head>
	<title>Register now!</title>
	<link rel="stylesheet" type="text/css" href="register.css">
	<link href="https://fonts.googleapis.com/css?family=ABeeZee|Trade+Winds&display=swap" rel="stylesheet">
</head>
<body>
	<form class="canvas" action="register.php" method="post">

		<h1 class="banner">Register</h1>	
		<div class="container">
			<input class="input" type="text" name="username" placeholder="Name">
			<input class="input" type="text" name="email" placeholder="Email">
			<input class="input" type="password" name="pass" placeholder="Password"><br>
			<input class="input" type="password" name="repass" placeholder="Repeat Password"><br>
			<input class="btn" type="submit" value="Register">
			<a href="index.php" class="btn">Login</a>
		</div>	
		
	</form>
</body>
</html>