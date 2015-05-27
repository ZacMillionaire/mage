<?php
	include "researchMenu.php";
?>

<?php
foreach(self::$pageData["researchList"] as $key => $value) {
?>
<div class="news-list-item">
	<div class="news-list-title">
		<a href="/mage/research/view/<?php echo Main::UrlifyArticleTitle($value["title"],$value["researchID"]); ?>">
			<h3><?php echo $value["title"]; ?></h3>
		</a>
	</div>
	<div class="news-list-date">Started: <?php
/*
	$date = new DateTime($value["dateStarted"], new DateTimeZone('UTC')); 
	date_default_timezone_set("Australia/Brisbane");
	echo date("d/m/y g:ia", $date->format('U')); 
	date_default_timezone_set("UTC");
*/
		echo Main::AdjustDate($value["dateStarted"],false);
	?></div>
	<div class="news-list-date">Ended: <?php

	if($value["dateEnded"] === null) {
		echo "(On Going)";
	} else {
		echo Main::AdjustDate($value["dateStarted"],false);
	/*
		$date = new DateTime($value["dateEnded"], new DateTimeZone('UTC')); 
		date_default_timezone_set("Australia/Brisbane");
		echo date("d/m/y g:ia", $date->format('U')); 
		date_default_timezone_set("UTC");*/	
	}

	?></div>
	<div class="news-list-options">
		<a class="safe" href="/mage/dashboard/research/edit/<?php echo $value["researchID"]; ?>">Edit</a>
		&bull;
		<a class="safe" href="/mage/dashboard/research/update/<?php echo $value["researchID"]; ?>">Update</a>
		&bull;
		<a class="danger" href="/mage/dashboard/research/delete/<?php echo $value["researchID"]; ?>">Delete</a>
	</div>
</div>
<?php
}
?>