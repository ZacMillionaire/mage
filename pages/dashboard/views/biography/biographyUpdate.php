<?php
	include "biographyMenu.php";
?>

<div class="dashboard-message">
	<div class="header title">
		<h1>[NYI]Update Profile</h1>
	</div>
</div>

<?php if(isset(Main::$pageData["profileLink"])){ ?>
<div class="dashboard-message">
	<div class="header title">
		<h1>Profile Updated</h1>
	</div>
	<a href="/mage/biography">View Profile Page</a>
</div>
<?php } ?>

<?php if(@isset(Main::$pageData["profilePreview"])){ ?>
<div class="article-preview">
	<div class="header title">
		<h1>Profile Preview</h1>
	</div>
	<div class="article-container">
		<?php echo Main::$pageData["profilePreview"]; ?>
	</div>
</div>
<?php } ?>

<?php if(!isset(Main::$pageData["profileLink"])){ ?>
<div class="header dashboard-title">
	<h1>Update Profile</h1>
</div>
<div class="form-section">
	<div class="form-help">
		We use markdown!
		some markdown hints or w/e
	</div>
	<form action="/mage/dashboard/biography/update" method="POST" enctype="multipart/form-data">
		<div class="form-input">
			<input type="text" placeholder="Given Names" name="given" value="<?php echo @$_POST["given"]; ?>" required pattern="(\w+\s?)+" disabled/>
		</div>
		<div class="form-input">
			<input type="text" placeholder="Last Name" value="<?php echo @$_POST["last"]; ?>" name="last" required  pattern="(\w+\s?)+" disabled/>
		</div>
		<div class="form-input">
			<input type="file" name="profileImage" disabled/>
		</div>
		<div class="form-input">
			<input type="text" name="member" placeholder="Research member since (dd/mm/yyyy)" required disabled/>
		</div>
		<div class="form-input">
			<textarea name="about" placeholder="Profile Information" cols="30" rows="10" required pattern="(\w+\s?)+" disabled><?php echo @$_POST["about"]; ?></textarea>
		</div>
		<div class="form-button full-width">
			<button class="red" type="submit" name="action" value="preview" disabled>Preview (disabled)</button>
			<button class="red" type="submit" name="action" value="post" disabled>Update (disabled)</button>
		</div>
	</form>
</div>
<?php } ?>