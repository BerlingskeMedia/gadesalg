<?php

/**
* - Hook init()
*/
function menu_init()
{
	$url = new Url("menu", "menu_page");
	Core::get()->addUrl($url);

	Core::get()->loadTemplate('menu');
}

function menu_page()
{
	$user = Core::get()->getLoggedInUser();
	Core::get()->setActiveTemplate("menu");
	$output = '
		<h4>Velkommen ('.$user->navn.') '.$user->username.'</h4>
		<a href="index.php?q=order_new" data-transition="slide" data-icon="new" data-role="button" data-iconpos="right">Ny ordre</a>

		<a href="index.php?q=logout" data-transition="slide" data-icon="back" data-role="button" data-iconpos="right">Log ud</a>

	';
	
	return $output;
}

