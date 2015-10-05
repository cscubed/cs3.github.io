<?php
include('conn.php');

session_start();

if(isset($_SESSION["user_id"])){
	$user_id = $_SESSION["user_id"];
	$sql = "SELECT * FROM users WHERE id='".$user_id."'";
	$result = mysqli_query($conn, $sql);

	if($row = mysqli_fetch_assoc($result)){
		$username = $row['username'];
		$firstname = $row['firstname'];
		$rank = $row['rank'];
	}
}

$type = $_GET['type'];

if($type == 'user'){
	$username = $_POST['username'];
	if(strlen($username) == 0) {
		print '
		<div class="container">
			Please enter a valid username.
		</div>';
	} else {
		$firstname = $_POST['firstname'];
		$email = $_POST['email'];
		$password1 = md5($_POST['password1']);
		$password2 = md5($_POST['password2']);

		if(!($password1 == $password2)){
			print 'Passwords don\'t match';
		}else{
			$sql = "INSERT INTO users (username, firstname, email, password)
			VALUES ('".$username."', '".$firstname."', '".$email."', '".$password1."')";

			if (mysqli_query($conn, $sql)) {
				header("Location: .");
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
	}
}elseif($type == 'post'){
	if(isset($_SESSION["user_id"])){
		if($rank == 'admin'){
			$user_id = $_SESSION["user_id"];
			$content = $_POST['content'];
			$sql = "INSERT INTO posts (user_id, content)
			VALUES ('".$user_id."', '".$content."')";
			mysqli_query($conn, $sql);
			header("Location: .");
		}else{
			print 'You don\'t have permission to post';
		}
	}else{
		print 'Not signed in.';
	}
}elseif($type == 'comment'){
	if(isset($_SESSION["user_id"])){
		$user_id = $_SESSION["user_id"];
		$post_id = $_GET['post_id'];
		$comment = $_POST['comment'];
		$sql = "INSERT INTO comments (post_id, user_id, comment)
		VALUES ('".$post_id."', '".$user_id."', '".$comment."')";
		mysqli_query($conn, $sql);
		header("Location: .");
	}else{
		print 'Not signed in.';
	}
}

?>