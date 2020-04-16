<?php
    $mysqli = new mysqli("localhost", "root", "", "wave");
    if($mysqli->connect_error){
        exit('Failed to connect server');
    }
    $sql = "UPDATE `song_list` 
    SET rating = ? 
    WHERE song_list.song_id = ?";
  
    $stmt  = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $_GET['q'], $_GET['id']);
    $stmt->execute();
    $stmt->close();
    echo "Success..!";
?>