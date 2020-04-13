<?php

     ## Turn on error reporting
    error_reporting(-1);
    ini_set('display_errors', 'On');
    $valueMap = array();
    // session_start();

    include_once('connection.php');

    $sql = "SELECT `song_url`, (`song_id`-1) AS `song_id`, `song_name`, `artist`,`poster` FROM `song_list` GROUP BY `song_id` ASC";

    if ($result = mysqli_query($con, $sql)) {
        // echo "Query Executed"; 
        // loop will iterate until all data is fetched 
        while ($row = mysqli_fetch_array($result)) {
            $items = $row;
            $valueMap[] = array($row['song_id']);
        }
    } else {
        echo "Error in execution";
    }
    print_r($valueMap); 
?>
    <!-- <button onclick="{showData()}">CLICK</button> -->
<script type='text/javascript'>
function showData(){
    var js_data = <?php echo json_encode($valueMap); ?>;
    var jsArray = js_data.toString().split(',');
    for(var i=0; i < jsArray.length; i++){
        console.log(jsArray[i]);
    }
}
</script>
