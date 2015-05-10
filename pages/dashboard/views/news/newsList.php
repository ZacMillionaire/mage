<?php
	include "newsMenu.php";
?>

<?php
foreach(self::$pageData["newsList"] as $key => $value) {
?>
<div class="news-list-item">
	<div class="news-list-title"><a href="dashboard/news/edit/<?php echo $value["newsID"]; ?>"><?php echo $value["title"]; ?></a></div>
	<div class="news-list-date"><?php

	$date = new DateTime($value["datePosted"], new DateTimeZone('UTC')); 
	date_default_timezone_set("Australia/Brisbane");
	echo date("d/m/y g:ia", $date->format('U')); 
	date_default_timezone_set("UTC");

	?></div>
	<div class="news-list-delete"><a href="dashboard/news/delete/<?php echo $value["newsID"]; ?>">Delete</a></div>
</div>
<?php
}
?>