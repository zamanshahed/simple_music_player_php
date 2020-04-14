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
		<input type="text" name="song_name" placeholder="Song Name"> <br>
		<input type="text" name="artist" placeholder="Artist"> <br>
		<input type="text" name="poster" placeholder="Poster Url"> <br>
		
		<input type="file" name="f"> <br>
		
		<input type="submit" value="submit" name="submit">

	</form>
	<a href="songs.php">HOME</a>
</body>
</html>