<?php
    include_once('connection.php');
    // echo "OK..!<br>";
    $user_name = $_GET['u'];
    $user_id = 0;
    $list_id = $_GET['l'];
    
    $sql1 = "SELECT id FROM `waver` WHERE name = '$user_name'";
    $result1 = mysqli_query($con,$sql1);

    while ($row = $result1->fetch_assoc()) {
    $user_id =  $row['id'];
    }
    echo "
        user id: $user_id <br> list id: $list_id
    ";
?>
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
	<title>WAVE</title>
	<link href="https://fonts.googleapis.com/css?family=ABeeZee|Trade+Winds&display=swap" rel="stylesheet">
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

		background-color: #f1f1f1;
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
		background-color: red;
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
		<h2 class="banner">WAVE STREAMING</h2>
		<p>Scroll down and play a song!</p>
		<!-- <div id="txtHint">
			song info loading...
		</div> -->
	</div>

	<div id="navbar">
		<a class="active1" href="logout.php">LOGOUT 
			(<?php
				echo $_SESSION['use'] ;
			?>)
		</a>
		<a class="active" href="uploader.php">UPLOADER</a>
		<!-- href='
									addplaylist.php?
										u=" . $_SESSION['use'] . "
										&s=" . $row['rate_serial'] . "
										&t=" . $row['song_name'] . "
									'
									target='_blank' class='playlist'> -->
		<select class="list-select" onchange="location = this.value">
			<option value="">SELECT PLAYLIST</option>
			<option value="playlist.php?u=<?php echo $_SESSION['use'] ?>&l=1">LISTEN LATER</option>
			<option value="playlist.php?u=<?php echo $_SESSION['use'] ?>&l=2">FAVOURITES</option>
			<option value="songs.php">ALL SONGS</option>
		</select>

		<!-- <a href="javascript:void(0)">Contact</a> -->
	</div>
	<br>
	<div id="player">
		<div class="audio-player-cont">
			<div class="logo">
				<img id="poster" src="img/nothing.png" width="270px;" height="210px" style="margin-left: 2px;" />
			</div>
			<div class="player">
				<div id="songTitle" class="song-title">Song title goes here</div>
				<div id="songArtist" class="song-title">Song artist goes here</div>
				<input id="songSlider" class="song-slider" type="range" min="0" step="1" onchange="seekSong()" />
				<div>
					<div id="currentTime" class="current-time">00:00</div>
					<div id="duration" class="duration">00:00</div>
				</div>
				<div class="controllers">
					<img src="img/previous.png" style="margin-top: 15px;" width="30px" onclick="previous();" />
					<!-- <img src="images/backward.png" width="30px" onclick="decreasePlaybackRate();" /> -->
					<img id="play" src="img/play.png" width="40px" style="margin-top: 15px;" onclick="playOrPauseSong(this);" />
					<!-- <img src="images/forward.png" width="30px" onclick="increasePlaybackRate();" /> -->
					<img src="img/next.png" width="30px" onclick="next();" style="margin-top: 15px;" />
					<img src="img/volume.png" width="35px" style="margin-top: 15px; margin-left:13px;" />
					<input id="volumeSlider" style="margin-top: 15px;" class="volume-slider" type="range" min="0" max="1" step="0.01" onchange="adjustVolume()" />
					<!-- <img src="images/volume-up.png" width="15px" style="margin-left:2px;" /> -->
				</div>
				<div id="nextSongTitle" class="song-title"><b>Next Song :</b>Next song title goes here...</div>
				<div id="songRating" class="song-title"><b>Song Rating :</b>Song Rating goes here...</div>
			</div>
		</div>
		<!-- <script type="text/javascript" src="player.js"></script> -->
	</div>



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
								<a href='JavaScript:playSong("  . $row['song_id'] . ")' class='button'>
									<img src='" . $row['poster'] . "' height='90px' width='120px'>								
									<label class='button'>
										" . $row['song_name'] . " - " . $row['artist'] . "
									</label>
								</a>
								
								<a href='
									addplaylist.php?
										u=" . $_SESSION['use'] . "
										&s=" . $row['rate_serial'] . "
										&t=" . $row['song_name'] . "
									'
									target='_blank' class='playlist'>
									
								</a>

								<select class='rating' onchange='rateSong(this.value, "  . $row['rate_serial'] . ")'>
									<option value=''>Rate</option>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
									<option value='5'>5</option>
								</select>
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
							// console.log(songs2[i]);
							// console.log(poster[i]);
							// console.log(artist[i]);
							console.log(rating[i]);
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
						nextSongTitle.innerHTML = "<b>Next Song: </b>" + songs2[currentSong + 1 % songs2.length].substring(6);
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