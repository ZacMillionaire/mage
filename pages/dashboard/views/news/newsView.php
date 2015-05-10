<?php
	include "newsMenu.php";
?>
<div id="dashboard-news-items-container">
	<?php
		// coming from dashboard::pageData, set in newsModel.php
		foreach(self::$pageData["shortNewsList"] as $key => $value){
	?>
	<div class="news-item">
		<div class="news-title"><?php echo $value["title"]; ?></div>
		<div class="news-meta"><?php echo $value["datePosted"]; ?></div>
		<div class="news-short">
			<?php echo $value["short_body"]; ?>
		</div>
	</div>
	<?php
		}
	?>
</div>