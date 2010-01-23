<?php

/**
 * country.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: country.php 500 2007-08-25 15:16:53Z matti $
 */

class Country extends AppModel
{

	public $hasAndBelongsToMany = array('ShippingMethod'  =>
                       array('className' => 'ShippingMethod',
                             'order' => 'ShippingMethod.sort ASC'));

	public $validate = array(
		'name' => array(
			'unique' => array(
				'rule' => 'isUnique',  
				'message' => 'Country name already exists',
			 ),
		),
		'code' => array(
			'unique' => array(
				'rule' => 'isUnique',  
				'message' => 'Country code already exists',
			 ),
			'lenght' => array(
				'rule' => array('between', 2, 2),
				'message' => 'Code needs to be 2 letters long',
			 ),
		)
	);

/**
 * Return all contries that are not yet added
 */
 
	public function allAvailable() {
		$all = $this->all_countries();
		$current = $this->find('all');
			
		foreach ($current as $row) {
			$countries[$row['Country']['code']] = $row['Country']['name'];
		}
			
		foreach ($all as $key => $row) {
			if(!array_key_exists($key, $countries)) {
			$result[$key] = $row;
			}
		}
		return $result;
	}

/**
 * Storage of all the countries in the world
 */

	public function all_countries () {
		return array(
			'AC'=>array('Ascension Island', 'ACI'),
			'AD'=> array('Andorra', 'AND'),
			'AE'=>array('United Arab Emirates', ''),
			'AF'=> array('Afghanistan', 'AFG'),
			'AG'=>array('Antigua and Barbuda', ''),
			'AI'=>array('Anguilla', ''),
			'AL'=>array('Albania', ''),
			'AM'=>array('Armenia', ''),
			'AN'=>array('Netherland Antilles', ''),
			'AO'=>array('Angola', ''),
			'AQ'=>array('Antarctica', ''),
			'AR'=>array('Argentina', ''),
			'AS'=>array('American Samoa', ''),
			'AT'=>array('Austria', ''),
			'AU'=>array('Australia', ''),
			'AW'=>array('Aruba', ''),
			'AZ'=>array('Azerbaidjan', ''),
			'BA'=>array('Bosnia-Herzegovina', ''),
			'BB'=>array('Barbados', ''),
			'BD'=>array('Bangladesh', ''),
			'BE'=>array('Belgium', ''),
			'BF'=>array('Burkina Faso', ''),
			'BG'=>array('Bulgaria', ''),
			'BH'=>array('Bahrain', ''),
			'BI'=>array('Burundi', ''),
			'BJ'=>array('Benin', ''),
			'BM'=>array('Bermuda', ''),
			'BN'=>array('Brunei Darussalam', ''),
			'BO'=>array('Bolivia', ''),
			'BR'=>array('Brazil', ''),
			'BS'=>array('Bahamas', ''),
			'BT'=>array('Buthan', ''),
			'BV'=>array('Bouvet Island', ''),
			'BW'=>array('Botswana', ''),
			'BY'=>array('Belarus', ''),
			'BZ'=>array('Belize', ''),
			'CA'=>array('Canada', ''),
			'CC'=>array('Cocos (Keeling) Islands', ''),
			'CD'=>array('Congo, The Democratic Republic of the', ''),
			'CF'=>array('Central African Rep.', ''),
			'CG'=>array('Congo, Republic of', ''),
			'CH'=>array('Switzerland', ''),
			'CI'=>array('Ivory Coast', ''),
			'CK'=>array('Cook Islands', ''),
			'CL'=>array('Chile', ''),
			'CM'=>array('Cameroon', ''),
			'CN'=>array('China', ''),
			'CO'=>array('Colombia', ''),
			'CR'=>array('Costa Rica', ''),
			'CS'=>array('Serbia and Montenegro', ''),
			'CU'=>array('Cuba', ''),
			'CV'=>array('Cape Verde', ''),
			'CX'=>array('Christmas Island', ''),
			'CY'=>array('Cyprus', ''),
			'CZ'=>array('Czech Republic', ''),
			'DE'=>array('Germany', ''),
			'DJ'=>array('Djibouti', ''),
			'DK'=>array('Denmark', ''),
			'DM'=>array('Dominica', ''),
			'DO'=>array('Dominican Republic', ''),
			'DZ'=>array('Algeria', ''),
			'EC'=>array('Ecuador', ''),
			'EE'=>array('Estonia', ''),
			'EG'=>array('Egypt', ''),
			'EH'=>array('Western Sahara', ''),
			'ER'=>array('Eritrea', ''),
			'ES'=>array('Spain', ''),
			'ET'=>array('Ethiopia', ''),
			'FI'=>array('Finland', ''),
			'FJ'=>array('Fiji', ''),
			'FK'=>array('Falkland Islands (Malvinas)', ''),
			'FM'=>array('Micronesia', ''),
			'FO'=>array('Faroe Islands', ''),
			'FR'=>array('France', ''),
			'GA'=>array('Gabon', ''),
			'GB'=>array('Great Britain (UK)', ''),
			'GD'=>array('Grenada', ''),
			'GE'=>array('Georgia', ''),
			'GF'=>array('Guyana (Fr.)', ''),
			'GG'=>array('Guernsey', ''),
			'GH'=>array('Ghana', ''),
			'GI'=>array('Gibraltar', ''),
			'GL'=>array('Greenland', ''),
			'GM'=>array('Gambia', ''),
			'GN'=>array('Guinea', ''),
			'GP'=>array('Guadeloupe (Fr.)', ''),
			'GQ'=>array('Equatorial Guinea', ''),
			'GR'=>array('Greece', ''),
			'GS'=>array('South Georgia and the South Sandwich Islands', ''),
			'GT'=>array('Guatemala', ''),
			'GU'=>array('Guam (US)', ''),
			'GW'=>array('Guinea Bissau', ''),
			'GY'=>array('Guyana', ''),
			'HK'=>array('Hong Kong', ''),
			'HM'=>array('Heard and McDonald Islands', ''),
			'HN'=>array('Honduras', ''),
			'HR'=>array('Croatia', ''),
			'HT'=>array('Haiti', ''),
			'HU'=>array('Hungary', ''),
			'ID'=>array('Indonesia', ''),
			'IE'=>array('Ireland', ''),
			'IL'=>array('Israel', ''),
			'IM'=>array('Isle of Man', ''),
			'IN'=>array('India', ''),
			'IO'=>array('British Indian O. Terr.', ''),
			'IQ'=>array('Iraq', ''),
			'IR'=>array('Iran', ''),
			'IS'=>array('Iceland', ''),
			'IT'=>array('Italy', ''),
			'JM'=>array('Jamaica', ''),
			'JO'=>array('Jordan', ''),
			'JP'=>array('Japan', ''),
			'KE'=>array('Kenya', ''),
			'KG'=>array('Kirgistan', ''),
			'KH'=>array('Cambodia', ''),
			'KI'=>array('Kiribati', ''),
			'KM'=>array('Comoros', ''),
			'KN'=>array('SaintKitts Nevis Anguilla', ''),
			'KP'=>array('Korea (North)', ''),
			'KR'=>array('Korea (South)', ''),
			'KW'=>array('Kuwait', ''),
			'KY'=>array('Cayman Islands', ''),
			'KZ'=>array('Kazachstan', ''),
			'LA'=>array('Laos', ''),
			'LB'=>array('Lebanon', ''),
			'LC'=>array('Saint Lucia', ''),
			'LI'=>array('Liechtenstein', ''),
			'LK'=>array('Sri Lanka', ''),
			'LR'=>array('Liberia', ''),
			'LS'=>array('Lesotho', ''),
			'LT'=>array('Lithuania', ''),
			'LU'=>array('Luxembourg', ''),
			'LV'=>array('Latvia', ''),
			'LY'=>array('Libya', ''),
			'MA'=>array('Morocco', ''),
			'MC'=>array('Monaco', ''),
			'MD'=>array('Moldavia', ''),
			'MG'=>array('Madagascar', ''),
			'MH'=>array('Marshall Islands', ''),
			'MK'=>array('Macedonia, The Former Yugoslav Republic of', ''),
			'ML'=>array('Mali', ''),
			'MM'=>array('Myanmar', ''),
			'MN'=>array('Mongolia', ''),
			'MO'=>array('Macau', ''),
			'MP'=>array('Northern Mariana Islands', ''),
			'MQ'=>array('Martinique (Fr.)', ''),
			'MR'=>array('Mauritania', ''),
			'MS'=>array('Montserrat', ''),
			'MT'=>array('Malta', ''),
			'MU'=>array('Mauritius', ''),
			'MV'=>array('Maldives', ''),
			'MW'=>array('Malawi', ''),
			'MX'=>array('Mexico', ''),
			'MY'=>array('Malaysia', ''),
			'MZ'=>array('Mozambique', ''),
			'NA'=>array('Namibia', ''),
			'NC'=>array('New Caledonia (Fr.)', ''),
			'NE'=>array('Niger', ''),
			'NF'=>array('Norfolk Island', ''),
			'NG'=>array('Nigeria', ''),
			'NI'=>array('Nicaragua', ''),
			'NL'=>array('Netherlands', ''),
			'NO'=>array('Norway', ''),
			'NP'=>array('Nepal', ''),
			'NR'=>array('Nauru', ''),
			'NU'=>array('Niue', ''),
			'NZ'=>array('New Zealand', ''),
			'OM'=>array('Oman', ''),
			'PA'=>array('Panama', ''),
			'PE'=>array('Peru', ''),
			'PF'=>array('Polynesia (Fr.)', ''),
			'PG'=>array('Papua New Guinea', ''),
			'PH'=>array('Philippines', ''),
			'PK'=>array('Pakistan', ''),
			'PL'=>array('Poland', ''),
			'PM'=>array('Saint Pierre and Miquelon', ''),
			'PN'=>array('Pitcairn', ''),
			'PR'=>array('Puerto Rico (US)', ''),
			'PT'=>array('Portugal', ''),
			'PW'=>array('Palau', ''),
			'PY'=>array('Paraguay', ''),
			'QA'=>array('Qatar', ''),
			'RE'=>array('Reunion (Fr.)', ''),
			'RO'=>array('Romania', ''),
			'RU'=>array('Russian Federation', ''),
			'RW'=>array('Rwanda', ''),
			'SA'=>array('Saudi Arabia', ''),
			'SB'=>array('Solomon Islands', ''),
			'SC'=>array('Seychelles', ''),
			'SD'=>array('Sudan', ''),
			'SE'=>array('Sweden', ''),
			'SG'=>array('Singapore', ''),
			'SH'=>array('Saint Helena', ''),
			'SI'=>array('Slovenia', ''),
			'SJ'=>array('Svalbard and Jan Mayen Islands', ''),
			'SK'=>array('Slovak Republic', ''),
			'SL'=>array('Sierra Leone', ''),
			'SM'=>array('San Marino', ''),
			'SN'=>array('Senegal', ''),
			'SO'=>array('Somalia', ''),
			'SR'=>array('Suriname', ''),
			'ST'=>array('Saint Tome and Principe', ''),
			'SV'=>array('El Salvador', ''),
			'SY'=>array('Syria', ''),
			'SZ'=>array('Swaziland', ''),
			'TC'=>array('Turks and Caicos Islands', ''),
			'TD'=>array('Chad', ''),
			'TF'=>array('French Southern Territories', ''),
			'TG'=>array('Togo', ''),
			'TH'=>array('Thailand', ''),
			'TJ'=>array('Tadjikistan', ''),
			'TK'=>array('Tokelau', ''),
			'TM'=>array('Turkmenistan', ''),
			'TN'=>array('Tunisia', ''),
			'TO'=>array('Tonga', ''),
			'TP'=>array('East Timor', ''),
			'TR'=>array('Turkey', ''),
			'TT'=>array('Trinidad and Tobago', ''),
			'TV'=>array('Tuvalu', ''),
			'TW'=>array('Taiwan', ''),
			'TZ'=>array('Tanzania', ''),
			'UA'=>array('Ukraine', ''),
			'UG'=>array('Uganda', ''),
			'UK'=>array('United Kingdom', ''),
			'UM'=>array('US Minor outlying Islands', ''),
			'US'=>array('United States', ''),
			'UY'=>array('Uruguay', ''),
			'UZ'=>array('Uzbekistan', ''),
			'VA'=>array('Vatican City State', ''),
			'VC'=>array('SaintVincent and Grenadines', ''),
			'VE'=>array('Venezuela', ''),
			'VG'=>array('Virgin Islands (British)', ''),
			'VI'=>array('Virgin Islands (US)', ''),
			'VN'=>array('Vietnam', ''),
			'VU'=>array('Vanuatu', ''),
			'WF'=>array('Wallis and Futuna Islands', ''),
			'WS'=>array('Samoa', ''),
			'YE'=>array('Yemen', ''),
			'YU'=>array('Yugoslavia', ''),
			'ZA'=>array('South Africa', ''),
			'ZM'=>array('Zambia', ''),
			'ZR'=>array('Zaire', ''),
			'ZW'=> array('Zimbabwe', ''),
		);
	}

/**
 * Returns a string containing a full country name. If no country matches the abbreviation, the abbreviation is returned.
 *
 * @param int $abbr the two letter country abbreviation
 * @return string the full name of a state
 */
	 
    public function countryFull($abbr) {
		$countries = $this->all_countries();
		$country = $countries[$abbr];
		$data = array(
			'code' => $abbr,
			'name' => $country[0],
			'code3' => $country[1],
		);
		return $data;
    }

/**
 * kalileo
 */


	public function getCountryData($id = false) {
		$this->recursive = 1;
		$data = $this->find('Country.id = ' . $id);
		$associations = array('ShippingMethod');
		foreach($associations as $model) {
			if(!empty($data[$model])) {
				foreach($data[$model] as $key => $row){
					if($row['active'] != '1') {
					unset($data[$model][$key]);
					}
				}
			}
		}
		return $data;
    }

/**
* Gets the default shipping method for country.
*
* The default country ID is the country with the smallest ID.
* (KALILEO: moved from Controller to Model)
*
* @return the ID of the country.
*/

    public function getShippingMethodId($id) {
        $data = $this->getCountryData($id);
		return $data['ShippingMethod'][0]['id'];
    }

/**
* Gets the default country.
*
* The default country ID is the country with the smallest sort.
* (KALILEO: moved from Controller to Model)
*
* @return the ID of the country.
*/

    public function getDefaultId() {
        $data = $this->find('first', array('conditions' => array('active' => '1'), 'order' => 'sort ASC'), -1);
        return $data['Country']['id'];
    }

/**
* Get the name of the country registered for shopping cart
* @return the name of the country.
*/

    public function getShoppingCartCountryName($id = false) {
		if(!$id) {
			$id = Configure::read('Order.country_id');
		}
			$data = $this->find('first', array('conditions' => array('id' => $id), -1));
			return $data['Country']['name'];
		}

}