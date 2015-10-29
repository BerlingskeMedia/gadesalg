<?php
$config = array();
$config['site_title'] = "mInga";
$config['modules_dir'] = "modules";
$config['templates_dir'] = "templates";
$config['db_driver'] = "pgsql";
$config['db_host'] = $_ENV["db_host"];
$config['db_database'] = $_ENV["db_database"];
$config['db_user'] = $_ENV["db_user"];
$config['db_pass'] = $_ENV["db_pass"];
$config['db_auto_create_tables'] = true;
