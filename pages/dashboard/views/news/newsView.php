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
		<div class="news-menu">
			<a href="news/view/<?php echo Main::UrlifyArticleTitle($value["title"],$value["newsID"]); ?>">View</a>
			<a class="safe" href="dashboard/news/edit/<?php echo $value["newsID"]; ?>">Edit</a>
			<a class="danger" href="dashboard/news/delete/<?php echo $value["newsID"]; ?>">Delete</a>
		</div>
	</div>
	<?php
		}
	?>
</div>