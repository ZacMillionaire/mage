<div class="header title">
	<h1><?php echo Main::$pageData["article"]["title"]; ?></h1>
</div>
<div class="news-container">
	<div class="news-item">
		<div class="news-meta">
			<?php
			echo Main::AdjustDate(Main::$pageData["article"]["datePosted"]);
			?>
			<?php
			if($sys->UserStatus["loggedIn"]) {
			?>
			&bull; <a href="/mage/dashboard/news/edit/<?php echo Main::$pageData["article"]["newsID"]; ?>">Edit</a>
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
			<?php echo Main::$pageData["article"]["full_body"]; ?>
		</div>
	</div>
</div>
<div id="back-to-top">
	<a href="#top"><i class="fa fa-arrow-up fa-2x"></i></a>
</div>