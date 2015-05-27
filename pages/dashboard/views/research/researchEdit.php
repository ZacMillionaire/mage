<?php
	include "researchMenu.php";
?>

<?php

//print_r(self::$pageData["researchEntryData"]);

?>

<?php if(isset(self::$pageData["researchEntryLink"])){ ?>
<div class="dashboard-message">
	<div class="header title">
		<h1>Article Updated</h1>
	</div>
	<a href="/mage/research/<?php echo self::$pageData["researchEntryLink"]; ?>">View Updated Article</a>
</div>
<?php } ?>

<?php if(@isset(self::$pageData["researchPreview"])){ ?>
<div class="article-preview">
	<div class="header title">
		<h1>Article Preview</h1>
	</div>
	<div class="article-toc">
		<ol class="article-toc-container" id="top">
		<?php 
		foreach(self::$pageData["ToC"] as $key => $value) {
		?>
			<li class="toc-level-<?php echo $value["depth"] ?>"><a href="#<?php echo $value["title"]; ?>"><?php echo $value["title"]; ?></a></li>
		<?php
		}
		?>
		</ol>
	</div>
	<div class="article-container">
		<?php echo self::$pageData["researchPreview"]; ?>
	</div>
</div>
<?php } ?>

<?php if(!isset(self::$pageData["researchEntryLink"])){ ?>
<div class="header dashboard-title">
	<h1>Edit Article</h1>
</div>
<div class="form-section">
	<div class="form-help">
		We use markdown!
		some markdown hints or w/e
	</div>
	<form action="/mage/dashboard/research/edit/<?php echo @self::$pageData["researchEntryData"]["researchID"]; ?>" method="POST">
		<div class="form-input">
			<input type="text" placeholder="Title" name="title" value="<?php echo (isset($_POST["title"])) ? $_POST["title"] : self::$pageData["researchEntryData"]["title"]; ?>" required pattern="(\w+\s?)+"/>
		</div>
		<div class="form-input">
			<input type="text" placeholder="Date Started: DD/MM/YYYY" value="<?php echo (isset($_POST["dateStarted"])) ? $_POST["dateStarted"] : self::$pageData["researchEntryData"]["dateStarted"]; ?>" name="dateStarted" required/>
		</div>
		<div class="form-input">
			<input type="text" placeholder="Date Ended (if it has): DD/MM/YYYY" value="<?php echo (isset($_POST["dateEnded"])) ? $_POST["dateEnded"] : self::$pageData["researchEntryData"]["dateEnded"]; ?>" name="dateEnded"/>
		</div>
		<div class="form-input">
			<textarea name="body" placeholder="News Body" cols="30" rows="10" required pattern="(\w+\s?)+"><?php
			echo (isset($_POST["body"])) ? $_POST["body"]: self::$pageData["researchEntryData"]["full_body"];
			?></textarea>
		</div>
		<div class="form-button full-width">
			<button class="blue" type="submit" name="action" value="preview">Preview</button>
			<button class="green" type="submit" name="action" value="post">Update</button>
		</div>
	</form>
</div>
<?php } ?>