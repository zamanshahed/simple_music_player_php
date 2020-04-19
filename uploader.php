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
<link href="//db.onlinewebfonts.com/c/f518e4e7999e3a3b645a9605c23e2cf6?family=Bitsumishi" rel="stylesheet" type="text/css"/> 
	<link href="https://fonts.googleapis.com/css?family=ABeeZee|Trade+Winds&display=swap" rel="stylesheet">
	<title>Upload Songs</title>
	<link rel="stylesheet" href="uploader.css">
</head>
<body>

		<h1 class="banner">WAVE : UPLOADER</h1>

	<div class="canvas">
		<form action="uploader.php" method="post" enctype="multipart/form-data">
			<input type="text" name="song_name" placeholder="Song Name" required> <br>
			<input type="text" name="artist" placeholder="Artist" required> <br>
			<input type="text" name="poster" placeholder="Poster Url" required> <br>
			
			<input type="file" name="f" required> <br>
			
			<input type="submit" class="btn" value="submit" name="submit">

		</form>
	</div>
	
	<a class="btn" href="javascript:window.close();">BACK</a>

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