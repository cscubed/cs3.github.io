<?php include('header.php'); ?>

<div class="container">
	<form class="login" action="login.php" method="post">
		<table>
			<tr><td>Username:</td><td><input type="text" name="username"></td></tr>
			<tr><td>Password:</td><td><input type="password" name="password"></td></tr>
		</table>
		<br>
		<input type="submit" value="Submit">
	</form>
</div>


<?php include('footer.php');