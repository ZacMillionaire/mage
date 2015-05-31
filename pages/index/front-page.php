<div class="header title">
	<h1>Latest News</h1>
</div>
<div class="news-container">
	<?php
		// coming from dashboard::pageData, set in newsModel.php
		foreach(Main::$pageData["newsList"] as $key => $value){
	?>
	<div class="news-item">
		<div class="news-title"><h1><?php echo $value["title"]; ?></h1></div>
		<div class="news-meta">
			<?php
			echo Main::AdjustDate($value["datePosted"]);
			?>
			<a href="news/<?php echo Main::UrlifyArticleTitle($value["title"],$value["newsID"]); ?>">Read</a>
			<?php
			if($sys->UserStatus["loggedIn"]) {
			?>
			&bull; <a href="dashboard/news/edit/<?php echo $value["newsID"]; ?>">Edit</a>
			<?php
			}
			?>
		</div>
		<div class="news-full <?php echo $value["overflow"]; ?>">
			<?php echo $value["full_body"]; ?>
			<?php if($value["overflow"] == "overflow"){ ?>
			<div class="read-more">
				<a href="news/<?php echo Main::UrlifyArticleTitle($value["title"],$value["newsID"]); ?>">Read Full Article</a>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php
		}

		if(count(Main::$pageData["newsList"]) == 5){
	?>
	<a href="news/p/1">Click here to read previous entries</a>
	<?php
		}
	?>
</div>