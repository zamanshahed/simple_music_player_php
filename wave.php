<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- APlayer CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/aplayer/1.10.1/APlayer.min.css">

    <!-- font AbeeZee -->
    <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>


    <title>WAVE..</title> 

    <style>
      body{
        background-color: #f7f7f7;
        font-family: ABeeZee;
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


      /*music player customizing style*/
      span{
        color: #000;
        font-size: 16px;
      }
      .aplayer .aplayer-info .aplayer-controller .aplayer-bar .aplayer-bar-warp .aplayer-loaded{
        background: #e0e0e0;
        height: 4px;
      }
      .aplayer .aplayer-info .aplayer-controller .aplayer-bar .aplayer-bar-warp .aplayer-played{
        height: 4px;
        background-color: #2196f3; 
      }
      .aplayer .aplayer-info .aplayer-controller .aplayer-bar .aplayer-bar-warp .aplayer-played .aplyer-thumb{
        background-color: #2196f3;
      }

      #aplayer{
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        margin: 0;
        box-shadow: 0 -2px 2px #dadada;
        background-color: #fff;
        transition: all ease 0.5s;
      }

      #aplayer.showPlayer{
        bottom: 0;
      }


    </style>

  </head>
  <body>
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

          <!-- <div class="col-md-3">
            <a href="JavaScript:void();" class="album_poster">
              <img src="img/album.png  ">
            </a>
            <h4>Song Name</h4>
            
          </div> -->


        </div>


        <div class="row">
          <div class="col-md-12">
            <h3>Hit List</h3>
          </div>


          <div class="col-md-2">
            <a href="JavaScript:void();" class="album_poster">
              <img src="img/album.png" height="150px" width="150px">
            </a>
            <h4>Song Name</h4>
          </div>

          <div class="col-md-2">
            <a href="JavaScript:void();" class="album_poster">
              <img src="img/album.png">
            </a>
            <h4>Song Name</h4>
          </div>

          <div class="col-md-2">
            <a href="JavaScript:void();" class="album_poster">
              <img src="img/album.png">
            </a>
            <h4>Song Name</h4>
          </div>

          <div class="col-md-2">
            <a href="JavaScript:void();" class="album_poster">
              <img src="img/album.png">
            </a>
            <h4>Song Name</h4>
          </div>


        </div>

            
        </div>
      </div>
    </div>




    





<div id="aplayer"></div>





    <!-- Optional JavaScript -->

    <!-- APlayer JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aplayer/1.10.1/APlayer.min.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>



    <script>

      var song_name = "song name";
      var song_url = "the url";
      var poster = "the poster link";
      var artist = "The people who sang this";

      $(".album_poster").on('click', function aplay (song_name1, song_url1, poster1) {
        song_name = song_name1;
        song_url=song_url1;
        poster = poster1;
        // slide up the player
        ap.play();
        $("#aplayer").addClass('showPlayer');
      })





      const ap = new APlayer({
        container: document.getElementById('aplayer'),
        listFolded: true,
        

        audio: [{
            name: ''.song_name,
            url: ''.song_url,
            artist:''.artist,
            cover: ''.poster                
        }],

        
    });

    </script>

  </body>
</html>