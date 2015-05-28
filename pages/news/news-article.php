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
		<div class="article-toc">
			Table of contents
			<ol class="article-toc-container" id="top">
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