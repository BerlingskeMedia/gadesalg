<?php

function mingapi_init()
{
	$url = new Url("mingapi", "mingapi_request", false);
	Core::get()->addUrl($url);
	$url = new Url("mingapi_pos", "mingapi_position", false);
	Core::get()->addUrl($url);
	$url = new Url("mingapi_lookup_zip", "mingapi_lookup_zip", false);
	Core::get()->addUrl($url);	
}

function mingapi_schema()
{
	$schema['api_users'] = array(
	  'description' => 'TODO: please describe this table!',
	  'fields' => array(
		'id' => array(
		  'description' => 'TODO: please describe this field!',
		  'type' => 'serial',
		  'not null' => TRUE,
		),
		'username' => array(
		  'description' => 'TODO: please describe this field!',
		  'type' => 'varchar',
		  'length' => '80',
		  'not null' => TRUE,
		),
		'api_key' => array(
		  'description' => 'TODO: please describe this field!',
		  'type' => 'varchar',
		  'length' => '255',
		  'not null' => TRUE,
		),		
	  ),
	  'primary key' => array('id'),
	);
	
	$schema['api_sessions'] = array(
	  'description' => 'TODO: please describe this table!',
	  'fields' => array(
		'session_id' => array(
		  'description' => 'TODO: please describe this field!',
		  'type' => 'varchar',
		  'length' => '80',
		  'not null' => TRUE,
		),
		'user_id' => array(
		  'description' => 'TODO: please describe this field!',
		  'type' => 'int',
		  'not null' => TRUE,
		),
		'created' => array(
		  'description' => 'TODO: please describe this field!',
		  'type' => 'int',
		  'not null' => TRUE,
		),
		'last_activity' => array(
		  'description' => 'TODO: please describe this field!',
		  'type' => 'int',
		  'not null' => TRUE,
		),				
	  ),
	  'primary key' => array('session_id'),
	);
	
	$schema['bill_freq'] = array(
		'fields' => array(
			'id' => array(
				'type' => 'integer',
				'unsigned' => TRUE,
				'not null' => TRUE,
			),
			'description' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'weight' => array(
				'type' => 'int',
				'unsigned' => FALSE,
				'not null' => TRUE,
				'default' => 0,
			),
			'active' => array(
				'type' => 'int',
				'length' => 1,
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 1,
			),
			'freq' => array(
				'type' => 'varchar',
				'length' => 20,
				'not null' => TRUE,
				'default' => '',
			),
		),
		'primary key' => array('id'),
	);

	$schema['campaign_info'] = array(
		'fields' => array(
			'id' => array(
				'type' => 'integer',
				'unsigned' => TRUE,
				'not null' => TRUE,
			),
			'description' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'weight' => array(
				'type' => 'int',
				'unsigned' => FALSE,
				'not null' => TRUE,
				'default' => 0,
			),
			'active' => array(
				'type' => 'int',
				'length' => 1,
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 1,
			),
			'kode' => array(
				'type' => 'varchar',
				'length' => 100,
				'not null' => TRUE,
				'default' => '',
			),
			
		),
		'primary key' => array('id'),
	);
	
	$schema['payment_type'] = array(
		'fields' => array(
			'id' => array(
				'type' => 'integer',
				'unsigned' => TRUE,
				'not null' => TRUE,
			),
			'description' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'weight' => array(
				'type' => 'int',
				'unsigned' => FALSE,
				'not null' => TRUE,
				'default' => 0,
			),
			'active' => array(
				'type' => 'int',
				'length' => 1,
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 1,
			),
			'navn' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			
		),
		'primary key' => array('id'),
	);
	
	$schema['pos_info'] = array(
		'fields' => array(
			'id' => array(
				'type' => 'integer',
				'unsigned' => TRUE,
				'not null' => TRUE,
			),
			'description' => array(
				'type' => 'varchar',
				'length' => 30,
				'not null' => TRUE,
				'default' => '',
			),
			'weight' => array(
				'type' => 'int',
				'unsigned' => FALSE,
				'not null' => TRUE,
				'default' => 0,
			),
			'active' => array(
				'type' => 'int',
				'length' => 1,
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 1,
			),
			'bladkompagni' => array(
				'type' => 'varchar',
				'length' => 100,
				'not null' => TRUE,
				'default' => '',
			),			
			'longitude' => array(
				'type' => 'double',
				'not null' => TRUE,
				'default' => 0,
			),
			'latitude' => array(
				'type' => 'double',
				'not null' => TRUE,
				'default' => 0,
			),
			'radius' => array(
				'type' => 'int',
				'unsigned' => FALSE,
				'not null' => TRUE,
				'default' => 100,
			),			                  
		),
		'primary key' => array('id'),
	);
	
	$schema['pub_info'] = array(
		'fields' => array(
			'id' => array(
				'type' => 'integer',
				'unsigned' => TRUE,
				'not null' => TRUE,
			),
			'description' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'weight' => array(
				'type' => 'int',
				'unsigned' => FALSE,
				'not null' => TRUE,
				'default' => 0,
			),
			'active' => array(
				'type' => 'int',
				'length' => 1,
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 1,
			),
			'pub_kode' => array(
				'type' => 'varchar',
				'length' => 30,
				'not null' => TRUE,
				'default' => '',
			),
		),
		'primary key' => array('id'),
	);
	
	$schema['rate_code_info'] = array(
		'fields' => array(
			'id' => array(
				'type' => 'integer',
				'unsigned' => TRUE,
				'not null' => TRUE,
			),
			'description' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'weight' => array(
				'type' => 'int',
				'unsigned' => FALSE,
				'not null' => TRUE,
				'default' => 0,
			),
			'rate_kode' => array(
				'type' => 'varchar',
				'length' => 20,
				'not null' => TRUE,
				'default' => '',
			),
			'active' => array(
				'type' => 'int',
				'length' => 1,
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 1,
			),
			
		),
		'primary key' => array('id'),
	);
	
	$schema['sales_promo_info'] = array(
		'fields' => array(
			'id' => array(
				'type' => 'integer',
				'unsigned' => TRUE,
				'not null' => TRUE,
			),
			'sp_kode' => array(
				'type' => 'varchar',
				'length' => 30,
				'not null' => TRUE,
				'default' => '',
			),         
			'description' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'weight' => array(
				'type' => 'int',
				'unsigned' => FALSE,
				'not null' => TRUE,
				'default' => 0,
			),
			'active' => array(
				'type' => 'int',
				'length' => 1,
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 1,
			),
		),
		'primary key' => array('id'),
	); 			
		
		
	$schema['service_type'] = array(
		'fields' => array(
			'id' => array(
				'type' => 'integer',
				'unsigned' => TRUE,
				'not null' => TRUE,
			),
			'description' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'weight' => array(
				'type' => 'int',
				'unsigned' => FALSE,
				'not null' => TRUE,
				'default' => 0,
			),
			'active' => array(
				'type' => 'int',
				'length' => 1,
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 1,
			),
			'levdage' => array(
				'type' => 'varchar',
				'length' => 7,
				'not null' => TRUE,
				'default' => '',
			),
			
		),
		'primary key' => array('id'),
	);
	
	$schema['zipcodes'] = array(
		'fields' => array(
			'id' => array(
				'type' => 'varchar',
				'length' => 20,
				'not null' => TRUE,
			),			
			'district' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
		),
		'primary key' => array('id'),
	);	
			
	return $schema;
}



class jsonRPCServer {
	/**
	 * This function handle a request binding it to a given object
	 *
	 * @param object $object
	 * @return boolean
	 */
	public static function handle($object) {
		
		// checks if a JSON-RCP request has been received
		if (
			$_SERVER['REQUEST_METHOD'] != 'POST' || 
			empty($_SERVER['CONTENT_TYPE']) ||
			$_SERVER['CONTENT_TYPE'] != 'application/json'
			) {
			// This is not a JSON-RPC request
			return false;
		}
				
		// reads the input data
		$request = json_decode(file_get_contents('php://input'),true);
		
		$bypass = false;
		if(empty($request['auth']))
		{
			if($request['method'] != "login")
			{
				$bypass = true;
				$response = array (
								'id' => $request['id'],
								'result' => NULL,
								'error' => "Access denied"
								);
			}
		}
		else	// auth session
		{
			$auth_token = $request['auth'];
			if(!mingapi_auth_session($auth_token))
			{
				$bypass = true;
				$response = array (
								'id' => $request['id'],
								'result' => NULL,
								'error' => "Invalid auth token. Access denied"
								);
			}			
		}

		if(!$bypass)
		{
			// executes the task on local object
			try {
				if ($result = @call_user_func_array(array($object,$request['method']),$request['params'])) {
					$response = array (
										'id' => $request['id'],
										'result' => $result,
										'error' => NULL
										);
				} else {
					$response = array (
										'id' => $request['id'],
										'result' => NULL,
										'error' => 'unknown method or incorrect parameters'
										);
				}
			} catch (Exception $e) {
				$response = array (
									'id' => $request['id'],
									'result' => NULL,
									'error' => $e->getMessage()
									);
			}
		}		
		// output the response
		if (!empty($request['id'])) { // notifications don't want response
			header('content-type: text/javascript');
			echo json_encode($response);
		}
		
		// finish
		return true;
	}
}


function mingapi_auth_session($auth_token)
{
	$ses = Core::get()->fetchRecord("api_sessions", array('session_id' => $auth_token));
	if($ses === false)
		return false;
	else
		return $ses->user_id;
}

function mingapi_get_user($username, $apikey)
{
	//SELECT `id`, `username`, `api_key` FROM api_users WHERE `username` = ? AND  `api_key` = ? LIMIT 1
	$rec = Core::get()->fetchRecord("api_users", array('username' => $username, 'api_key' => $apikey));
	if($rec === false)
		return false;
	$a = array('id' => $rec->id, 'username' => $rec->user, 'api_key' => $rec->api_key);
	return $a;
}

function mingapi_insert_session($session_id, $user_id)
{
	$ts = time();
	$ses = new stdClass();
	$ses->session_id = $session_id;
	$ses->user_id = $user_id;
	$ses->created = $ts;
	$ses->last_activity = $ts;
	return Core::get()->writeRecord("api_sessions", $ses, true);
}

class MingaApi
{        
    public function test()
    {
    	return 42;
    }
            
    public function login($username, $password)
	{
		$user = mingapi_get_user($username, $password);
		if($user !== false)
		{
			$auth_token = sha1(uniqid("WEA",true));
			mingapi_insert_session($auth_token, $user['id']);
			return array('auth' => $auth_token);
		}
		else
		{
			throw new Exception("Wrong username or password");
		}
    }
    
    public function pushUsers($items)
    {
    	$errors = "";
    	Core::get()->beginTransaction();
    	Core::get()->dbQuery("TRUNCATE TABLE users");
    	foreach($items as $item)
    	{
    		$user = new stdClass();
    		$user->id = $item['id'];
			$user->active = $item['active'];
			$user->navn = $item['navn'];
			$user->username = $item['username'];
			$user->password = $item['password'];
			Core::get()->writeRecord("users", $user, true);
			//$errors .= print_r(Core::get()->dbh->errorInfo(), true);
    	}
    	Core::get()->commitTransaction();
    	//$errors .= print_r(Core::get()->dbh->errorInfo(), true);
    	//return $errors;
    	return true;
    }       
    
    public function pushBillFreq($items)
    {
    	$errors = "";
    	Core::get()->beginTransaction();
    	Core::get()->dbQuery("TRUNCATE TABLE bill_freq");
    	foreach($items as $item)
    	{

			Core::get()->writeRecord("bill_freq", $item, true);
			//$errors .= print_r(Core::get()->dbh->errorInfo(), true);
    	}
    	Core::get()->commitTransaction();
    	//$errors .= print_r(Core::get()->dbh->errorInfo(), true);
    	//return $errors;
    	return true;
    }
    
    public function pushCampaignInfo($items)
    {
    	$errors = "";
    	Core::get()->beginTransaction();
    	Core::get()->dbQuery("TRUNCATE TABLE campaign_info");
    	foreach($items as $item)
    	{

			Core::get()->writeRecord("campaign_info", $item, true);
			//$errors .= print_r(Core::get()->dbh->errorInfo(), true);
    	}
    	Core::get()->commitTransaction();
    	//$errors .= print_r(Core::get()->dbh->errorInfo(), true);
    	//return $errors;
    	return true;
    }
    
	public function pushPaymentType($items)
    {
    	$errors = "";
    	Core::get()->beginTransaction();
    	Core::get()->dbQuery("TRUNCATE TABLE payment_type");
    	foreach($items as $item)
    	{

			Core::get()->writeRecord("payment_type", $item, true);
    	}
    	Core::get()->commitTransaction();
    	return true;
    }    
    
	public function pushPosInfo($items)
    {
    	Core::get()->beginTransaction();
    	Core::get()->dbQuery("TRUNCATE TABLE pos_info");
    	foreach($items as $item)
    	{
			Core::get()->writeRecord("pos_info", $item, true);
    	}
    	Core::get()->commitTransaction();
    	return true;
    }
    
	public function pushPubInfo($items)
    {
    	Core::get()->beginTransaction();
    	Core::get()->dbQuery("TRUNCATE TABLE pub_info");
    	foreach($items as $item)
    	{
			Core::get()->writeRecord("pub_info", $item, true);
    	}
    	Core::get()->commitTransaction();
    	return true;
    }
    
    public function pushRateCodeInfo($items)
    {
    	Core::get()->beginTransaction();
    	Core::get()->dbQuery("TRUNCATE TABLE rate_code_info");
    	foreach($items as $item)
    	{
			Core::get()->writeRecord("rate_code_info", $item, true);
    	}
    	Core::get()->commitTransaction();
    	return true;
    }
    
    public function pushSalesPromoInfo($items)
    {
    	Core::get()->beginTransaction();
    	Core::get()->dbQuery("TRUNCATE TABLE sales_promo_info");
    	foreach($items as $item)
    	{
			Core::get()->writeRecord("sales_promo_info", $item, true);
    	}
    	Core::get()->commitTransaction();
    	return true;
    }
    
    public function pushServiceType($items)
    {
    	Core::get()->beginTransaction();
    	Core::get()->dbQuery("TRUNCATE TABLE service_type");
    	foreach($items as $item)
    	{
			Core::get()->writeRecord("service_type", $item, true);
    	}
    	Core::get()->commitTransaction();
    	return true;
    }
    
    public function pullOrders()
    {
    	$orders = Core::get()->dbQuery("SELECT * FROM orders");
    	if($orders === false)
    		return -1;
    	return $orders;
    }
    
    public function deleteOrders()
    {
    	Core::get()->beginTransaction();
    	Core::get()->dbQuery("TRUNCATE TABLE orders");
    	Core::get()->commitTransaction();
    	return true;    
    }    
}

function mingapi_request()
{
	$ts = time()-3600;
	$sql = "DELETE FROM api_sessions WHERE last_activity < $ts";
	Core::get()->dbQuery($sql);

	$MingaApi = new MingaApi();
	jsonRPCServer::handle($MingaApi);

	return;
}

// in meters
function greatCircleDistance($lat1, $lon1, $lat2, $lon2)
{
	$pi = 3.1415926; 
	$rad = doubleval($pi/180.0); 

	$lon1 = doubleval($lon1)*$rad; $lat1 = doubleval($lat1)*$rad; 
	$lon2 = doubleval($lon2)*$rad; $lat2 = doubleval($lat2)*$rad; 

	$theta = $lon2 - $lon1;
	$dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta));
	if ($dist < 0)
	{
		$dist += $pi;
	} 
	$dist = $dist * 6371.2; 
	$miles = doubleval($dist * 0.621); 
	$kms = doubleval(1.60934 * $miles);
	$meters = doubleval(1000 * $kms);
	return $meters;
}

function mingapi_position()
{
	session_write_close();	// NB: Luk session så andre requests fra samme client/session kan køre samtidig
 	
	$lat = $_REQUEST['lat'];
	$long = $_REQUEST['long'];
	
	$recs = Core::get()->dbQuery("SELECT * FROM pos_info");
	$places = array();
	foreach($recs as $rec)
	{
		if($rec->latitude == 0 || $rec->longitude == 0)
			continue;
		$dist = greatCircleDistance($lat, $long, $rec->latitude, $rec->longitude);
		if($dist <= doubleval($rec->radius))
		{
			$dist = doubleval(sprintf( "%.2f",$dist)); 
			$place = array('id' => $rec->id, 'place' => $rec->description, 'distance' => $dist, 'latitude' => sprintf( "%.6f",$lat), 'longitude' => sprintf( "%.6f",$long));
			$places[] = $place;
		}
	}
	if(count($places) == 0)
	{
		// unknown place
		$place = array('id' => 0, 'place' => 'Ukendt', 'distance' => 0, 'latitude' => sprintf( "%.6f",$lat), 'longitude' => sprintf( "%.6f",$long));
		echo json_encode($place);
		return;
	}		
	$closest = $places[0];
	foreach($places as $place)
	{
		if($place['distance'] < $closest['distance'])
			$closest = $place;
	}	
	echo json_encode($closest);
	return;
}

function mingapi_lookup_zip()
{
	session_write_close();
	$zip = $_REQUEST['zip'];
	$retval = array('id' => $zip, 'district' => "");
	$rec = Core::get()->fetchRecord("zipcodes", array('id' => $zip));
	if($rec !== false)
	{
		$retval['district'] = $rec->district;
	}
	echo json_encode($retval);
	return;
}

