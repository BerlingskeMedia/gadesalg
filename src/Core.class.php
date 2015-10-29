<?php

function l($text, $url, $class = "")
{
	$href = 'index.php?q=' . $url;
	if(strlen($class) > 0)
		$link = '<a class="' . $class . '" href="' . $href . '">' . $text . '</a>';
	else
		$link = '<a href="' . $href . '">' . $text . '</a>';
	return $link;
}

function href($url)
{
	$href = 'index.php?q=' . $url;
	return $href;
}


function cmp_url_length($a, $b)
{
	if(strlen($a) > strlen($b))
		return false;
	else
		return true;
}

final class Core
{ 
	private static $_instance; 
	public $query;
	public $config;
	public $modules = array();
	public $templates = array();
	public $urls = array();
	public $css = array();
	public $js = array();
	public $content = "";
	public $schema = array();
	public $dbTables = array();
	public $dbh;
	public $frontPageUrl = "";
	public $activeTemplate = "main";

	private function __construct()
	{ 
	} 

	static function get()
	{ 
		if (!isset(self::$_instance))
		{ 
			$c = __CLASS__; 
			self::$_instance = new $c; 
		} 
		return self::$_instance; 
	} 

	// Prevent users to clone the instance 
	public function __clone() { 
		throw new Exception('Cannot clone the Core object.'); 
	} 
	
	public function init($config)
	{
		// save config object
		$this->config = $config;
		
		// init database connection
		$dsn = $config['db_driver'] . ":" . "dbname=" . $config['db_database'] . ";user=" . $config['db_user'] . ";password=" . $config['db_pass'] . ";host=" . $config['db_host'];
		$this->dbh = new PDO($dsn);
		
		// obtain query var
		$query = "/";
		if(isset($_REQUEST['q']))
			$query = $_REQUEST['q'];
		if(strlen($query) == 0)
			$query = "/";
		$this->query = $query;
			
		$this->loadTemplate("main");
		$this->loadModules();
		$this->initModules();
		// check schema
		$this->getTableList();
		if($this->config['db_auto_create_tables'])
			$this->createMissingTables();
	}
	
	public function render()
	{
		if(strlen($this->content) == 0)
			return;
		$main_tpl = $this->templates[$this->activeTemplate];

		// Javascript
		$js = '';
		foreach($this->js as $j) {
			$js .= "\t".'<script type="text/javascript" src="'.$j.'"></script>'."\n";
		}
		// CSS
		$css = '';
		foreach($this->css as $s) {
			$css .= "\t".'<link rel="stylesheet" type="text/css" href="'.$s.'" />'."\n";
		}
		// header
		$main_tpl->replace("%JS%", $js);
		$main_tpl->replace("%CSS%", $css);
		$main_tpl->replace("%TITLE%", $this->config['site_title']);
		$main_tpl->replace("%CONTENT%", $this->content);				
		$output = $main_tpl->getContent();
		print $output;
	}

	public function getLoggedInUser() {
		if(isset($_SESSION['logged_in_user']))
			return Core::get()->fetchRecord("users", array('id' => $_SESSION['logged_in_user']));
		return false;
	}

	public function isLoggedIn()
	{
		if(isset($_SESSION['is_logged_in'])) {
			return ($_SESSION['is_logged_in'] && $this->getLoggedInUser() != false);
		}
		return false;
	}
	
	public function getActiveUserId()
	{
		return $_SESSION['logged_in_user'];
	}

	public function loggedIn($bool,$user_id=NULL)
	{
		$_SESSION['is_logged_in'] = $bool;
		if($user_id != NULL)
			$_SESSION['logged_in_user'] = $user_id;

		if(!$bool)
			unset($_SESSION['logged_in_user']);
	}
	
	public function processQuery()
	{
		// Ensure user is logged in
		/*
		if(!$this->isLoggedIn() && $this->query != 'login_ajax') {
			if($this->query != 'login')
				header("Location: index.php?q=login");
			$this->query = 'login';
		}
		*/

		// if query is for front page / return first navmenu item
		
		if($this->query == "/")
		{
			if($this->frontPageUrl != "")
				$this->query = $this->frontPageUrl;
			else
			{
				$keys = array_keys($this->urls);
				$this->query = $keys[0];
			}
		}
		// sort url's by query length inorder to match longest first when doing partial matching
		uksort($this->urls, "cmp_url_length");
		//print_r($this->urls);
		// first we scan for exact matches (urls without parameters)
		if(in_array($this->query, array_keys($this->urls)))
		{
			$url = $this->urls[$this->query];
			if($url->requiresLogin && !$this->isLoggedIn())
			{
				header("Location: index.php?q=login");
				return;
			}
			$cb_func = $this->urls[$this->query]->getCallback();
			$result = call_user_func($cb_func);
			if($result != NULL)
				$this->content .= $result;
			// we found an exact match, return
			return;
		}
		/* 
			look for urls with arguments.. chop of a / level until we find a match
			and pass the discarded / levels as argument to the callback function.
			This works because we sorted the urls by descending length order (I hope)
		*/
		//print "Query: " . $this->query . "<br>";
		$query = $this->query;
		$done = false;
		while(!$done)
		{
			// chop a / level of the url
			$pos = strrpos($query, "/");
			if ($pos === false) // no more levels in url, abort
			{
		    	$done = true;
		    	break;
			}
			$query = substr($query, 0, $pos);
			// look if we have the reduced url
			if(array_key_exists($query, $this->urls))
			{
				$url = $this->urls[$query];
				if($url->requiresLogin && !$this->isLoggedIn())
				{
					header("Location: index.php?q=login");
					return;
				}			
				// it does pass the chopped of / levels as params to the callback
				// get parms
				$parms_str = substr($this->query, $pos, strlen($this->query)-$pos);
				if($parms_str[0] == "/")
					$parms_str = substr($parms_str,1,strlen($parms_str)-1);
				if($parms_str[strlen($parms_str)-1] == "/")
					$parms_str = substr($parms_str,0,strlen($parms_str)-1);
					
				//print "params: $parms_str". "<br>";
				// TODO we should evaluate the remaining parms_str with a statemachine and implement escaping
				// right now parms can't contain / escaped or otherwise
				$parms = explode("/", $parms_str);
				$cb_func = $this->urls[$query]->getCallback();
				$result = call_user_func_array($cb_func, $parms);
				if($result != NULL)				
					$this->content .= $result;
				
			}
			//print "pos: $pos new query: " . $query . "<br>";
			
		}
		
		

	}
	
	public function initModules()
	{
		foreach($this->modules as $m)
		{
			$func_name = $m . "_init";
			if(function_exists($func_name))
			{
				call_user_func($func_name);
			}
			$func_name = $m . "_schema";
			if(function_exists($func_name))
			{
				$schema = call_user_func($func_name);
				$this->schema = array_merge($this->schema, $schema);
			}			
		}			
	}
	
	public function loadModules()
	{
		$dir = $this->config['modules_dir'];
		if (is_dir($dir))
		{
			if ($dh = opendir($dir))
			{
				// iterate over file list
				while (($filename = readdir($dh)) !== false)
				{
					if(preg_match("/.php$/i", $filename))
					{
						require_once($dir . "/" . $filename);
						$parts = explode(".", $filename);
						$mod_name = $parts[0];
						$this->modules[] = $mod_name;
					}
				}
				closedir($dh);
			}
		}
		else
		{
			return false;
		}	
	}
	
	public function loadTemplate($name)
	{
		$t = new Template();
		$t->load($this->config['templates_dir'] . "/" . $name . ".html");
		$this->templates[$name] = $t;
	}
	
	public function shutdown()
	{
	}
	
	public function addUrl($url)
	{
		$this->urls[$url->getUrl()] = $url;
	}
		
	public function getConfig()
	{
		return $this->config;
	}
	
	public function writeRecord($table, &$record, $force_insert = false)
	{
		$schema = $this->schema[$table];
		$fields = $schema['fields'];
		$primary_key = $schema['primary key'][0];
		if(property_exists($record, $primary_key))
			$is_update = true;
		else
			$is_update = false;
			
		if($force_insert == true)
			$is_update = false;
		else
			$is_update = true;
				
		//print_r($schema);
		if(!$is_update)	// insert statement
		{
			$names = "";
			$placeholders = "";
			$values = array();
			foreach ($record as $key => $value)
			{
				if(array_key_exists($key, $fields))
				{
					$names .= $key . ",";
					$placeholders .= ":" . $key . ",";
					$values[":" . $key] = $value;
				}
			}
			// remove trailing colons
			$names = substr($names, 0, strlen($names)-1);
			$placeholders = substr($placeholders, 0, strlen($placeholders)-1);
			$sql = "INSERT INTO $table ($names) VALUES ($placeholders)";
			$sth = $this->dbh->prepare($sql);
			$sth->execute($values);
			if($sth === false)
			{
				echo "<pre>PDO error: " . print_r($this->dbh->errorInfo(), true) . "</pre>";
				return false;
			}
			
			// update object with assigned id
			if($fields[$primary_key]['type'] == "serial")
			{
				$record->$primary_key = $this->dbh->lastInsertId($table . "_" . $primary_key . "_seq");
			}
		}
		else // update statement
		{
			$values = array();
			$names = "";
			foreach ($record as $key => $value)
			{
				if(array_key_exists($key, $fields))
				{
					if($primary_key != $key)
					{
						$names .= $key . "=:" . $key . ",";
					}
					$values[":" . $key] = $value;
				}
			}
			$names = substr($names, 0, strlen($names)-1);
			$sql = "UPDATE $table SET $names WHERE $primary_key = :$primary_key";
			$sth = $this->dbh->prepare($sql);
			$sth->execute($values);
			if($sth === false)
			{
				echo "<pre>PDO error: " . print_r($this->dbh->errorInfo(), true) . "</pre>";
				return false;
			}			
			//echo $sql;
		}
		return true;
	}
	
	public function fetchRecord($table, $columns)
	{
		$schema = $this->schema[$table];
		$fields = $schema['fields'];
		$primary_key = $schema['primary key'][0];
		$values = array();
		$values_sql = "";
		foreach($columns as $col => $value)
		{
			$values_sql .= $col . "=:" . $col. " AND ";
			$values[":" . $col] = $value;
		}
		$values_sql = substr($values_sql, 0, strlen($values_sql)-5);
		$sql = "SELECT * FROM $table WHERE $values_sql LIMIT 1";
		//echo $sql;
		//exit;
		
		$sth = $this->dbh->prepare($sql);
		$sth->execute($values);
		if($sth === false)
		{
			//echo "<pre>PDO error: " . print_r($this->dbh->errorInfo(), true) . "</pre>";
			return false;
		}
		$record = $sth->fetch(PDO::FETCH_OBJ);
		if($record === false)
		{
			//echo "<pre>PDO error: " . print_r($this->dbh->errorInfo(), true) . "</pre>";
			return false;
		}
		return $record;
	}

	public function fetchRecords($table, $columns, $limit = -1)
	{
		$schema = $this->schema[$table];
		$fields = $schema['fields'];
		$primary_key = $schema['primary key'][0];
		$values = array();
		$values_sql = "";
		foreach($columns as $col => $value)
		{
			$values_sql .= $col . "=:" . $col. " AND ";
			$values[":" . $col] = $value;
		}
		$values_sql = substr($values_sql, 0, strlen($values_sql)-5);
		$sql = "SELECT * FROM $table WHERE $values_sql";
		if($limit > 0)
			$sql .= " LIMIT $limit";
		//echo $sql;
		//exit;
		
		$sth = $this->dbh->prepare($sql);
		$sth->execute($values);
		if($sth === false)
		{
			//echo "<pre>PDO error: " . print_r($this->dbh->errorInfo(), true) . "</pre>";
			return false;
		}
		$records = array();
		while($record = $sth->fetch(PDO::FETCH_OBJ))
		{
			$records[] = $record;
		}
		if(count($records) == 0)
			return false;
		
		return $records;
	}
	
	public function dbQuery($sql, $values = array())
	{		
		$sth = $this->dbh->prepare($sql);
		$sth->execute($values);
		if($sth === false)
		{
			//echo "<pre>PDO error: " . print_r($this->dbh->errorInfo(), true) . "</pre>";
			return false;
		}
		$records = array();
		while($record = $sth->fetch(PDO::FETCH_OBJ))
		{
			$records[] = $record;
		}
		if(count($records) == 0)
			return false;
		
		return $records;
	}
	
	public function beginTransaction()
	{
		$this->dbh->beginTransaction();
	}		

	public function commitTransaction()
	{
		$this->dbh->commit();
	}		

	public function rollbackTransaction()
	{
		$this->dbh->rollBack();
	}
	
	public function getTableList()
	{
		if($this->config['db_driver'] == "pgsql")	// if postgres
		{
			$sql = "select tablename from pg_tables where schemaname='public'";
			$sth = $this->dbh->query($sql);
			$this->dbTables = array();
			while($row = $sth->fetch(PDO::FETCH_OBJ))
			{  
				$this->dbTables[] = $row->tablename;
			}
		}
	}
	
	public function createTablePGSQL($table)
	{
		$schema = $this->schema[$table];
		$fields = $schema['fields'];
		//echo "<pre>";			
		//print_r($schema);

		$field_lines = "";
		$comment_lines = array();
		foreach($fields as $field_name => $field_opts)
		{
			if($field_opts['type'] == "serial")
			{
				$field_lines .= "  " . $field_name . " serial";
				if($field_opts['not null'] == true)
					$field_lines .= " NOT NULL";
										
				$field_lines .= ",\n";
			}
			if($field_opts['type'] == "integer" || $field_opts['type'] == "int")
			{
				$field_lines .= "  " . $field_name . " integer";
				if($field_opts['not null'] == true)
					$field_lines .= " NOT NULL";
				if(isset($field_opts['default']))
					$field_lines .= " DEFAULT " . $field_opts['default'];					
					
				$field_lines .= ",\n";
			}
			if($field_opts['type'] == "real" || $field_opts['type'] == "float")
			{
				$field_lines .= "  " . $field_name . " real";
				if($field_opts['not null'] == true)
					$field_lines .= " NOT NULL";
				if(isset($field_opts['default']))
					$field_lines .= " DEFAULT " . $field_opts['default'];					
					
				$field_lines .= ",\n";
			}
			if($field_opts['type'] == "double")
			{
				$field_lines .= "  " . $field_name . " double precision";
				if($field_opts['not null'] == true)
					$field_lines .= " NOT NULL";
				if(isset($field_opts['default']))
					$field_lines .= " DEFAULT " . $field_opts['default'];					
					
				$field_lines .= ",\n";
			}						
			if($field_opts['type'] == "boolean" || $field_opts['type'] == "bool")
			{
				$field_lines .= "  " . $field_name . " boolean";
				if($field_opts['not null'] == true)
					$field_lines .= " NOT NULL";
				if(isset($field_opts['default']))
					$field_lines .= " DEFAULT " . $field_opts['default'];					
				$field_lines .= ",\n";
			}
			if($field_opts['type'] == "text")
			{
				$field_lines .= "  " . $field_name . " text";
				if($field_opts['not null'] == true)
					$field_lines .= " NOT NULL";
				$field_lines .= ",\n";
			}						
			if($field_opts['type'] == "bigint" || $field_opts['type'] == "long")
			{
				$field_lines .= "  " . $field_name . " bigint";
				if($field_opts['not null'] == true)
					$field_lines .= " NOT NULL";
				if(isset($field_opts['default']))
					$field_lines .= " DEFAULT " . $field_opts['default'];					
				$field_lines .= ",\n";
			}
			if($field_opts['type'] == "numeric" || $field_opts['type'] == "decimal")
			{
				$field_lines .= "  " . $field_name . " numeric";
				if(isset($field_opts['size']))
					$field_lines .= "(" . $field_opts['size'] . ")";
				if($field_opts['not null'] == true)
					$field_lines .= " NOT NULL";
				if(isset($field_opts['default']))
					$field_lines .= " DEFAULT " . $field_opts['default'];	
				$field_lines .= ",\n";
			}
			if($field_opts['type'] == "varchar")
			{
				$field_lines .= "  " . $field_name . " varchar";
				if(isset($field_opts['length']))
					$field_lines .= "(" . $field_opts['length'] . ")";
				if($field_opts['not null'] == true)
					$field_lines .= " NOT NULL";
				if(isset($field_opts['default']))
					$field_lines .= " DEFAULT '" . $field_opts['default'] . "'";					
				$field_lines .= ",\n";
			}
			if(isset($field_opts['description']))
			{
				$comment_lines[] = "COMMENT ON COLUMN \"$table\".\"$field_name\" IS '" . $field_opts['description'] . "';\n";
			}
		}
		if(isset($schema['primary key'][0]))
		{
			$primary_key = $schema['primary key'][0];
			$field_lines .= "  PRIMARY KEY($primary_key)";
		}
		else
			$field_lines = substr($field_lines, 0, strlen($field_lines)-2);
		$sql = "CREATE TABLE $table (\n" . $field_lines . "\n);";
		$sth = $this->dbh->query($sql);
		if($sth === false)
		{
			echo "<pre>PDO error: " . print_r($this->dbh->errorInfo(), true) . "</pre>";
		}
		if(count($comment_lines) > 0)
		{
			foreach($comment_lines as $sql_stm)
			{
				$sth = $this->dbh->query($sql_stm);
				if($sth === false)
				{
					echo "<pre>PDO error: " . print_r($this->dbh->errorInfo(), true) . "</pre>";
					return;
				}
			}
		}
		
		//echo $sql;
	}

	public function addCss($css) {
		$this->css[] = $css;
	}

	public function addJs($js) {
		$this->js[] = $js;
	}
	
	public function createMissingTables()
	{
		$schema_tables = array_keys($this->schema);
		foreach($schema_tables as $table)
		{
			if(!in_array($table, $this->dbTables))
			{
				if($this->config['db_driver'] == "pgsql")
					$this->createTablePGSQL($table);
			}
		}
	}

	public function getAbsolutePath() {
		$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
		$path = $this->getDomain() . substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/")+1); //$_SERVER['REQUEST_URI'];
		//$path = parse_url($url , PHP_URL_PATH);
		return $path;
	}

	public function getDomain() {
		$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
		$domain = $protocol . "://" . $_SERVER['HTTP_HOST'];
		return $domain;
	}
	
	public function setFrontPageUrl($url)
	{
		$this->frontPageUrl = $url;
	}
	
	public function setActiveTemplate($template)
	{
		$this->activeTemplate = $template;
	}	
} 
