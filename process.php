<?php
require_once('connection.php');
session_start();
    if(isset($_POST['Login']))
    {
       if(empty($_POST['email']) || empty($_POST['password']))
       {
            header("location:index.php?Empty= Please Fill in the Blanks");
       }
       else
       {
            $pass = md5($_POST['password']);
            $query="select * from waver where email='".$_POST['email']."' and Pass='".$pass."'";
            $query2 = "select name from waver where email='".$_POST['email']."' and Pass='".$pass."'";
            $result=mysqli_query($con,$query);
            $result2 = mysqli_query($con,$query2);

            while ($row = $result2->fetch_assoc()) {
              $name =  $row['name'];
            }

            if(mysqli_fetch_assoc($result))
            {
                $_SESSION['User']=$name;
                header("location:wave.php");
            }
            else
            {
                header("location:index.php?Invalid= Please Enter Correct User Name and Password ");
            }
       }
    }
    else
    {
        echo 'Not Working Now Sir';
    }

?>



<!DOCTYPE html>
<html>
<head>
	<title>Processing...</title>
	<link rel="stylesheet" type="text/css" href="master.css">
	<link href="//db.onlinewebfonts.com/c/f518e4e7999e3a3b645a9605c23e2cf6?family=Bitsumishi" rel="stylesheet" type="text/css"/>
</head>
<body style="background-color: gray;">

	<div class="top_bar">
		<label class="top_logo">Wave</label>
	</div>

	<h1 style="font-size: 100px; font-family: Bitsumishi; color: cyan; text-align-last: center;">
		PROCESS : WAVE
	</h1>

</body>
</html>
