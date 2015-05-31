<?php require "system/main.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
	<h1>Login</h1>
	<form action="system/actions/login-user.php" method="POST">
		<input type="email" name="email" placeholder="Email" required/><br/>
		<input type="password" name="password" placeholder="Password" required/>
		<button type="submit">Login</button>
	</form>
</body>
</html>