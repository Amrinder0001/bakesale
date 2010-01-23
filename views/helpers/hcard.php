<?php

/**
 * TODO
 */

class HcardHelper extends Helper {

/**
 * TODO
 */

    public function addressFormatHtml($data,  $prefix = false, $format = 'General') {
    $data = $this->filter($data, $prefix);
    $text = '';
    $text .= '<div id="hcard-' . $this->_fullName($data, '-') . '" class="vcard">';
    $text .= '<span class="fn">' . $this->_fullName($data) . '</span>';
    $text .= $this->address($data, $format);
    $text .= '</div>';
    return $text;
    }

/**
 * TODO
 */

    public function addressFormatRaw($data,  $prefix = false, $format = 'General') {
    $data = $this->filter($data, $prefix);
    $text = $this->_fullName($data) . "\n";
    $text .= $data['address'] . "\n";
    if(Configure::read('Localization.address_format') == 'US') {
    	$text .= $data['city'] . ', ' . $data['state'] . ' ' . $data['postcode'] . "\n";
    } else {
    	$text .= $data['postcode'] . ' ' . $data['city'] . "\n";    	
    }
    $text .= $data['country'];
    return $text;
    }

/**
 * TODO
 */

    public function _fullName($data, $seperator = ' ') {
    $name = $data['firstname'] . $seperator . $data['lastname'];
    return $name;
	}


/**
 * TODO
 */

    public function address($data) {
    $text = '<div class="adr">';
    $text .= '<div class="street-address">' . $data['address'] . '</div> ';
    $text .= '<span class="locality">' . $data['city'] . '</span>, ';
    if(!empty($data['state'])) {
    	$text .= '<span class="region">' . $data['state'] . '</span> ';
    }
    $text .= '<span class="postal-code">' . $data['postcode'] . '</span> ';
    $text .= '<span class="country-name">' . $data['country'] . '</span> ';
    $text .= '</div>';
    return $text;
    
	}


/**
 * TODO
 */

    public function filter($data, $prefix = '') {
    if($prefix) {
    	foreach($data as $key => $row) {
        $data[$prefix . $key] = $data[$key];
    	}
    }
    return $data;
	}

}
?>
