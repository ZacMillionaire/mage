<div class="header title">
	<h1><?php echo self::$pageData["article"]["title"]; ?></h1>
</div>
<div class="news-container">
	<div class="news-item">
		<div class="news-meta">
			<?php
			echo parent::AdjustDate(self::$pageData["article"]["datePosted"]);
			?>
			<?php
			if($sys->UserStatus["loggedIn"]) {
			?>
			&bull; <a href="/mage/dashboard/news/edit/<?php echo self::$pageData["article"]["newsID"]; ?>">Edit</a>
			<?php
			}
			?>
		</div>
		<div class="news-full">
			<?php echo self::$pageData["article"]["full_body"]; ?>
		</div>
	</div>
</div>