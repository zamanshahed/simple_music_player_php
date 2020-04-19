<?php
    // echo "User: ";
    $user = $_GET['u'];
    // echo $user;
    // echo "<br>Song id: ";
    $song_id = $_GET['s'];
    // echo $song_id;
?>

    <!DOCTYPE html>
    <html lang="en">
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//db.onlinewebfonts.com/c/f518e4e7999e3a3b645a9605c23e2cf6?family=Bitsumishi" rel="stylesheet" type="text/css"/> 
	<link href="https://fonts.googleapis.com/css?family=ABeeZee|Trade+Winds&display=swap" rel="stylesheet">
        <title>AJAX DATABASE</title>
        <link rel="stylesheet" href="playlist.css">
    </head>

    <body>
        <div class="canvas">
            <h1 class="banner">WAVE : PLAYLIST</h1>
            <form action="">
                <select name="songs" id="drop-box" class="list-select" onChange="addToList('<?php echo $user ?>', this.value, <?php echo $song_id ?>)">
                    <option value="" selected>Add to playlist</option>
                    <option value="newList">CREATE NEW LIST</option>
                    <option value="1">LISTEN LATER</option>
                    <option value="2">FAVORITE</option>
                </select>
            </form>
            <br>
            <div id="txtHint">
                song info...
            </div>

            <div id="songInfo">
                
            <?php
                    $song_title = $_GET['t'];
                    echo "<br> <h2 class='songData'> Song: $song_title </h2>"; 
                    $artist = $_GET['a'];
                    echo "<br> <h4 class='songData'> Artist: $artist</h4>"; 
                ?>
            </div>

            <div id="newList" style="display: none">
                <form action="">
                    <input type="text" placeholder="Playlist name">
                    <input type="submit" class="btn" value="CREATE">
                </form>
                
            </div>
            <div class="button">
                <a class="btn" href="javascript:close_window();">BACK</a>
            </div>

            <script>
                function close_window() {
                    window.close();
                }
                function addToList(user_name, list_id, song_id) {
                    var xhttp;
                    var x = document.getElementById('newList');
                    if (list_id == '') {
                        document.getElementById('txtHint').innerHTML = "Select option to perform..";
                        x.style.display='none';
                        return;
                    }
                    if (list_id == 'newList') {
                        document.getElementById('txtHint').innerHTML = "Enter Playlist Name";
                        x.style.display='block';
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

                function showSongList(str, id) {
                    var xhttp;
                    if (str == "") {
                        document.getElementById('txtHint').innerHTML = "Select option again to load..";
                        return;
                    }
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById('txtHint').innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "addtolist.php?q=" + str + "&id=" + id, true);
                    xhttp.send();
                    alert('UPDATED..!');
                };
            </script>
        </div>
    </body>

    </html>