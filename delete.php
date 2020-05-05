<?php
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
        <title>DELETE ?</title>
        <link rel="stylesheet" href="delete.css">
    </head>

    <body>
        <div class="canvas">
            <h1 class="banner">WAVE : DELETE</h1>

            <br>
            <div id="txtHint">
                SURE TO DELETE ?
            </div>

            <div id="songInfo">
                
            <?php
                    $song_title = $_GET['t'];
                    echo "<br> <h2 class='songData'> Song: $song_title </h2>"; 
                    $artist = $_GET['a'];
                    echo "<br> <h2 class='songData'> Artist: $artist</h2>"; 
                ?>
            </div>
                
            </div>
            <div class="button2">
                <form method="POST" action="">
                    <input type="submit" class="btn" name="submit" value="DELETE">
                </form>
            </div>
            <div class="button">
                <!-- <a class="btn" href="manage.php">BACK</a> -->
                <?php 
                    echo "<a class='btn' href='manage.php?u=".$_GET['u']."&l=".$_GET['l']."'>BACK</a>";
                ?>
            </div>

           
        </div>
    </body>

    </html>

<?php
    include_once('connection.php');
    if (isset($_POST['SUBMIT']) || isset($_POST['submit'])) {		//when the user clicked CREATE button..

    $user_id = 0;
    $list_id = $_GET['l'];
    $song_id = $_GET['s'];
    $user_name = $_GET['u'];

    $sql1 = "SELECT id FROM `waver` WHERE name = '$user_name'";
    $result1 = mysqli_query($con,$sql1);

    while ($row = $result1->fetch_assoc()) {
        $user_id =  $row['id'];
    }

    $sql2 = "DELETE FROM `waving` WHERE `list_id` =$list_id AND user_id = $user_id AND song_id = $song_id";
    $result2 = mysqli_query($con,$sql2);   

    echo '<script language="javascript">';
    echo 'alert("Song Successfully Deleted..!")';        
    echo '</script>';
    echo " <script> window.location.href='manage.php?u=".$_GET['u']."&l=".$_GET['l']."  ' </script>";
    }
?>