<div class="header title">
	<h1>News Archive</h1>
</div>
<div class="news-container">

	<div class="news-pagination">
		<?php
			if(self::$pageData["pages"] > 1){
				for($i = 1; $i <= self::$pageData["pages"]; $i++){
					if(self::$pageData["currentPage"] == $i){
					?>
					<div class="pagination-index current"><?php echo $i; ?></div>
					<?php	
					} else {
					?>
					<div class="pagination-index">
						<a href="news/p/<?php echo $i; ?>">
							<?php echo $i; ?>
						</a>
					</div>
					<?php	
					}
				}
			}
		?>
	</div>

	<?php
		// coming from dashboard::pageData, set in newsModel.php
		foreach(self::$pageData["newsList"] as $key => $value){
	?>
	<div class="news-item">
		<div class="news-title"><h1><?php echo $value["title"]; ?></h1></div>
		<div class="news-meta">
			<?php
			echo parent::AdjustDate($value["datePosted"]);
			?>
			<a href="news/<?php echo parent::UrlifyArticleTitle($value["title"],$value["newsID"]); ?>">Read</a>
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
				<a href="news/<?php echo parent::UrlifyArticleTitle($value["title"],$value["newsID"]); ?>">Read Full Article</a>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php
		}
	?>

	<div class="news-pagination">
		<?php
			if(self::$pageData["pages"] > 1){
				for($i = 1; $i <= self::$pageData["pages"]; $i++){
					if(self::$pageData["currentPage"] == $i){
					?>
					<div class="pagination-index current"><?php echo $i; ?></div>
					<?php	
					} else {
					?>
					<div class="pagination-index">
						<a href="news/p/<?php echo $i; ?>">
							<?php echo $i; ?>
						</a>
					</div>
					<?php	
					}
				}
			}
		?>
	</div>

</div>