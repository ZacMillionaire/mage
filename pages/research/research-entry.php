<div class="header title">
	<h1><?php echo self::$pageData["researchEntry"]["title"]; ?></h1>
</div>
<div class="news-container">
	<div class="news-item">
		<div class="news-meta">
			<div class="news-date">Started: <?php
				echo parent::AdjustDate(self::$pageData["researchEntry"]["dateStarted"],false);
				?>
			</div>
			<div class="news-date">Ended: <?php
				if(self::$pageData["researchEntry"]["dateEnded"] != null) {
					echo parent::AdjustDate(self::$pageData["researchEntry"]["dateEnded"],false);
				} else {
					echo "(On Going)";
				}
				?>
			</div>
			<?php
			if($sys->UserStatus["loggedIn"]) {
			?>
			<a href="/mage/dashboard/research/edit/<?php echo self::$pageData["researchEntry"]["researchID"]; ?>">Edit</a>
			&bull; <a href="/mage/dashboard/research/update/<?php echo self::$pageData["researchEntry"]["researchID"]; ?>">Add Update</a>
			<?php
			}
			?>
		</div>

		<div class="article-toc">
			Table of contents
			<ol class="article-toc-container" id="top">
			<?php 
			foreach(self::$pageData["ToC"] as $key => $value) {
			?>
				<li class="toc-level-<?php echo $value["depth"] ?>"><a href="#<?php echo $value["title"]; ?>"><?php echo $value["title"]; ?></a></li>
			<?php
			}
			?>
			</ol>
		</div>

		<div class="news-full">
			<?php echo self::$pageData["researchEntry"]["full_body"]; ?>
		</div>
	</div>
</div>