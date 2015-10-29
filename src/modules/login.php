<?php

/**
* - Hook init()
*/
function login_init()
{
	$url = new Url("login", "login_page", false);
	Core::get()->addUrl($url);
	Core::get()->setFrontPageUrl("login");

	$url = new Url("login_ajax", "login_ajax", false);
	Core::get()->addUrl($url);

	$url = new Url("logout", "logout_page");
	Core::get()->addUrl($url);

	Core::get()->loadTemplate('main');	
}

function login_page()
{
	Core::get()->addJs('js/login.js');
	Core::get()->setActiveTemplate("main");
	//action="index.php?q=login_ajax"

	$username = isset($_COOKIE['cookie_username']) ? $_COOKIE['cookie_username'] : '';
	$password = isset($_COOKIE['cookie_password']) ? $_COOKIE['cookie_password'] : '';

	$checked = isset($_COOKIE['cookie_rememberMe']) && $_COOKIE['cookie_rememberMe'] == 'y' ? 'checked="checked"' : '';
	
	$output = '
			<form id="login_form" data-ajax="false" action="index.php?q=login_ajax" method="post">
				<div data-role="fieldcontain" class="ui-hide-label">
					<label for="username">Brugernavn:</label>
					<input type="text" name="username" id="username" value="'.$username.'" placeholder="Brugernavn"/>
				</div>
				<div data-role="fieldcontain" class="ui-hide-label">
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" value="'.$password.'" placeholder="Password"/>
				</div>
				<div data-role="fieldcontain">
					<label for="rememberMe">Husk mig</label>
					<input data-inline="true" type="checkbox" id="rememberMe" name="rememberMe" '.$checked.' class="custom" />
				</div>
				
				<button type="submit" data-theme="a">Login</button>
				
			</form>
	';

	return $output;
}

function login_ajax()
{
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$remember = isset($_REQUEST['rememberMe']) ? true : false;
	
	$user = Core::get()->fetchRecord("users", array('username' => $username));
	if($user === false)
	{
		Core::get()->loggedIn(false);
		echo ':(';
		return;
	}	
	
	if($username == $user->username && md5($password) == $user->password) {
		if($remember) {
			/* Set cookie to last 1 year */
			setcookie('cookie_username', $_REQUEST['username'], time()+60*60*24*31);
			setcookie('cookie_password', $_REQUEST['password'], time()+60*60*24*31);
			setcookie('cookie_rememberMe', 'y', time()+60*60*24*31);
		} else {
			/* Cookie expires when browser closes */
			setcookie('cookie_username', $_REQUEST['username'], 1);
			setcookie('cookie_password', $_REQUEST['password'], 1);
			setcookie('cookie_rememberMe', 'n', 1);
		}
		Core::get()->loggedIn(true,$user->id);
		echo ':)';
	} else {
		Core::get()->loggedIn(false);
		echo ':(';
	}
	return;
}

function logout_page()
{
	// Unset some cookie shit
	// Say bye
	Core::get()->loggedIn(false);
	$output = '
		<h3>Du er nu logget ud - tak for besøget</h3>
		<form id="login_again" action="index.php?q=login" method="post">
			<button type="submit" data-theme="a">Login igen</button>
		</form>
	';

	return $output;
}

function login_schema()
{		
	$schema['users'] = array(
	  'description' => 'TODO: please describe this table!',
	  'fields' => array(
		'id' => array(
		  'description' => 'Id',
		  'type' => 'int',
		  'not null' => TRUE,
		),
		'active' => array(
		  'description' => 'Is the user active thus allowed to logged in',
		  'type' => 'int',
		  'not null' => TRUE,
		),		
		'navn' => array(
		  'description' => 'Users real name',
		  'type' => 'varchar',
		  'length' => '255',
		  'not null' => TRUE,
		),
		'username' => array(
		  'description' => 'Username for login',
		  'type' => 'varchar',
		  'length' => '255',
		  'not null' => TRUE,
		),
		'password' => array(
		  'description' => 'Password for login',
		  'type' => 'varchar',
		  'length' => '255',
		  'not null' => TRUE,
		),				
	  ),
	  'primary key' => array('id'),
	);
	
	return $schema;
}


	/*
	//echo "<pre>";

	// insert
	$test = new stdClass();
	$test->user_id = 6;
	$test->mail = "fisse@norbert.dk";
	$test->created = 201;
	Core::get()->writeRecord("testtable", $test);
	//print_r($test);

	// update
	$test->mail = "kusse@norbert.dk";
	$test->created = 301;
	Core::get()->writeRecord("testtable", $test);
	//print_r($test);

	$records = Core::get()->dbQuery("SELECT * FROM testtable");
	//print_r($records);




	$rec = Core::get()->fetchRecord("testtable", array('id' => 2));
	$rec->mail = "snotsovs@hundehoved.com";
	Core::get()->writeRecord("testtable", $rec);
	echo "<pre>";
	print_r($rec);



	$records = Core::get()->fetchRecords("testtable", array('user_id' => 6, 'created' => 201));
	//echo "<pre>";
	//print_r($records);


	$records = Core::get()->dbQuery("SELECT * FROM testtable WHERE created > :created AND id > :id", array(':created' => 200, ":id" => 1));
	*/
