<?php 
	
	//session_start();

	include_once('connection.php');

	
	if (isset($_POST['submit'])) {
		
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$m = "songs/".$_FILES['f']['name'];		
			$song_name = $_POST['song_name'];
			$artist = $_POST['artist'];
			$poster = $_POST['poster'];

			//echo "song_url = $m 	song_name= $song_name 	artist = $artist 	poster = $poster";
			move_uploaded_file($_FILES['f']['tmp_name'], $m);
			echo "Upload done!!";
			$sql = "INSERT INTO `song_list`( `song_url`, `song_name`, `artist`, `poster`) 
						VALUES ('$m', '$song_name', '$artist', '$poster')";
			if (mysqli_query($con, $sql)) {
				echo "Data Synced!!";
			}else{
				echo "error in query!";
			}
		}

	}

 ?>




<!DOCTYPE html>
<html>
<head>
	<title>Upload Songs</title>
</head>
<body>

	<form action="uploader.php" method="post" enctype="multipart/form-data">
		<input type="text" name="song_name" placeholder="Song Name" required> <br>
		<input type="text" name="artist" placeholder="Artist" required> <br>
		<input type="text" name="poster" placeholder="Poster Url" required> <br>
		
		<input type="file" name="f" required> <br>
		
		<input type="submit" class="btn" value="submit" name="submit">

	</form>
	<a href="songs.php">HOME</a>

	<style>
		input{
			border: 2px solid blueviolet;
			margin: 5px;
			padding: 5px;
			width: 80%;
			font-size: 20px;
			height: 25px;
		}
		.btn{
			height: 50px;
		}
		
	</style>
</body>
</html>