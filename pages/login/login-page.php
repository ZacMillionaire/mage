<?php
	if($Login["status"] === "default") {
?>
	<div class="header">
		<h1>Login</h1>
	</div>

	<?php if(isset($errorMessage)) { ?>

	<div class="form-error">

		<div class="form-error-header">
			<h2>
				<i class="fa fa-exclamation-circle"></i>
				<?php echo $errorMessage["header"]; ?>
			</h2>
		</div>

		<?php if($errorMessage["body"]) { ?>
		<div class="form-error-body">
			<?php

			echo $errorMessage["body"];

			?>
		</div>
		<?php } ?>

	</div>

	<?php } ?>
	
	<?php
		if($Login["showForm"] === true) {
	?>
	
	<div class="form-section">
		<form action="login" method="POST">
			<div class="form-input email">
				<input type="email" name="email" placeholder="Email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>" required/>
			</div>
			<div class="form-input password">
				<input type="password" name="password" placeholder="Password" required/>
			</div>
			<div class="form-button full-width">
				<button class="form-submit positive" type="submit">Login</button>
			</div>
		</form>
	</div>
	<?php
		} else {
	?>

	<h1>You are already logged in. <a href="logout">Logout?</a></h1>

	<?php
		}
	?>
<?php 
	} elseif($Login["status"] === "success") {
?>
	<h1>You are now sucessfully logged in! You will be redirected to the front page in 5 seconds.</h1>
	<h1>Click <a href="<?php echo self::$basePath; ?>">here</a> if you do not wish to wait, or you don't get redirected.</h1>
<?php } ?>