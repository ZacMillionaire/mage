<?php
	include "researchMenu.php";
?>
<div id="dashboard-news-items-container">
	<?php
		// coming from dashboard::pageData, set in newsModel.php
	if(!empty(Main::$pageData["researchList"])) {
		foreach(Main::$pageData["researchList"] as $key => $value){
	?>
	<div class="news-item">
		<div class="news-title"><?php echo $value["title"]; ?></div>
		<div class="news-meta">
			<div class="meta-start-date">
				Started: <?php echo Main::AdjustDate($value["dateStarted"],false); ?>
			</div>
			<div class="meta-end-date">
				Ended: <?php

				if($value["dateEnded"] === null) {
					echo "(On going)";
				} else {
					echo Main::AdjustDate($value["dateEnded"],false);			
				}

				?>
			</div>
		</div>
		<div class="news-short">
			<?php echo $value["short_body"]; ?>
		</div>
		<div class="news-menu">
			<a href="/mage/research/<?php echo Main::UrlifyArticleTitle($value["title"],$value["researchID"]); ?>">View</a> &bull;
			<a class="safe" href="/mage/dashboard/research/edit/<?php echo $value["researchID"]; ?>">Edit</a> &bull;
			<a class="safe" href="/mage/dashboard/research/update/<?php echo $value["researchID"]; ?>">Update</a> &bull;
			<a class="danger" href="/mage/dashboard/research/delete/<?php echo $value["researchID"]; ?>">Delete</a>
		</div>
	</div>
	<?php
		}
	} else {
	?>
	<div class="news-item">
		No entries
	</div>
	<?php
	}
	?>
</div>