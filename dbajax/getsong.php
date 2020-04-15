<?php
    $mysqli = new mysqli("localhost", "root", "", "wave");
    if($mysqli->connect_error){
        exit('Failed to connect server');
    }
    $sql = "SELECT `song_name`,`artist`,`rating`,`song_url` FROM `song_list` WHERE `song_name` = ?";
    
    $stmt  = $mysqli->prepare($sql);
    $stmt->bind_param('s', $_GET['q']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($song_name, $artist, $rating, $song_url);
    $stmt->fetch();
    $stmt->close();

    echo "
        <table>
            <tr>
                <th>
                    Song Name:
                </th>
                <td>
                    " .$song_name. "
                </td>
                <th>
                    Artist:
                </th>
                <td>
                    ".$artist."
                </td>
                <th>
                    Rating:
                </th>
                <td>
                    ".$rating."
                </td>
                <th>
                    URL:
                </th>
                <td>
                    ".$song_url."
                </td>
            </tr>
        </table>
    ";
?>