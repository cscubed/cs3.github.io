<?php 
require_once('conn.php');
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
?>

<!DOCTYPE html>
<head>
    <title>CS3</title>
    <meta charset="UTF-8">
    <meta content="Computer Science Student Society">
    <meta keywords="computer,science,student,society,waikato,university,group">
	<meta name="Elle Philbrick" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/posts.css">

	<script src="js/jquery-2.1.1.min.js"></script>
</head>

<body>
	<img src="assets/logo.png" id="logo">
	<img src="assets/hamburger.png" class="hamburger">
	<img src="assets/cross.png" class="cross">
	<div class="menu">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="http://www.facebook.com/cscubed">Facebook</a></li>
			<li><a href="about.php">About/Contact Us</a></li>
			<?php if(isset($_SESSION["user_id"])): ?>
			<?php
				if($rank == 'admin'){
					print '<li><a href="create_post.php">Create Post</a></li>';
				}
			?>
			<?php print '<li>Logged in as: <b>'.$username. '</b>, '.$firstname.'</li>'; ?>
			<li><a href="logout.php">Logout</a></li> 
			<?php else: ?>
			<li><a href="login_page.php">Login</a></li>
			<li><a href="create_user.php">Create User</a></li>
			<?php endif; ?>
		</ul>
	</div>

	<div id="nav2">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="http://www.facebook.com/cscubed">Facebook</a></li>
			<li><a href="about.php">About/Contact Us</a></li>
			<?php if(isset($_SESSION["user_id"])): ?>
			<?php
				if($rank == 'admin'){
					print '<li><a href="create_post.php">Create Post</a></li>';
				}
			?>
			<?php print '<li>Logged in as: <b>'.$username. '</b>, '.$firstname.'</li>'; ?>
			<li><a href="logout.php">Logout</a></li> 
			<?php else: ?>
			<li><a href="login_page.php">Login</a></li>
			<li><a href="create_user.php">Create User</a></li>
			<?php endif; ?>
		</ul>
	</div>
</body>