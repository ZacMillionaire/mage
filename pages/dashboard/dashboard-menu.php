<?php

$menu = '
	<ul class="side-menu">
		<li class="menu-item dashboard-item">
			<a href="./">Home</a>
		</li>
		<li class="menu-item dashboard-item">
			<a href="logout/">Logout</a>
		</li>
		<li class="menu-separator dashboard-item">
			Dashboard
		</li>
		<li class="menu-item {{active-index}} dashboard-item">
			<a href="dashboard/">Overview</a>
		</li>
		<li class="menu-item {{active-news}} dashboard-item">
			<a href="dashboard/news/">News</a>
		</li>
		<li class="menu-item {{active-research}} dashboard-item">
			<a href="dashboard/research/">Research</a>
		</li>
		<li class="menu-item {{active-publications}} dashboard-item">
			<a href="dashboard/publications/">Publications</a>
		</li>
		<li class="menu-item {{active-social}} dashboard-item">
			<a href="dashboard/social/">Social Media</a>
		</li>
		<li class="menu-item {{active-biography}} dashboard-item">
			<a href="dashboard/biography/">Biography</a>
		</li>
	</ul>
';

preg_match_all("/({{active-(.*?)}})/", $menu, $matchArray);

foreach($matchArray[2] as $key => $value){
	if($value === $sys->ActivePage){
		$menu = preg_replace("/{{active-$value}}/", "active-item", $menu);
	} else {
		$menu = preg_replace("/{{active-$value}}/", "", $menu);	
	}
}

echo $menu;
?>