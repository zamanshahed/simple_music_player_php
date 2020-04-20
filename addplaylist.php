<?php
    // session_start();
    // if(!isset($_SESSION['use'])){		//if the session is not present then force login
    //     header('location:index.php');
    // }
    $song_id = $_GET['s'];
    $user_name = $_GET['u'];
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
            <select name='songs' id='drop-box' class='list-select' onChange="addToList('<?php echo $user_name ?>', this.value, <?php echo $song_id ?>)">
                <?php 
                    include_once('connection.php');                    
                    $song_id = $_GET['s'];
                    $user_name = $_GET['u'];
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
                        <option value='' selected>Add to playlist</option>
                        <option value='newList'>CREATE NEW LIST</option>
                    ";
                    $result2 = mysqli_query($con,$sql2);
                    while ($row = $result2->fetch_assoc()) {
                        echo"
                            <option value='".$row['list_id']."'>".$row['list_name']."</option>
                        ";
                    }
                    echo "</select>";

                ?>
                <!-- <select name="songs" id="drop-box" class="list-select" onChange="addToList()">
                    <option value="" selected>Add to playlist</option>
                    <option value="newList">CREATE NEW LIST</option>
                    <option value="1">LISTEN LATER</option>
                    <option value="2">FAVORITE</option>
                </select> -->
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
                <form method="POST">
                    <input type="text" placeholder="Playlist name" name="listName">
                    <input type="submit" class="btn" value="SUBMIT" name="submit">
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

<?php
    include_once('connection.php');
    if (isset($_POST['SUBMIT']) || isset($_POST['submit'])) {		//when the user clicked CREATE button..
        $list_name = $_POST['listName'];
        echo " >>List Name:".$list_name;
        
        //insert the list_name in wave_list table for creating unique list_id
        $sql01 = "INSERT INTO `wave_list`(`list_name`) VALUES ('".$list_name."')";
        $result01 = mysqli_query($con, $sql01);
        echo " >>sql 01 done..! ";

        $list_id = 0;
        //getting list_id for further use
        $sql03 = "SELECT list_id FROM `wave_list` WHERE list_name='".$list_name."'";
        $result03 = mysqli_query($con,$sql03);
        while ($row02 = $result03->fetch_assoc()) {
            $list_id =  $row02['list_id'];
        }
        echo " >>sql 03 done..! ";

        //Finally creating entry for owner of the list in waving table
        $sql04 = "INSERT INTO `waving`(`user_id`, `list_id`) VALUES (".$user_id.",".$list_id.")";
        $result04 = mysqli_query($con, $sql04);
        echo "All done...!";
        //after all done, making a reload with necessary parameters passing
        // header("location:addplaylist.php?u=".$user_name."&s=".$song_id."&t=".$song_title."&a=".$artist."");
                
    }
?>