<?php 

	@session_start();

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Login now!</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<link href="https://fonts.googleapis.com/css?family=ABeeZee|Trade+Winds&display=swap" rel="stylesheet">
</head>
<body>
	<form class="canvas" action="process.php" method="post">

		<h1 class="banner">Login</h1>	
		<div class="container">
			<input class="input" type="text" name="email" placeholder="Email">
			<input class="input" type="password" name="password" placeholder="Password"><br>
			<input class="btn" type="submit" name="Login" value="Login">
			<a href="register.php" class="btn">Resgister</a>
	
		</div>	
		

		<?php
        if(@$_GET['Empty']==true)
        {
    ?>
        <div><?php echo $_GET['Empty'] ?></div>
    <?php
        }
    ?>


    <?php
        if(@$_GET['Invalid']==true)
        {
    ?>
        <div><?php echo $_GET['Invalid'] ?></div>
    <?php
        }
      ?>


	</form>
</body>
</html>