<?php
require_once('connection.php');
$mysqli = new mysqli("localhost", "root", "", "wave");
if($mysqli->connect_error){
    exit('Failed to connect server');
}

$user_id = 0;
$user_name = $_GET['u'];
$list_id = $_GET['l'];
$song_id = $_GET['s'];
$sql1 = "SELECT id FROM `waver` WHERE name = '$user_name'";
$result1 = mysqli_query($con,$sql1);

while ($row = $result1->fetch_assoc()) {
  $user_id =  $row['id'];
}
echo $user_id;
echo "<br> moving for sql2 with values: 
  ".$user_id."
  ".$list_id."
  ".$song_id."
";
$sql2 = "
UPDATE
    waving
  SET
    user_id = '$user_id',
    list_id = '$list_id',
    song_id = '$song_id'
  WHERE
    user_id = '$user_id'
    AND list_id = '$list_id'
    AND song_id='$song_id'
";
   
$sql3 ="
INSERT INTO
    waving (
      user_id,
      list_id,
      song_id
    )
  SELECT
    '$user_id',
    '$list_id',
    '$song_id'
  WHERE
    NOT EXISTS (
        SELECT * FROM waving WHERE user_id = '$user_id' AND list_id = '$list_id' AND song_id = '$song_id'
    )
";

$result2 = mysqli_query($con,$sql2);

$result3 = mysqli_query($con,$sql3);
  
?>