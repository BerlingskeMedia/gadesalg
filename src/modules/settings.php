<?php

/**
* - Hook init()
*/
function settings_init()
{
	$url = new Url("settings", "settings_page");
	Core::get()->addUrl($url);
}

function settings_page()
{
	Core::get()->setActiveTemplate("app");
	
	$output = '
		<form id="settings" data-ajax="false" action="index.php?q=menu" method="post">

			<h2>Indstillinger:</h2>

			<div data-role="fieldcontain">
				<label for="test">Test</label>
				<input data-inline="true" type="checkbox" id="test" name="test" class="custom" />
			</div>

		</form>
	';
	
	return $output;
}


