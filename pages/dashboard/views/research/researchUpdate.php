<?php
	include "researchMenu.php";
?>

<?php

//print_r(Main::$pageData["researchEntryData"]);

?>

<?php if(isset(Main::$pageData["researchEntryLink"])){ ?>
<div class="dashboard-message">
	<div class="header title">
		<h1>Update Added</h1>
	</div>
	<a href="/mage/research/<?php echo Main::$pageData["researchEntryLink"]; ?>">View Updated Entry</a>
</div>
<?php } ?>

<?php if(@isset(Main::$pageData["updatePreview"])){ ?>
<div class="article-preview">
	<div class="header title">
		<h1>Update Preview</h1>
	</div>
	<div class="article-container">
		<?php echo Main::$pageData["updatePreview"]; ?>
	</div>
</div>
<?php } ?>

<?php if(!isset(Main::$pageData["researchEntryLink"])){ ?>
<div class="header dashboard-title">
	<h1>Update Research Entry</h1>
</div>
<div class="form-section">
	<div class="form-help">
		We use markdown!
		some markdown hints or w/e
	</div>
	<form action="/mage/dashboard/research/update/<?php echo @Main::$pageData["researchEntryData"]["researchID"]; ?>" method="POST">
		<div class="form-input">
			<input type="text" placeholder="Update Title" name="updateTitle" value="<?php echo (isset($_POST["updateTitle"])) ? $_POST["updateTitle"] : null; ?>" required pattern="(\w+\s?)+"/>
		</div>
		<div class="form-input">
			<textarea name="updateBody" placeholder="Update Body" cols="30" rows="10" required pattern="(\w+\s?)+"><?php
			echo (isset($_POST["updateBody"])) ? $_POST["updateBody"] : null; ?></textarea>
		</div>
		<div class="form-button full-width">
			<button class="blue" type="submit" name="action" value="preview">Preview</button>
			<button class="green" type="submit" name="action" value="post">Add Update</button>
		</div>
	</form>
</div>
<?php } ?>