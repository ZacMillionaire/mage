<?php require "system/main.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
	<h1>Register</h1>
	<form action="system/actions/register-user.php" method="POST">
		<input type="email" name="email" placeholder="Email" required/><br/>
		<input type="password" name="password" placeholder="Password" required/>
		<button type="submit">Register</button>
	</form>
</body>
</html>