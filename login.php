<?php
include('conn.php');
$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM users WHERE username='".$username."'";
$result = mysqli_query($conn, $sql);

if($row = mysqli_fetch_assoc($result)){
	if($password == $row['password']){
		$_SESSION["user_id"] = $row['id'];
		header("Location: .");
	}else{
		print 'Login fail';
		print '<br>';
	}
}else{
	print 'Unable to find user.'.$username;
}
?>