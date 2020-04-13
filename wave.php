<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- font AbeeZee -->
    <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>


    <title>WAVE..</title> 

    <style>
      /* body{
        position:relative;
        background-color: #f7f7f7;
        font-family: ABeeZee;
      } */

      body {
        margin: 0;
        font-size: 28px;
        font-family: Arial, Helvetica, sans-serif;
      }

      .header {
        background-color: #f1f1f1;
        padding: 30px;
        text-align: center;
      }

      #navbar {
        position: top;
        overflow: hidden;
        background-color: #333;
      }

      #navbar a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
      }

      #navbar a:hover {
        background-color: #ddd;
        color: black;
      }

      #navbar a.active {
        background-color: #4CAF50;
        color: white;
      }

      .content {
        padding: 16px;
      }

      .sticky {
        position: fixed;
        top: 0;
        width: 100%;
      }

      .sticky + .content {
        padding-top: 60px;
      }

      img{
        width: 250px;
        height: 250px;
        /**min-height: 250px;**/
      }
      .main{
        padding: 40px 0;
      }
      .col-md-3{
        margin-bottom: 40px;
      }
      .album_poster{
        position: relative;
        display: block;
        border-radius: 175px;
        margin-bottom: 10px;        
        overflow: hidden;
        box-shadow: 0 15px 35px #3d2173a1;
        transition: all ease 0.4s;
      }
      .album_poster:hover{
        box-shadow: none;
        transform: scale(0.98) translateY(5px);
      }
      h3{
        font-size: 34px;
        margin-bottom: 34px;
        border-bottom: 4px solid #e6e6e6;
        padding-bottom: 15px;
      }
      h4{
        font-size: 20px;
        text-transform: uppercase;
        margin-top: 15px;
        font-weight: 700;
      }


    </style>

  </head>
  <body>

          
    <div class="header">
      <h2>WAVE STREAMING</h2>
      <p>Time to stream some wave...</p>
    </div>

    <div id="navbar">
      <a class="active" href="javascript:void(0)">Home</a>
      <a href="javascript:void(0)">News</a>
      <a href="javascript:void(0)">Contact</a>
    </div>

    
    <div class="main">
      <div class="container">
        
        <div class="row">
          <div class="col-md-12">
            <h3>New Releases</h3>
          </div>

          <?php 

            session_start();

            include_once('connection.php');

            $sql = "SELECT `song_url`, `song_name`, `artist`,`poster` FROM `song_list`";
            
            if ($result = mysqli_query($con, $sql)) 
            { 
                // echo "Query Executed"; 
                // loop will iterate until all data is fetched 
                while ($row = mysqli_fetch_array ($result)) 
                { 
                    // these four line is for four column 
                     
                    // echo $row['song_name'].' '; 
                    // echo $row['song_url'].' ';
                    // echo $row['poster'].'<br>'; 

                    echo "
                      <div class='col-md-3'>
                        <a href='JavaScript:aplay(".$row['song_url'].")' class='album_poster'>
                          <img src='".$row['poster']."'>
                        </a>
                        <h4>".$row['song_name']."</h4>
                        
                      </div>
                    ";

                } 
            } 
            else
            { 
                echo "Error in execution"; 
            } 

          ?>

        </div>
      </div>
    </div>
    
    <script>
          // for floating navbar
          window.onscroll = function() {myFunction()};

          var navbar = document.getElementById("navbar");
          var sticky = navbar.offsetTop;

          function myFunction() {
            if (window.pageYOffset >= sticky) {
              navbar.classList.add("sticky")
            } else {
              navbar.classList.remove("sticky");
            }
          }
        </script>

        
  </body>
</html>