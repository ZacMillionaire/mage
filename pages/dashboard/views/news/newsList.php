<?php
	include "newsMenu.php";
?>

<?php
foreach(self::$pageData["newsList"] as $key => $value) {
?>
<div class="news-list-item">
	<div class="news-list-title">
		<a href="news/view/<?php echo Main::UrlifyArticleTitle($value["title"],$value["newsID"]); ?>">
			<h3><?php echo $value["title"]; ?></h3>
		</a>
	</div>
	<div class="news-list-date">Posted On: <?php

	$date = new DateTime($value["datePosted"], new DateTimeZone('UTC')); 
	date_default_timezone_set("Australia/Brisbane");
	echo date("d/m/y g:ia", $date->format('U')); 
	date_default_timezone_set("UTC");

	?></div>
	<div class="news-list-options">
		<a class="safe" href="dashboard/news/edit/<?php echo $value["newsID"]; ?>">Edit</a>
		&bull;
		<a class="danger" href="dashboard/news/delete/<?php echo $value["newsID"]; ?>">Delete</a>
	</div>
</div>
<?php
}
?>