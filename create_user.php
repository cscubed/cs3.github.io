<?php include('header.php'); ?>

<div class="container">
	<form class="login" action="create.php?type=user" method="post">
		<table>
			<tr><td>Username:</td><td><input type="text" name="username"></td></tr>
			<tr><td>Name:</td><td><input type="text" name="firstname"></td></tr>
			<tr><td>Email Address:</td><td><input type="email" name="email"></td></tr>
			<tr><td>Password:</td><td><input type="password" name="password1"></td></tr>
			<tr><td>Password Confirm:</td><td><input type="password" name="password2"></td></tr>
		</table>
		<br>
		<input type="submit" value="Submit">
	</form>
<div>

<?php include('footer.php');