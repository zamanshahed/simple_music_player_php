<?php
    echo "User: ";
    $user = $_GET['u'];
    echo $user;
    echo "<br>Song id: ";
    $song_id = $_GET['s'];
    echo $song_id;
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
        <title>AJAX DATABASE</title>
    </head>

    <body>
        <h1>Database Testing: PLAYLIST</h1>
        <form action="">
            <select name="songs" id="drop-box" onChange="addToList('<?php echo $user ?>', this.value, <?php echo $song_id ?>)">
            <option value="">Add to playlist</option>
            <option value="1">LISTEN LATER</option>
            <option value="2">FAVORITE</option>
        </select>
        </form>
        <br>
        <div id="txtHint">
            song info loading...
        </div>
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
    </body>

    </html>