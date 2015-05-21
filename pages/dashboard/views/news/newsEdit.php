<?php
	include "newsMenu.php";
?>

<?php

//print_r(self::$pageData["articleData"]);

?>

<?php if(isset(self::$pageData["articleLink"])){ ?>
<div class="dashboard-message">
	<div class="header title">
		<h1>Article Updated</h1>
	</div>
	<a href="news/<?php echo self::$pageData["articleLink"]; ?>">View Updated Article</a>
</div>
<?php } ?>

<?php if(@isset(self::$pageData["ArticlePreview"])){ ?>
<div class="article-preview">
	<div class="header title">
		<h1>Article Preview</h1>
	</div>
	<div class="article-container">
		<?php echo self::$pageData["ArticlePreview"]; ?>
	</div>
</div>
<?php } ?>

<?php if(!isset(self::$pageData["articleLink"])){ ?>
<div class="header dashboard-title">
	<h1>Edit Article</h1>
</div>
<div class="form-section">
	<div class="form-help">
		We use markdown!
		some markdown hints or w/e
	</div>
	<form action="dashboard/news/edit/<?php echo @self::$pageData["articleData"]["newsID"]; ?>" method="POST">
		<div class="form-input">
			<input type="text" placeholder="Title" name="title" value="<?php echo (isset($_POST["title"])) ? $_POST["title"] : self::$pageData["articleData"]["title"]; ?>" required pattern="(\w+\s?)+"/>
		</div>
		<div class="form-input">
			<input type="text" placeholder="Tags (comma seperated)" value="<?php echo (isset($_POST["tags"])) ? $_POST["tags"] : self::$pageData["articleData"]["tags"]; ?>" name="tags"/>
		</div>
		<div class="form-input">
			<textarea name="body" placeholder="News Body" cols="30" rows="10" required pattern="(\w+\s?)+"><?php
			echo (isset($_POST["body"])) ? $_POST["body"]: self::$pageData["articleData"]["full_body"];
			?></textarea>
		</div>
		<div class="form-button full-width">
			<button class="blue" type="submit" name="action" value="preview">Preview</button>
			<button class="green" type="submit" name="action" value="post">Update</button>
		</div>
	</form>
</div>
<?php } ?>