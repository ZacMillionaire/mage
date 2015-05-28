<div class="header title">
	<h1>News Archive</h1>
</div>
<div class="news-container">

	<div class="news-pagination">
		<?php
			if(Main::$pageData["pages"] > 1){
				for($i = 1; $i <= Main::$pageData["pages"]; $i++){
					if(Main::$pageData["currentPage"] == $i){
					?>
					<div class="pagination-index current"><?php echo $i; ?></div>
					<?php	
					} else {
					?>
					<div class="pagination-index">
						<a href="/mage/news/p/<?php echo $i; ?>">
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
		foreach(Main::$pageData["newsList"] as $key => $value){
	?>
	<div class="news-item">
		<div class="news-title"><h1><?php echo $value["title"]; ?></h1></div>
		<div class="news-meta">
			<?php
			echo Main::AdjustDate($value["datePosted"]);
			?>
			<a href="/mage/news/<?php echo Main::UrlifyArticleTitle($value["title"],$value["newsID"]); ?>">Read</a>
			<?php
			if($sys->UserStatus["loggedIn"]) {
			?>
			&bull; <a href="/mage/dashboard/news/edit/<?php echo $value["newsID"]; ?>">Edit</a>
			<?php
			}
			?>
		</div>
		<div class="news-full <?php echo $value["overflow"]; ?>">
			<?php echo $value["full_body"]; ?>
			<?php if($value["overflow"] == "overflow"){ ?>
			<div class="read-more">
				<a href="/mage/news/<?php echo Main::UrlifyArticleTitle($value["title"],$value["newsID"]); ?>">Read Full Article</a>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php
		}
	?>

	<div class="news-pagination">
		<?php
			if(Main::$pageData["pages"] > 1){
				for($i = 1; $i <= Main::$pageData["pages"]; $i++){
					if(Main::$pageData["currentPage"] == $i){
					?>
					<div class="pagination-index current"><?php echo $i; ?></div>
					<?php	
					} else {
					?>
					<div class="pagination-index">
						<a href="/mage/news/p/<?php echo $i; ?>">
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