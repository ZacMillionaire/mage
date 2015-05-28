<?php
	include "newsMenu.php";
?>

<?php if(!isset($_POST["action"]) && !isset(Main::$pageData["deleted"])) { ?>
<div class="header title">
	<h1>Delete Article</h1>
</div>
<div class="form-section">
	<form action="/mage/dashboard/news/delete/<?php echo @Main::$pageData["articleData"]["newsID"]; ?>" method="POST">

		<div class="form-error">
			<div class="form-error-header">
				<h2>
					<i class="fa fa-exclamation-circle"></i>
					Are you sure you want to delete this article?
				</h2>
			</div>
			<div class="form-error-body">
			<?php

				if(isset(Main::$pageData["error"])){
					echo Main::$pageData["error"];	
				} else {
			?>
				<div class="article-header">
					<h1><?php echo Main::$pageData["articleData"]["title"]; ?></h1>
				</div>
				<div class="article-body">
					<?php echo Main::$pageData["articleData"]["full_body"]; ?>
				</div>
			<?php
				}
			?>
			</div>
		</div>

		<div class="form-button full-width">
			<button class="blue" type="submit" name="action" value="cancel">Cancel</button>
			<button class="red" type="submit" name="action" value="delete"><i class="fa fa-exclamation-circle"></i> Delete</button>
		</div>
	</form>
</div>
<?php } elseif(Main::$pageData["deleted"]===true){ ?>
<div class="dashboard-message">
	<div class="header title">
		<h1>Article Deleted</h1>
	</div>
	<a href="/mage/dashboard/news/list/">Return to List</a>
</div>
<?php } ?>