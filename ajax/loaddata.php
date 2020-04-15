<?php
    require_once('../connection.php');
?>

<?php
    $limit = $_POSt['limit'];
    $sql = "SELECT * FROM `song_list`";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<p>";
            echo $row['poster'];
            echo "</p>";
        }
    }else{
        echo "no data...";
    }
?>