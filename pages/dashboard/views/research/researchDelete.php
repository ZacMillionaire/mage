<?php
	include "researchMenu.php";
?>

<?php if(!isset($_POST["action"]) && !isset(self::$pageData["deleted"])) { ?>
<div class="header title">
	<h1>Delete Research Entry</h1>
</div>
<div class="form-section">
	<form action="/mage/dashboard/research/delete/<?php echo @self::$pageData["researchEntryData"]["researchID"]; ?>" method="POST">

		<?php
			if(isset(self::$pageData["error"])){
		?>
		<div class="form-error">
			<div class="form-error-header">
				<h2>
					<i class="fa fa-exclamation-circle"></i>
					Resource not found!
				</h2>
			</div>
			<div class="form-error-body">
				<?php echo self::$pageData["error"]; ?>
			</div>
		</div>
		<?php
			} else {
		?>
		<div class="form-error">
			<div class="form-error-header">
				<h2>
					<i class="fa fa-exclamation-circle"></i>
					Are you sure you want to delete this research entry?
				</h2>
			</div>
			<div class="form-error-body">
				<div class="article-header">
					<h1><?php echo self::$pageData["researchEntryData"]["title"]; ?></h1>
				</div>
				<div class="article-body">
					<?php echo self::$pageData["researchEntryData"]["full_body"]; ?>
				</div>
			</div>
		</div>
		<?php
			}
		?>
		<div class="form-button full-width">
		<?php
			if(!isset(self::$pageData["error"])){
		?>
			<button class="blue" type="submit" name="action" value="cancel">Cancel</button>
			<button class="red" type="submit" name="action" value="delete"><i class="fa fa-exclamation-circle"></i> Delete</button>
		<?php
			} else {
		?>
			<button class="green" type="submit" name="action" value="cancel">Go Back</button>
		<?php
			}
		?>
		</div>
	</form>
</div>
<?php } elseif(@self::$pageData["deleted"]===true){ ?>
<div class="dashboard-message">
	<div class="header title">
		<h1>Research Entry Deleted</h1>
	</div>
	<a href="/mage/dashboard/research/list/">Return to List</a>
</div>
<?php } else { // article not found but form data posted ie it's already deleted ?>
		<div class="form-error">
			<div class="form-error-header">
				<h2>
					<i class="fa fa-exclamation-circle"></i>
					Resource not found!
				</h2>
			</div>
			<div class="form-error-body">
				<?php echo self::$pageData["error"]; ?>
			</div>
			<a href="/mage/dashboard/research/">Go back</a>
		</div>
<?php } ?>