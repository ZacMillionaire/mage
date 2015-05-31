<?php
	include "newsMenu.php";
?>
<div id="dashboard-news-items-container">
	<?php
		// coming from dashboard::pageData, set in newsModel.php
	if(!empty(self::$pageData["shortNewsList"])) {
		foreach(self::$pageData["shortNewsList"] as $key => $value){
	?>
	<div class="news-item">
		<div class="news-title"><?php echo $value["title"]; ?></div>
		<div class="news-meta"><?php echo Main::AdjustDate($value["datePosted"]); ?></div>
		<div class="news-short">
			<?php echo $value["short_body"]; ?>
		</div>
		<div class="news-menu">
			<a href="/mage/news/<?php echo Main::UrlifyArticleTitle($value["title"],$value["newsID"]); ?>">View</a> &bull;
			<a class="safe" href="/mage/dashboard/news/edit/<?php echo $value["newsID"]; ?>">Edit</a> &bull;
			<a class="danger" href="/mage/dashboard/news/delete/<?php echo $value["newsID"]; ?>">Delete</a>
		</div>
	</div>
	<?php
		}
	} else {
	?>
	<div class="news-item">
		No Entries.
	</div>
	<?php
	}
	?>
</div>