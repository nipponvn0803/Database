<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>No need</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
require('db.php');
// If form submitted, insert values into the database.
if (isset($_REQUEST['mess'])){
        // removes backslashes
	$username = stripslashes($_SESSION['username']);
        //escapes special characters in a string
	$username = mysqli_real_escape_string($conn,$username);
	$mess = stripslashes($_REQUEST['mess']);
	$mess = mysqli_real_escape_string($conn,$mess);
	$time = stripcslashes($_REQUEST['time']);
	$time = mysqli_real_escape_string($conn,$time);

        $query = "INSERT into `notes` (username, note, time)
VALUES ('$username', '$mess', '$time')";
        $result = mysqli_query($conn,$query);

        if($result){
            echo "<div class='form'>
							</div>";
						echo "<meta http-equiv='refresh' content='0'>";
        }
    }

		else{
?>
<div class="form">

<form name="registration" action="" method="post">
<br>
<input type="text" id="test" name="time" readonly ></input>
<textarea rows="4" cols="50" name="mess"></textarea><br>
<input type="submit" name="submit" value="Submit" />

</form>
</div>

<?php } ?>


</body>
</html>
