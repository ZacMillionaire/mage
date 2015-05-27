<?php
	include "newsMenu.php";
?>

<?php
foreach(self::$pageData["newsList"] as $key => $value) {
?>
<div class="news-list-item">
	<div class="news-list-title">
		<a href="/mage/news/view/<?php echo Main::UrlifyArticleTitle($value["title"],$value["newsID"]); ?>">
			<h3><?php echo $value["title"]; ?></h3>
		</a>
	</div>
	<div class="news-list-date">Posted On: <?php

	echo Main::AdjustDate($value["datePosted"]);
	
	?>
	</div>
	<div class="news-list-options">
		<a class="safe" href="/mage/dashboard/news/edit/<?php echo $value["newsID"]; ?>">Edit</a>
		&bull;
		<a class="danger" href="/mage/dashboard/news/delete/<?php echo $value["newsID"]; ?>">Delete</a>
	</div>
</div>
<?php
}
?>