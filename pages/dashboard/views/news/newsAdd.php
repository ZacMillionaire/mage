<?php
	include "newsMenu.php";
?>

<?php if(isset(Main::$pageData["articleLink"])){ ?>
<div class="dashboard-message">
	<div class="header title">
		<h1>Article Posted</h1>
	</div>
	<a href="/mage/news/<?php echo Main::$pageData["articleLink"]; ?>">View Article</a>
</div>
<?php } ?>

<?php if(@isset(Main::$pageData["ArticlePreview"])){ ?>
<div class="article-preview">
	<div class="header title">
		<h1>Article Preview</h1>
	</div>
	<div class="article-container">
		<?php echo Main::$pageData["ArticlePreview"]; ?>
	</div>
</div>
<?php } ?>

<?php if(!isset(Main::$pageData["articleLink"])){ ?>
<div class="header dashboard-title">
	<h1>New Article</h1>
</div>
<div class="form-section">
	<div class="form-help">
		We use markdown!
		some markdown hints or w/e
	</div>
	<form action="/mage/dashboard/news/add" method="POST">
		<div class="form-input">
			<input type="text" placeholder="Title" name="title" value="<?php echo @$_POST["title"]; ?>" required pattern="(\w+\s?)+"/>
		</div>
		<div class="form-input">
			<input type="text" placeholder="Tags (comma seperated)" value="<?php echo @$_POST["tags"]; ?>" name="tags"/>
		</div>
		<div class="form-input">
			<textarea name="body" placeholder="News Body" cols="30" rows="10" required pattern="(\w+\s?)+"><?php echo @$_POST["body"]; ?></textarea>
		</div>
		<div class="form-button full-width">
			<button class="blue" type="submit" name="action" value="preview">Preview</button>
			<button class="green" type="submit" name="action" value="post">Post</button>
		</div>
	</form>
</div>
<?php } ?>