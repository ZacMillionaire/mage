<div class="header title">
	<h1>Research Entries</h1>
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
						<a href="/mage/news/p/<?php echo $i; ?>">
							<?php echo $i; ?>
						</a>
					</div>
					<?php	
					}
				}
			} else {
		?>
		<div class="pagination-index current">1</div>
		<?php
			}
		?>
	</div>

	<?php
		// coming from dashboard::pageData, set in researchPageModel.php
		foreach(self::$pageData["researchEntriesList"] as $key => $value){
	?>
	<div class="news-item">
		<div class="news-title"><h1><?php echo $value["title"]; ?></h1></div>
		<div class="news-meta">
			<div class="news-date">Started: <?php
				echo parent::AdjustDate($value["dateStarted"],false);
				?>
			</div>
			<div class="news-date">Ended: <?php
				if($value["dateEnded"] != null) {
					echo parent::AdjustDate($value["dateEnded"],false);
				} else {
					echo "(On Going)";
				}
				?>
			</div>
			<a href="/mage/research/<?php echo parent::UrlifyArticleTitle($value["title"],$value["researchID"]); ?>">Read</a>
			<?php
			if($sys->UserStatus["loggedIn"]) {
			?>
			&bull; <a href="/mage/dashboard/research/edit/<?php echo $value["researchID"]; ?>">Edit</a>
			&bull; <a href="/mage/dashboard/research/update/<?php echo $value["researchID"]; ?>">Add Update</a>
			<?php
			}
			?>
		</div>
		<div class="news-full <?php echo $value["overflow"]; ?>">
			<?php echo $value["full_body"]; ?>
			<?php if($value["overflow"] == "overflow"){ ?>
			<div class="read-more">
				<a href="/mage/research/<?php echo parent::UrlifyArticleTitle($value["title"],$value["researchID"]); ?>">Read Full Entry</a>
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
						<a href="/mage/research/p/<?php echo $i; ?>">
							<?php echo $i; ?>
						</a>
					</div>
					<?php	
					}
				}
			} else {
		?>
		<div class="pagination-index current">1</div>
		<?php
			}
		?>
	</div>

</div>