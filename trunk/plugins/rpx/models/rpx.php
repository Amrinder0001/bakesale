<?php
   
/**
 */

class  Rpx extends RpxAppModel {
    public $useTable = false;
	private $_apiKey = '1b20c7243fc1d311d55a7a230a242afcb89d95d2';
	private $_siteName = "BakeSale"; 

/**
 * Get site name 
 */
 
 	public function getSiteName() {
		return $this->_siteName;
	}

/**
 * Get auth infofrom RPX 
 */
	
	public function getAuthInfo($token) {
		$post_data = array(
			'token' => $token,
			'apiKey' => $this->_apiKey,
			'format' => 'json'
		); 
		
		// make the api call using libcurl
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, 'https://rpxnow.com/api/v2/auth_info');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$raw_json = curl_exec($curl);
		curl_close($curl);
		
		// parse the json response into an associative array
		return json_decode($raw_json, true);
    }
	
}
?>