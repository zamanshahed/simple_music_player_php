<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>WAVE</title>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link href="https://fonts.googleapis.com/css?family=ABeeZee|Trade+Winds&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="songs.css">
</head>
<style>
	body {
		margin: 0;
		font-size: 28px;
		font-family: Arial, Helvetica, sans-serif;
	}

	.header {
		background-color: #f1f1f1;
		padding: 10px;
		text-align: center;
	}

	#navbar {
		overflow: hidden;
		background-color: #333;
	}

	#navbar a {
		float: left;
		display: block;
		color: #f2f2f2;
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
		font-size: 17px;
	}

	#navbar a:hover {
		background-color: #ddd;
		color: black;
	}

	#navbar a.active {
		background-color: #4CAF50;
		color: white;
	}

	.content {
		padding: 16px;
	}

	.sticky {
		position: fixed;
		top: 0;
		width: 100%;
	}

	.sticky+.content {
		padding-top: 60px;
	}
</style>

<body>

	<div class="header">
		<h2 class="banner">WAVE STREAMING</h2>
		<p>Scroll down and play a song!</p>
	</div>

	<div id="navbar">
		<a class="active" href="javascript:void(0)">LOGOUT</a>
		
			<select class="list-select">
				<option value="">ALL SONGS</option>
				<option value="">LISTEN LATER</option>
				<option value="">FAVOURITES</option>
			</select>
		
		<!-- <a href="javascript:void(0)">Contact</a> -->
	</div>
	<div id="player">
		<table class="w3-table-all">
			<thead>
				<tr class="w3-red">
					<th colspan="3">Song Name - Artist</th>
				</tr>
			</thead>
			<tr>
				<td style="height:120px" colspan="3">ALBUM ART</td>
			</tr>
			<tr style="height:30px">
				<td colspan="2" >
					<img src="img/volume.png" width="30px" />
					<input id="volumeSlider" class="volume-slider" type="range" min="0" max="1" step="0.01" onchange="adjustVolume()" />
				</td>
				<td><img src="img/star.svg" width="32px" /></td>
			</tr>
			<tr>
				<td colspan="3" style="height:10px"><input id="songSlider" class="song-slider" type="range" min="0" step="1" onchange="seekSong()" /></td>

			</tr>
			<tr>
				<td><img src="img/previous.png" width="25px" /></td>
				<td><img src="img/play.png" width="25px" /></td>
				<td><img src="img/next.png" width="25px" /></td>
			</tr>
		</table>
		<script type="text/javascript" src="./482/js-play/player.js"></script>
	</div>


	<div class="canvas">
		<form class="list" action="player.php" method="get">

			<?php

			$dir_path = "songs/";
			if (is_dir($dir_path)) {
				$files = scandir($dir_path);
				//print_r($files);

				for ($i = 0; $i < count($files); $i++) {
					if ($files[$i] != "." && $files[$i] != "..") {
						echo "
					<div class='btn'>
						<a class='button' type='submit' value='play' href='player.php?name=$files[$i]'>
							<span>$files[$i]</span>
						</a>
							<select class='playlist'>
							<option value=''>...</option>
							<option value='later'>LISTEN LATER</option>
							<option value='fav'>FAVOURITES</option>
							</select>
							<button class='button-2' >ADD</button>
						<br>
					</div>
				";
					}
				}
			}
			?>

		</form>
	</div>

	<script>
		window.onscroll = function() {
			myFunction()
		};

		var navbar = document.getElementById("navbar");
		var player = document.getElementById("player");
		var sticky = navbar.offsetTop;

		function myFunction() {
			if (window.pageYOffset >= sticky) {
				navbar.classList.add("sticky")
				player.classList.add("sticky")
			} else {
				navbar.classList.remove("sticky");
				player.classList.remove("sticky");
			}
		}
	</script>


</body>

</html>