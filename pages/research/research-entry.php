<div class="header title">
	<h1><?php echo Main::$pageData["researchEntry"]["title"]; ?></h1>
</div>
<div class="news-container">
	<div class="news-item">
		<div class="news-meta">
			<div class="news-date">Started: <?php
				echo Main::AdjustDate(Main::$pageData["researchEntry"]["dateStarted"],false);
				?>
			</div>
			<div class="news-date">Ended: <?php
				if(Main::$pageData["researchEntry"]["dateEnded"] != null) {
					echo Main::AdjustDate(Main::$pageData["researchEntry"]["dateEnded"],false);
				} else {
					echo "(On Going)";
				}
				?>
			</div>
			<?php
			if($sys->UserStatus["loggedIn"]) {
			?>
			<a href="/mage/dashboard/research/edit/<?php echo Main::$pageData["researchEntry"]["researchID"]; ?>">Edit</a>
			&bull; <a href="/mage/dashboard/research/update/<?php echo Main::$pageData["researchEntry"]["researchID"]; ?>">Add Update</a>
			<?php
			}
			?>
		</div>

		<div class="article-toc-container">
			<h3>Table of contents</h3>
			<ol class="article-toc">
			<?php 
			foreach(Main::$pageData["ToC"] as $key => $value) {
			?>
				<li class="toc-level-<?php echo $value["depth"] ?>"><a href="#<?php echo $value["title"]; ?>"><?php echo $value["title"]; ?></a></li>
			<?php
			}
			?>
			</ol>
		</div>

		<div class="news-full">
			<?php echo Main::$pageData["researchEntry"]["full_body"]; ?>
		</div>
	</div>
</div>
<div id="back-to-top">
	<a href="#top"><i class="fa fa-arrow-up fa-2x"></i></a>
</div>