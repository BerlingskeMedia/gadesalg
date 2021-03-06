<?php

/**
* - Hook init()
*/
function utils_init()
{
	date_default_timezone_set("Europe/Copenhagen");
}

function utils_date_dmy_to_unix($date) {
	$exp = explode('-',$date);
	$t = 0;
	if(is_numeric($exp[0]) && is_numeric($exp[1]) && is_numeric($exp[2])) {
		$t = mktime(0,0,0,ltrim($exp[1],'0'),ltrim($exp[0],'0'),$exp[2]);
	}
	return $t;
}

function utils_countries() {
	$c = array();
	$c["United States"] = 'United States';
	$c["Canada"] = 'Canada';
	$c["United Kingdom"] = 'United Kingdom';
	$c["Ireland"] = 'Ireland';
	$c["Australia"] = 'Australia';
	$c["New Zealand"] = 'New Zealand';
	$c["Afghanistan"] = 'Afghanistan';
	$c["Albania"] = 'Albania';
	$c["Algeria"] = 'Algeria';
	$c["American Samoa"] = 'American Samoa';
	$c["Andorra"] = 'Andorra';
	$c["Angola"] = 'Angola';
	$c["Anguilla"] = 'Anguilla';
	$c["Antarctica"] = 'Antarctica';
	$c["Antigua and Barbuda"] = 'Antigua and Barbuda';
	$c["Argentina"] = 'Argentina';
	$c["Armenia"] = 'Armenia';
	$c["Aruba"] = 'Aruba';
	$c["Australia"] = 'Australia';
	$c["Austria"] = 'Austria';
	$c["Azerbaijan"] = 'Azerbaijan';
	$c["Bahamas"] = 'Bahamas';
	$c["Bahrain"] = 'Bahrain';
	$c["Bangladesh"] = 'Bangladesh';
	$c["Barbados"] = 'Barbados';
	$c["Belarus"] = 'Belarus';
	$c["Belgium"] = 'Belgium';
	$c["Belize"] = 'Belize';
	$c["Benin"] = 'Benin';
	$c["Bermuda"] = 'Bermuda';
	$c["Bhutan"] = 'Bhutan';
	$c["Bolivia"] = 'Bolivia';
	$c["Bosnia and Herzegovina"] = 'Bosnia and Herzegovina';
	$c["Botswana"] = 'Botswana';
	$c["Bouvet Island"] = 'Bouvet Island';
	$c["Brazil"] = 'Brazil';
	$c["British Indian Ocean Territory"] = 'British Indian Ocean Territory';
	$c["Brunei Darussalam"] = 'Brunei Darussalam';
	$c["Bulgaria"] = 'Bulgaria';
	$c["Burkina Faso"] = 'Burkina Faso';
	$c["Burundi"] = 'Burundi';
	$c["Cambodia"] = 'Cambodia';
	$c["Cameroon"] = 'Cameroon';
	$c["Canada"] = 'Canada';
	$c["Cape Verde"] = 'Cape Verde';
	$c["Cayman Islands"] = 'Cayman Islands';
	$c["Central African Republic"] = 'Central African Republic';
	$c["Chad"] = 'Chad';
	$c["Chile"] = 'Chile';
	$c["China"] = 'China';
	$c["Christmas Island"] = 'Christmas Island';
	$c["Cocos (Keeling) Islands"] = 'Cocos (Keeling) Islands';
	$c["Colombia"] = 'Colombia';
	$c["Comoros"] = 'Comoros';
	$c["Congo"] = 'Congo';
	$c["Congo, The Democratic Republic of The"] = 'Congo, The Democratic Republic of The';
	$c["Cook Islands"] = 'Cook Islands';
	$c["Costa Rica"] = 'Costa Rica';
	$c["Cote D\'ivoire"] = 'Cote D\'ivoire';
	$c["Croatia"] = 'Croatia';
	$c["Cuba"] = 'Cuba';
	$c["Cyprus"] = 'Cyprus';
	$c["Czech Republic"] = 'Czech Republic';
	$c["Denmark"] = 'Denmark';
	$c["Djibouti"] = 'Djibouti';
	$c["Dominica"] = 'Dominica';
	$c["Dominican Republic"] = 'Dominican Republic';
	$c["Ecuador"] = 'Ecuador';
	$c["Egypt"] = 'Egypt';
	$c["El Salvador"] = 'El Salvador';
	$c["Equatorial Guinea"] = 'Equatorial Guinea';
	$c["Eritrea"] = 'Eritrea';
	$c["Estonia"] = 'Estonia';
	$c["Ethiopia"] = 'Ethiopia';
	$c["Falkland Islands (Malvinas)"] = 'Falkland Islands (Malvinas)';
	$c["Faroe Islands"] = 'Faroe Islands';
	$c["Fiji"] = 'Fiji';
	$c["Finland"] = 'Finland';
	$c["France"] = 'France';
	$c["French Guiana"] = 'French Guiana';
	$c["French Polynesia"] = 'French Polynesia';
	$c["French Southern Territories"] = 'French Southern Territories';
	$c["Gabon"] = 'Gabon';
	$c["Gambia"] = 'Gambia';
	$c["Georgia"] = 'Georgia';
	$c["Germany"] = 'Germany';
	$c["Ghana"] = 'Ghana';
	$c["Gibraltar"] = 'Gibraltar';
	$c["Greece"] = 'Greece';
	$c["Greenland"] = 'Greenland';
	$c["Grenada"] = 'Grenada';
	$c["Guadeloupe"] = 'Guadeloupe';
	$c["Guam"] = 'Guam';
	$c["Guatemala"] = 'Guatemala';
	$c["Guinea"] = 'Guinea';
	$c["Guinea-bissau"] = 'Guinea-bissau';
	$c["Guyana"] = 'Guyana';
	$c["Haiti"] = 'Haiti';
	$c["Heard Island and Mcdonald Islands"] = 'Heard Island and Mcdonald Islands';
	$c["Holy See (Vatican City State)"] = 'Holy See (Vatican City State)';
	$c["Honduras"] = 'Honduras';
	$c["Hong Kong"] = 'Hong Kong';
	$c["Hungary"] = 'Hungary';
	$c["Iceland"] = 'Iceland';
	$c["India"] = 'India';
	$c["Indonesia"] = 'Indonesia';
	$c["Iran, Islamic Republic of"] = 'Iran, Islamic Republic of';
	$c["Iraq"] = 'Iraq';
	$c["Ireland"] = 'Ireland';
	$c["Israel"] = 'Israel';
	$c["Italy"] = 'Italy';
	$c["Jamaica"] = 'Jamaica';
	$c["Japan"] = 'Japan';
	$c["Jordan"] = 'Jordan';
	$c["Kazakhstan"] = 'Kazakhstan';
	$c["Kenya"] = 'Kenya';
	$c["Kiribati"] = 'Kiribati';
	$c["Korea, Democratic People\'s Republic of"] = 'Korea, Democratic People\'s Republic of';
	$c["Korea, Republic of"] = 'Korea, Republic of';
	$c["Kuwait"] = 'Kuwait';
	$c["Kyrgyzstan"] = 'Kyrgyzstan';
	$c["Lao People\'s Democratic Republic"] = 'Lao People\'s Democratic Republic';
	$c["Latvia"] = 'Latvia';
	$c["Lebanon"] = 'Lebanon';
	$c["Lesotho"] = 'Lesotho';
	$c["Liberia"] = 'Liberia';
	$c["Libyan Arab Jamahiriya"] = 'Libyan Arab Jamahiriya';
	$c["Liechtenstein"] = 'Liechtenstein';
	$c["Lithuania"] = 'Lithuania';
	$c["Luxembourg"] = 'Luxembourg';
	$c["Macao"] = 'Macao';
	$c["Macedonia, The Former Yugoslav Republic of"] = 'Macedonia, The Former Yugoslav Republic of';
	$c["Madagascar"] = 'Madagascar';
	$c["Malawi"] = 'Malawi';
	$c["Malaysia"] = 'Malaysia';
	$c["Maldives"] = 'Maldives';
	$c["Mali"] = 'Mali';
	$c["Malta"] = 'Malta';
	$c["Marshall Islands"] = 'Marshall Islands';
	$c["Martinique"] = 'Martinique';
	$c["Mauritania"] = 'Mauritania';
	$c["Mauritius"] = 'Mauritius';
	$c["Mayotte"] = 'Mayotte';
	$c["Mexico"] = 'Mexico';
	$c["Micronesia, Federated States of"] = 'Micronesia, Federated States of';
	$c["Moldova, Republic of"] = 'Moldova, Republic of';
	$c["Monaco"] = 'Monaco';
	$c["Mongolia"] = 'Mongolia';
	$c["Montserrat"] = 'Montserrat';
	$c["Morocco"] = 'Morocco';
	$c["Mozambique"] = 'Mozambique';
	$c["Myanmar"] = 'Myanmar';
	$c["Namibia"] = 'Namibia';
	$c["Nauru"] = 'Nauru';
	$c["Nepal"] = 'Nepal';
	$c["Netherlands"] = 'Netherlands';
	$c["Netherlands Antilles"] = 'Netherlands Antilles';
	$c["New Caledonia"] = 'New Caledonia';
	$c["New Zealand"] = 'New Zealand';
	$c["Nicaragua"] = 'Nicaragua';
	$c["Niger"] = 'Niger';
	$c["Nigeria"] = 'Nigeria';
	$c["Niue"] = 'Niue';
	$c["Norfolk Island"] = 'Norfolk Island';
	$c["Northern Mariana Islands"] = 'Northern Mariana Islands';
	$c["Norway"] = 'Norway';
	$c["Oman"] = 'Oman';
	$c["Pakistan"] = 'Pakistan';
	$c["Palau"] = 'Palau';
	$c["Palestinian Territory, Occupied"] = 'Palestinian Territory, Occupied';
	$c["Panama"] = 'Panama';
	$c["Papua New Guinea"] = 'Papua New Guinea';
	$c["Paraguay"] = 'Paraguay';
	$c["Peru"] = 'Peru';
	$c["Philippines"] = 'Philippines';
	$c["Pitcairn"] = 'Pitcairn';
	$c["Poland"] = 'Poland';
	$c["Portugal"] = 'Portugal';
	$c["Puerto Rico"] = 'Puerto Rico';
	$c["Qatar"] = 'Qatar';
	$c["Reunion"] = 'Reunion';
	$c["Romania"] = 'Romania';
	$c["Russian Federation"] = 'Russian Federation';
	$c["Rwanda"] = 'Rwanda';
	$c["Saint Helena"] = 'Saint Helena';
	$c["Saint Kitts and Nevis"] = 'Saint Kitts and Nevis';
	$c["Saint Lucia"] = 'Saint Lucia';
	$c["Saint Pierre and Miquelon"] = 'Saint Pierre and Miquelon';
	$c["Saint Vincent and The Grenadines"] = 'Saint Vincent and The Grenadines';
	$c["Samoa"] = 'Samoa';
	$c["San Marino"] = 'San Marino';
	$c["Sao Tome and Principe"] = 'Sao Tome and Principe';
	$c["Saudi Arabia"] = 'Saudi Arabia';
	$c["Senegal"] = 'Senegal';
	$c["Serbia and Montenegro"] = 'Serbia and Montenegro';
	$c["Seychelles"] = 'Seychelles';
	$c["Sierra Leone"] = 'Sierra Leone';
	$c["Singapore"] = 'Singapore';
	$c["Slovakia"] = 'Slovakia';
	$c["Slovenia"] = 'Slovenia';
	$c["Solomon Islands"] = 'Solomon Islands';
	$c["Somalia"] = 'Somalia';
	$c["South Africa"] = 'South Africa';
	$c["South Georgia and The South Sandwich Islands"] = 'South Georgia and The South Sandwich Islands';
	$c["Spain"] = 'Spain';
	$c["Sri Lanka"] = 'Sri Lanka';
	$c["Sudan"] = 'Sudan';
	$c["Suriname"] = 'Suriname';
	$c["Svalbard and Jan Mayen"] = 'Svalbard and Jan Mayen';
	$c["Swaziland"] = 'Swaziland';
	$c["Sweden"] = 'Sweden';
	$c["Switzerland"] = 'Switzerland';
	$c["Syrian Arab Republic"] = 'Syrian Arab Republic';
	$c["Taiwan, Province of China"] = 'Taiwan, Province of China';
	$c["Tajikistan"] = 'Tajikistan';
	$c["Tanzania, United Republic of"] = 'Tanzania, United Republic of';
	$c["Thailand"] = 'Thailand';
	$c["Timor-leste"] = 'Timor-leste';
	$c["Togo"] = 'Togo';
	$c["Tokelau"] = 'Tokelau';
	$c["Tonga"] = 'Tonga';
	$c["Trinidad and Tobago"] = 'Trinidad and Tobago';
	$c["Tunisia"] = 'Tunisia';
	$c["Turkey"] = 'Turkey';
	$c["Turkmenistan"] = 'Turkmenistan';
	$c["Turks and Caicos Islands"] = 'Turks and Caicos Islands';
	$c["Tuvalu"] = 'Tuvalu';
	$c["Uganda"] = 'Uganda';
	$c["Ukraine"] = 'Ukraine';
	$c["United Arab Emirates"] = 'United Arab Emirates';
	$c["United Kingdom"] = 'United Kingdom';
	$c["United States"] = 'United States';
	$c["United States Minor Outlying Islands"] = 'United States Minor Outlying Islands';
	$c["Uruguay"] = 'Uruguay';
	$c["Uzbekistan"] = 'Uzbekistan';
	$c["Vanuatu"] = 'Vanuatu';
	$c["Venezuela"] = 'Venezuela';
	$c["Viet Nam"] = 'Viet Nam';
	$c["Virgin Islands, British"] = 'Virgin Islands, British';
	$c["Virgin Islands, U.S."] = 'Virgin Islands, U.S.';
	$c["Wallis and Futuna"] = 'Wallis and Futuna';
	$c["Western Sahara"] = 'Western Sahara';
	$c["Yemen"] = 'Yemen';
	$c["Zambia"] = 'Zambia';
	$c["Zimbabwe"] = 'Zimbabwe';

	return $c;
}
