
<?php
include("auth.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div id="show">

        <?php

        require('db.php');
        // If form submitted, insert values into the database.

        if (isset($_SESSION['username'])){
                // removes backslashes
          $username = $_SESSION['username'];
                //escapes special characters in a string
          $time1 = $_GET['time1'];

          $sql2 = "SELECT * FROM notes WHERE username = '$username'
                  AND time = '$time1'  ";
          $result2 = mysqli_query($conn, $sql2);
          if (mysqli_num_rows($result2) > 0)
          {
          		// output data of each row
          		while($comment_results = mysqli_fetch_assoc($result2))
          { echo $comment_results["note"]."<br>";}

              }
              else{
                echo "You have not made any note for this day."."<br>";
              }
            }

          ?>


          
          </div>

  </body>
</html>
