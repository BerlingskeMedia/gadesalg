<?php
/*
	file   : index.php												
	author : bison

*/
session_start();

include "config.php";
require_once("Template.class.php");
require_once("Url.class.php");
require_once("Core.class.php");

Core::get()->init($config);
Core::get()->processQuery();
Core::get()->render();
Core::get()->shutdown();



