
<?php
	session_start();
	if(!isset($_SESSION['use'])){		//if the session is not present then force login
		header('location:index.php');
	}
?>

<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>WAVE:PLAYLIST</title>
	<link href="https://fonts.googleapis.com/css?family=ABeeZee|Trade+Winds&display=swap" rel="stylesheet">
	<link href="//db.onlinewebfonts.com/c/f518e4e7999e3a3b645a9605c23e2cf6?family=Bitsumishi" rel="stylesheet" type="text/css"/> 
	<link rel="icon" href="img/icon.png" type="" sizes="26x26">
	<link rel="stylesheet" type="text/css" href="songs.css">
</head>
<style>
	body {
		margin: 0;
		font-size: 28px;
		font-family: Arial, Helvetica, sans-serif;
	}

	.header {
		background-color: rgba(12, 12, 10, 0.4);
		padding: 2px;
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

	#navbar a.active1 {
		background-color: #e74c3c;
		color: white;
	}

	#navbar a.active {
		background-color: #4fffd6;
		color: black;
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
<div class="home" style="cursor: pointer;" onclick="window.location='songs.php'">
			<h1 class="banner">W A V E</h1>
		</div>		<p style="
			color:darkorange;
			font-family: arial;
			font-size:15px;
			letter-spacing:3px;
			font-weight:bold;
		">music is what feeling sounds like !</p>
		<video id="videoBG" autoplay muted loop>
			<source src="video/bg.mp4" type="video/mp4">
		</video>
	</div>

	<div id="navbar">
		<a class="active1" href="logout.php">LOGOUT 
			(<?php
				echo $_SESSION['use'] ;
			?>)
		</a>
		<a class="active" href="uploader.php">UPLOADER</a>

		<?php 
                    include_once('connection.php');
                    $user_name = $_SESSION['use'];
                    $user_id = 0;
                    $sql1 = "SELECT id FROM `waver` WHERE name = '$user_name'";
                    $result1 = mysqli_query($con,$sql1);

                    while ($row = $result1->fetch_assoc()) {
                    	$user_id =  $row['id'];
                    }

                    $sql2 = "SELECT list_name, list_id FROM `wave_list` WHERE list_id IN (
                        SELECT DISTINCT list_id FROM waving WHERE user_id = $user_id
                    )";

                    echo "
					<select class='list-select' onchange='location = this.value'>
						<option value='' selected>SELECT PLAYLIST</option>
						<option value='songs.php'>ALL SONGS</option>
                    ";
                    $result2 = mysqli_query($con,$sql2);
                    while ($row = $result2->fetch_assoc()) {
                        echo"							
							<option value='playlist.php?u=".$_SESSION['use']."&l=".$row['list_id']."'>".$row['list_name']."</option>
							
                        ";
                    }
                    echo "</select>";

                ?>

	
		<!-- <select class="list-select" onchange="location = this.value">
			<option value="">SELECT PLAYLIST</option>
			<option value="playlist.php?u=<?php echo $_SESSION['use'] ?>&l=1">LISTEN LATER</option>
			<option value="playlist.php?u=<?php echo $_SESSION['use'] ?>&l=2">FAVOURITES</option>
			<option value="songs.php">ALL SONGS</option>
		</select> -->

		<!-- <a href="javascript:void(0)">Contact</a> -->
	</div>
	<br>
	



	<div class="canvas">
		<form class="list">

			<div class="load_songs">
				<script type="text/javascript">
					phpVars = new Array();
				</script>

				<?php

				$items = [];

                include_once('connection.php');
                $user_name = $_GET['u'];
                $user_id = 0;
                $list_id = $_GET['l'];
                
                $sql1 = "SELECT id FROM `waver` WHERE name = '$user_name'";
                $result1 = mysqli_query($con,$sql1);

                while ($row = $result1->fetch_assoc()) {
                $user_id =  $row['id'];
                }
				$counter_id = 0;
				$sql = "SELECT `song_url`, (`song_id`-2) AS `song_id`, `song_id`-1 AS serial, `song_id` AS rate_serial, `song_name`, `artist`,`poster`
                FROM `song_list` 
                WHERE song_id IN (
                    SELECT song_id
                    FROM waving
                    WHERE waving.user_id = $user_id AND waving.list_id = $list_id
                )
                GROUP BY `song_id` ASC";

				if ($result = mysqli_query($con, $sql)) {
					// loop will iterate until all data is fetched 
					while ($row = mysqli_fetch_array($result)) {
						$items = $row;
						echo "
							<div >
								<a href='JavaScript:playSong($counter_id)' class='button'>
									<img src='" . $row['poster'] . "' height='90px' width='120px'>								
									<label class='button'>
										" . $row['song_name'] . " - " . $row['artist'] . "
									</label>
								</a>
								
								<a href='delete.php?u=" . $_SESSION['use'] . "&s=" . $row['rate_serial'] . "&t=" . $row['song_name'] . "&a=" . $row['artist'] . "'target='' ><img src='img/delete.png' width='45px'></a>

								
								<script>
									function addToList(user_name, list_id, song_id) {
										var xhttp;
										if (list_id == '') {
											return;
										}
										xhttp = new XMLHttpRequest();
										xhttp.onreadystatechange = function() {
											if (this.readyState == 4 && this.status == 200) {
												document.getElementById('txtHint').innerHTML = this.responseText;
											}
										};
										xhttp.open('GET', 'addtolist.php?u=' + user_name + '&l=' + list_id + '&s=' + song_id, true);
										xhttp.send();
										// alert('ADDED TO PLAYLIST..!');
									};
									
									function rateSong(str, id) {
										var xhttp;
										if (str == '') {
											document.getElementById('txtHint').innerHTML = 'Select option again to load';
											return;
										}
										xhttp = new XMLHttpRequest();
										xhttp.onreadystatechange = function() {
											if (this.readyState == 4 && this.status == 200) {
												document.getElementById('txtHint').innerHTML = this.responseText;
											}
										};
										xhttp.open('GET', 'dbajax/getsong.php?q=' + str + '&id=' + id, true);
										xhttp.send();
										alert('RATING UPDATED..!');
									};
								</script>
								<br>
								<br>
								<br>
							</div>
							

						";
						$counter_id++;
					}
				} else {
					echo "Error in execution";
				}

				?>

				<?php
				## Turn on error reporting
				error_reporting(-1);
				ini_set('display_errors', 'On');
				$valueMap = array();
				$urlMap = array();
				$artistMap = array();
				$ratinMap = array();
				// session_start();

				include_once('connection.php');

				$sql = "SELECT 
								`song_url`, 
								(`song_id`-1) AS `song_id`, 
								`song_name`, 
								`artist`,
								`poster`, 
								`rating` 
							    FROM `song_list` 
                                WHERE song_id IN (
                                    SELECT song_id
                                    FROM waving
                                    WHERE waving.user_id = $user_id AND waving.list_id = $list_id
                                )
                                GROUP BY `song_id` ASC
						";

				if ($result = mysqli_query($con, $sql)) {
					// echo "Query Executed"; 
					// loop will iterate until all data is fetched 
					while ($row = mysqli_fetch_array($result)) {
						$items = $row;
						$valueMap[] = array($row['song_url']);
						$urlMap[] = array($row['poster']);
						$artistMap[] = array($row['artist']);
						$ratinMap[] = array($row['rating']);
					}
				} else {
					echo "Error in execution";
				}
				// print_r($valueMap);
				?>
				<!-- <button onclick="{showData()}">CLICK</button> -->
				<script>
					var songs2 = [""];
					var poster = [""];
					var artist = [""];
					var rating = [""];
					window.onload = showData();

					function showData() {
						console.log('showData started...')
						var js_data = <?php echo json_encode($valueMap); ?>;
						var js_data2 = <?php echo json_encode($urlMap); ?>;
						var js_data3 = <?php echo json_encode($artistMap); ?>;
						var js_data4 = <?php echo json_encode($ratinMap); ?>;

						songs2 = js_data.toString().split(',');
						poster = js_data2.toString().split(',');
						artist = js_data3.toString().split(',');
						rating = js_data4.toString().split(',');

						for (var i = 0; i < songs2.length; i++) {
							console.log(songs2[i]);
							// console.log(poster[i]);
							// console.log(artist[i]);
							// console.log(rating[i]);
						}
					}
					var songTitle = document.getElementById('songTitle');
					var songArtist = document.getElementById('songArtist');
					var songSlider = document.getElementById('songSlider');
					var currentTime = document.getElementById('currentTime');
					var duration = document.getElementById('duration');
					var volumeSlider = document.getElementById('volumeSlider');
					var nextSongTitle = document.getElementById('nextSongTitle');
					var songRating = document.getElementById('songRating');

					var song = new Audio();
					var currentSong = 0;

					window.onload = playSong(0);

					// function loadSong(songId) {
					// 	currentSong = sognId-1;
					// 	document.getElementById("poster").src = poster[currentSong];
					// 	song.src = songs2[currentSong];
					// 	songTitle.textContent = (currentSong + 1) + ". " + songs2[currentSong];
					// 	// nextSongTitle.innerHTML = "<b>Next Song: </b>" + songs[currentSong + 1 % songs.length];
					// 	song.playbackRate = 1;
					// 	song.volume = volumeSlider.value;
					// 	song.play();
					// 	setTimeout(showDuration, 1000);
					// }

					function playSong(songId) {
						currentSong = songId;
						song.src = songs2[currentSong];
						document.getElementById("poster").src = poster[currentSong];
						songTitle.textContent = (currentSong + 1) + ". " + songs2[currentSong].substring(6);
						songArtist.textContent = "Artist: " + artist[currentSong];						
						nextSongTitle.innerHTML = "<b>Next Song: </b>" + songs2[(currentSong + 1) % songs2.length].substring(6);
						songRating.innerHTML = "<b>Song Rating: </b>" + rating[currentSong];
						song.playbackRate = 1;
						song.volume = volumeSlider.value;
						song.play();
						document.getElementById("play").src = "img/pause.png";
						setTimeout(showDuration, 1000);
					}

					setInterval(updateSongSlider, 1000);

					function updateSongSlider() {
						var c = Math.round(song.currentTime);
						songSlider.value = c;
						currentTime.textContent = convertTime(c);
						if (song.ended) {
							next();
						}
					}

					function convertTime(secs) {
						var min = Math.floor(secs / 60);
						var sec = secs % 60;
						min = (min < 10) ? "0" + min : min;
						sec = (sec < 10) ? "0" + sec : sec;
						return (min + ":" + sec);
					}

					function showDuration() {
						var d = Math.floor(song.duration);
						songSlider.setAttribute("max", d);
						duration.textContent = convertTime(d);
					}

					function playOrPauseSong(img) {
						song.playbackRate = 1;
						if (song.paused) {
							song.play();
							img.src = "img/pause.png";
						} else {
							song.pause();
							img.src = "img/play.png";
						}
					}

					function next() {
						currentSong = currentSong + 1 % songs2.length;
						document.getElementById("poster").src = poster[currentSong + 1];
						playSong(currentSong);
					}

					function previous() {
						currentSong--;
						currentSong = (currentSong < 0) ? songs2.length - 1 : currentSong;
						document.getElementById("poster").src = poster[currentSong];
						playSong(currentSong);
					}

					function seekSong() {
						song.currentTime = songSlider.value;
						currentTime.textContent = convertTime(song.currentTime);
					}

					function adjustVolume() {
						song.volume = volumeSlider.value;
					}

					// function increasePlaybackRate() {
					// 	songs.playbackRate += 0.5;
					// }

					// function decreasePlaybackRate() {
					// 	songs.playbackRate -= 0.5;
					// }
					// var songUrl = 'hello there';

					// function testOne(songId) {
					// 	alert(phpVars[0]);
					// }

					// function flash(one) {
					// 	var x = "<?php echo $items[0] ?>";
					// 	alert("From songs.php: " + x);

					// }
				</script>

			</div>


		</form>
	</div>

	<script>
		window.onscroll = function() {
			myFunction()
		};

		var navbar = document.getElementById("navbar");
		var player = document.getElementById("player");
		var playerBG = document.getElementById("playerBG");
		var sticky = navbar.offsetTop;
		var sticky2 = playerBG.offsetTop;

		function myFunction() {
			if (window.pageYOffset >=sticky) {
				navbar.classList.add("sticky")
				player.classList.add("sticky")
				playerBG.style.top=0;
			} else {
				navbar.classList.remove("sticky");
				player.classList.remove("sticky");
				playerBG.style.top='320px';
			}
		}
	</script>


</body>

</html>