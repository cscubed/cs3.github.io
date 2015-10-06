<?php
include('conn.php');
$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = "SELECT id, password FROM users WHERE username = ? limit 1";
$stmt = $dbh->prepare($sql);
$stmt->execute(array($username));
$row = $stmt->fetch();

if($row){
	if($password == $row['password']){
		$_SESSION["user_id"] = $row['id'];
		header("Location: .");
	}else{
		print 'Login fail';
		print '<br>';
	}
}else{
	print 'Login fail';
	print '<br>';
}
?>
