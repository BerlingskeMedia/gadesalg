<?php

/**
* - Hook init()
*/
function order_init()
{
	$url = new Url("order_new", "order_new_page");
	Core::get()->addUrl($url);

	$url = new Url("order_store", "order_store_page");
	Core::get()->addUrl($url);

	$url = new Url("order_saved_dialog", "order_saved_dialog_page");
	Core::get()->addUrl($url);

	$url = new Url("order_not_saved_dialog", "order_not_saved_dialog_page");
	Core::get()->addUrl($url);

	Core::get()->loadTemplate('app');
	Core::get()->loadTemplate('dialog');
}

function order_new_page()
{
	Core::get()->setActiveTemplate("app");

	$coutries = utils_countries();
	$country_select = '<select name="country" id="country">';
	foreach($coutries as $key => $val) {
		$selected = '';
		if($key == 'Denmark')
			$selected = 'selected="selected" ';
		$country_select .= '<option '.$selected.'value="'.$key.'">'.$val.'</option>';
	}
	$country_select .= '</select>';


	$publication_select = order_make_select('pub_id','pub_info');
	$sales_promo_select = order_make_select('sales_promo_id','sales_promo_info');
	$campaign_select = order_make_select('campaign_id','campaign_info');
	$service_type_select = order_make_select('service_type_id','service_type');
	$rate_code_select = order_make_select('rate_code_id','rate_code_info');
	$bill_freq_select = order_make_select('bill_freq_id','bill_freq');
	$payment_type_select = order_make_select('payment_type_id','payment_type');
	$pos_select =  order_make_select('pos_id','pos_info');

	$max_start_date = date('Y-m-d',strtotime('+3 months'));

	$output = '
		<form id="send_order" data-ajax="false" action="index.php?q=order_store" method="post">

			Alt markeret med * skal udfyldes.
			<h2>Kundedata:</h2>
		<!-- Name -->
			<input type="text" name="firstname" id="firstname" value="" placeholder="Fornavn *" />
			<input type="text" name="lastname" id="lastname" value="" placeholder="Efternavn *" />
		<!-- Address -->
			<input type="text" name="street" value="" placeholder="Vej *" />

			<div class="ui-grid-c">
				<div class="ui-block-a">
					<input type="text" name="house_number" value="" placeholder="Husnummer *" />
				</div>
				<div class="ui-block-d">
					<input type="text" name="litra" value="" placeholder="Litra/Bogstav" />
				</div>
				<div class="ui-block-b">
					<input type="text" name="floor" value="" placeholder="Floor" />
				</div>
				<div class="ui-block-c">
					<input type="text" name="side" value="" placeholder="Side/Dør" />
				</div>
			</div>

			<div class="ui-grid-a">
				<div class="ui-block-a">
					<input id="zip_input" type="text" name="zip" value="" placeholder="Postnummer *" />
				</div>
				<div class="ui-block-b">
					<input id="district_input" type="text" name="city" value="" placeholder="By *" />
				</div>
			</div>

			<div class="ui-grid-a">

				<div class="ui-block-a">
					'.$country_select.'
				</div>
				<div class="ui-block-b">
					<input type="text" name="postbox" value="" placeholder="Postboks" />
				</div>
			</div>

			<div class="ui-grid-a">
				<div class="ui-block-a">
					<input type="text" name="phone" value="" placeholder="Fastnetnummer" />
				</div>
				<div class="ui-block-b">
					<input type="text" name="mobile" value="" placeholder="Mobilnummer" />
				</div>
			</div>
			<input type="text" name="email" value="" placeholder="E-Mail" />

			<h2>Ordredata:</h2>
			<div class="ui-grid-a">
				<div class="ui-block-a">
					<label for="publication">Publikation</label>
					'.$publication_select.'
				</div>
				<!-- Removed
				<div class="ui-block-b">
					<label for="sales_promo">Sales promo</label>
					'.$sales_promo_select.'
				</div>
				-->
			</div>

			<!-- Removed
			<label for="campaign">Kampagne</label>
			'.$campaign_select.'
			-->
			<div class="ui-grid-a">
				<div class="ui-block-a">
					<label for="service_type">Service type</label>
					'.$service_type_select.'
				</div>
				<div class="ui-block-b">
					<label for="rate_code">Priskategori</label>
					'.$rate_code_select.'
				</div>
			</div>

			<div class="ui-grid-a">
				<div class="ui-block-a">
					<label for="bill_freq">Billing frequency</label>
					'.$bill_freq_select.'
				</div>
				<div class="ui-block-b">
					<label for="payment_type">Betalingstype *</label>
					'.$payment_type_select.'
				</div>
			</div>

			<input type="text" name="price" value="" placeholder="Pris *" />

			<div class="ui-grid-a">
				<div class="ui-block-a">
					<label for="sold_date">Solgt dato</label>
					<input type="text" name="sold_date" id="sold_date" value="" placeholder="" />
				</div>
				<div class="ui-block-b">
					<label for="start_date">Start dato</label>
					<input type="text" name="start_date" id="start_date" value="" placeholder="" max="'.$max_start_date.'" />
				</div>
			</div>

			<!--
			<div>
				<label for="pos">Salgsted</label>
				'.$pos_select.'
			</div>
			-->

			<h2>PBS:</h2>
			<input type="text" name="ssn" value="" placeholder="Personnummer" />
			<div class="ui-grid-a">
				<div class="ui-block-a">
					<input type="text" name="reg" value="" placeholder="Reg. Nr." />
				</div>
				<div class="ui-block-b">
					<input type="text" name="knr" value="" placeholder="Kontonummer" />
				</div>
			</div>

			<h2>Extra:</h2>
			<textarea name="extra" value=""></textarea>

			<button id="submit_form_button" type="submit" data-theme="a">Gem</button>
		</form>
	';

	return $output;
}

function order_store_page()
{
	$schema = order_schema();

	$missing = '';

	$o = new stdClass();
	foreach($schema['orders']['fields'] as $field => $values) {
		if(isset($_REQUEST[$field])) {
			$type = $values['type'];
			if(($type == 'int' || $type == 'bigint') && $_REQUEST[$field] == '')
				$_REQUEST[$field] = 0;
			$o->$field = $_REQUEST[$field];
		}
		else
			$missing .= $field.',';
	}

	$o->price = str_replace(',','.',$o->price);

	$o->sold_date_ts = utils_date_dmy_to_unix($_REQUEST['sold_date']);
	$o->start_date_ts = utils_date_dmy_to_unix($_REQUEST['start_date']);

	$user = Core::get()->getLoggedInUser();
	$o->salesman_id = $user->id;

	$o->created_ts = time();

	/*
	echo "<pre>";
	print_r($o);
	exit;
	*/
	if(Core::get()->writeRecord("orders", $o, true)) {
		echo ':)';
		return;
	}
	echo ':(';
	return;
/*
$_REQUEST[''];
	firstname
	lastname
	street
	house_number
	floor
	side
	litra
	zip
	city
	country
	postbox
	phone
	mobile
	email
	publication
	sales_promo
	campaign
	service_type
	rate_code
	bill_freq
	order_type
	price
	sold_date
	start_date
	pos
	salesman
	ssn
	reg
	knr
	extra
*/


	/*
	$r = true;

	return $r;
	*/
}

function order_saved_dialog_page()
{
	Core::get()->setActiveTemplate("dialog");
	$output = '
		Orden er blevet gemt.
		<a href="index.php?q=menu" data-role="button" data-theme="b">Det lyder godt</a>
		</div>
	';
	return $output;
	/*
	$r = true;

	return $r;
	*/
}

function order_not_saved_dialog_page()
{
	Core::get()->setActiveTemplate("dialog");
	$output = '
		Orden er desværre ikke blevet gemt.
		<a href="index.php?q=menu" data-role="button" data-theme="b">Øv, jeg skynder mig at meddele det til min chef</a>
		</div>
	';
	return $output;
	/*
	$r = true;

	return $r;
	*/
}

function order_db_get_all($table_name)
{
	$sql = "SELECT * FROM $table_name";
	return Core::get()->dbQuery($sql);
}

function order_make_select($select_name,$table_name) {
	$sql = "SELECT * FROM $table_name WHERE active=1 ORDER BY weight ASC";
	$entries = Core::get()->dbQuery($sql);

	$html = '';
	$html .= '<select id="'.$select_name.'" name="'.$select_name.'">';
	foreach($entries as $entry) {
		$html .= '<option value="'.$entry->id.'">'.$entry->description.'</option>';
	}
	$html .= '</select>';
	return $html;
}

function order_schema() {
	$schema['orders'] = array(
		'fields' => array(
			// Ordre felter
			'id' => array(
				'description' => 'Auto ID',
				'type' => 'serial',
				'not null' => TRUE,
			),
			'bill_freq_id' => array(
				'type' => 'int',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'service_type_id' => array(
				'type' => 'int',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'pub_id' => array(
				'type' => 'int',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'campaign_id' => array(
				'type' => 'int',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'rate_code_id' => array(
				'type' => 'int',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'sales_promo_id' => array(
				'type' => 'int',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'payment_type_id' => array(
				'type' => 'int',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'price' => array(
				'type' => 'numeric',
				'size' => 'normal',
				'not null' => TRUE,
				'default' => 0,
				'size' => '10,2',
			),
			'extra' => array(
				'type' => 'text',
				'default' => '',
			),
			'salesman_id' => array(
				'type' => 'int',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'sold_date_ts' => array(
				'type' => 'bigint',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'start_date_ts' => array(
				'type' => 'bigint',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'pos_id' => array(
				'type' => 'int',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			// Adresse felter
			'firstname' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'lastname' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'street' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'house_number' => array(
				'type' => 'int',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),
			'litra' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'floor' => array(
				'type' => 'varchar',
				'length' => 30,
				'not null' => TRUE,
				'default' => '',
			),
			'side' => array(
				'type' => 'varchar',
				'length' => 30,
				'not null' => TRUE,
				'default' => '',
			),
			'zip' => array(
				'type' => 'varchar',
				'length' => 50,
				'not null' => TRUE,
				'default' => '',
			),
			'city' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'country' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'phone' => array(
				'type' => 'varchar',
				'length' => 50,
				'not null' => TRUE,
				'default' => '',
			),
			'mobile' => array(
				'type' => 'varchar',
				'length' => 50,
				'not null' => TRUE,
				'default' => '',
			),
			'email' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			'postbox' => array(
				'type' => 'varchar',
				'length' => 255,
				'not null' => TRUE,
				'default' => '',
			),
			// PBS felter
			'ssn' => array(
				'type' => 'varchar',
				'length' => 30,
				'not null' => TRUE,
				'default' => '',
			),
			'reg' => array(
				'type' => 'varchar',
				'length' => 10,
				'not null' => TRUE,
				'default' => '',
			),
			'knr' => array(
				'type' => 'varchar',
				'length' => 10,
				'not null' => TRUE,
				'default' => '',
			),
			// Ordre
			'created_ts' => array(
				'type' => 'bigint',
				'unsigned' => TRUE,
				'not null' => TRUE,
				'default' => 0,
			),

		),
		'primary key' => array('id'),
	);
	return $schema;
}
