<?php
include('conn.php');

if(isset($_SESSION["user_id"])){
	$user_id = $_SESSION["user_id"];
	$sql = "select username, firstname, rank from users where id = ? limit 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($user_id));
    $row = $stmt->fetch();

    if ($row) {
		$username = $row['username'];
		$firstname = $row['firstname'];
		$rank = $row['rank'];
    }
}

$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);

if($type == 'user'){
	if(!isset($_POST['username']) || empty($_POST['username'])) {
		print '
		<div class="container">
			Please enter a valid username.
		</div>';
	} else {
		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
		$firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$password1 = md5($_POST['password1']);
		$password2 = md5($_POST['password2']);

		if(!($password1 == $password2)){
			print "Passwords don't match";
		}else{
			$sql = "insert into users (username, firstname, email, password, rank)
			values (:username, :firstname, :email, :password)";

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password1);

			if ($stmt->execute()) {
				header("Location: .");
            } else {
                print_r($dbh->errorInfo());
                die();
            }
		}
	}
}elseif($type == 'post'){
	if(isset($_SESSION["user_id"])){
		if($rank == 'admin'){
			$user_id = $_SESSION["user_id"];
			$content = filter_var($_POST['content'], FILTER_UNSAFE_RAW);

            $sql = "insert into posts (user_id, content)
            values (:user_id, :content)";

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':content', $content);

			if ($stmt->execute()) {
				header("Location: .");
            } else {
                print_r($dbh->errorInfo());
                die();
            }
		}else{
			print "You don't have permission to post";
		}
	}else{
		print 'Not signed in.';
	}
}elseif($type == 'comment'){
	if(isset($_SESSION["user_id"])){
		$user_id = $_SESSION["user_id"];
		$post_id = filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT);
		$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

        $sql = "insert into comments (post_id, user_id, comment)
        values (:post_id, :user_id, :comment)";

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':comment', $comment);

        if ($stmt->execute()) {
            header("Location: .");
        } else {
           print_r($dbh->errorInfo());
           die();
        }
	}else{
		print 'Not signed in.';
	}
}

?>
