// removes backslashes
$username = stripslashes($_SESSION['username']);
//escapes special characters in a string
$username = mysqli_real_escape_string($conn,$username);
$time = stripcslashes($_REQUEST['time']);
$time = mysqli_real_escape_string($conn,$time);

$sql2 = "SELECT * FROM notes WHERE username = '$username'
		AND time = '$time'";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result2) > 0)
{
// output data of each row
while($comment_results = mysqli_fetch_assoc($result2))
{ echo $comment_results["note"]."<br>";}

}
