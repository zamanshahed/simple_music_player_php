<?php

$mysqli = new mysqli("localhost", "root", "", "wave");
if($mysqli->connect_error){
    exit('Failed to connect server');
}

$sql = "
  UPDATE
    waving
  SET
    user_id = 1,
    list_id = 2,
    list_name='FAV'
  WHERE
    user_id = 1
    AND list_id = 2;
   
   INSERT INTO
    waving (
      user_id,
      list_id,
      list_name
    )
  SELECT
    1,
    2,
    'FAV'
  WHERE
    NOT EXISTS (
        SELECT * FROM waving WHERE user_id = 1 AND list_id = 2
    )
";

$stmt  = $mysqli->prepare($sql);
$stmt->bind_param(
  'sii', 
  $_GET['u'], 
  $_GET['l'],
  $_GET['s']
);
$stmt->execute();
$stmt->close();
echo "Success..!";

    
?>