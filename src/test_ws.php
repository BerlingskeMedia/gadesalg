<?php
require_once("jsonRPCClient.php");

try
{
	$url = "http://localhost/minga/index.php?q=mingapi";
	$api = new jsonRPCClient($url, true);
	$api->login("bison", "45fisser");
	$res = $api->test();
	echo "Reply from server: $res\n";
}
catch(Exception $e)
{
	echo("Der opstod en fejl.\n");
	//print_r($e);
}

