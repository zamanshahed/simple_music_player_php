<?php 
	$con=mysqli_connect('localhost', 'root', '', 'wave');

	if (!$con) {
		die('Sir, Please check the connection.php: connection failed!'.mysqli_error());
	}
 ?>	