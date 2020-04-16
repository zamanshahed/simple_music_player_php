<?php
    $mysqli = new mysqli("localhost", "root", "", "wave");
    if($mysqli->connect_error){
        exit('Failed to connect server');
    }
    $sql = "UPDATE `song_list` 
    SET rating = ? 
    WHERE song_list.song_id = 2";
  
    $stmt  = $mysqli->prepare($sql);
    $stmt->bind_param('i', $_GET['q']);
    $stmt->execute();
    echo '<script language="javascript">';
    echo 'alert("UPDATED...!")';
    echo '</script>';
    // $stmt->store_result();
    // $stmt->bind_result($song_name, $artist, $rating, $song_url);
    // $stmt->fetch();
    // $stmt->fetch();
    $stmt->close();
    echo "Success..!";
    // echo "
    //     <table>
    //         <tr>
    //             <th>
    //                 Song Name:
    //             </th>
    //             <td>
    //                 " .$song_name. "
    //             </td>
    //             <th>
    //                 Artist:
    //             </th>
    //             <td>
    //                 ".$artist."
    //             </td>
    //             <th>
    //                 Rating:
    //             </th>
    //             <td>
    //                 ".$rating."
    //             </td>
    //             <th>
    //                 URL:
    //             </th>
    //             <td>
    //                 ".$song_url."
    //             </td>
    //         </tr>
    //     </table>
    // ";
?>