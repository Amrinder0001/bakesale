<?php 

/**
 * partially based on work of Graydon Stoner - www.getstonered.com
 */

class AuthorizeNet extends PaymentAppModel {

	public $useTable = false;

/**
 * Data unique to shop
 */

	public $defaults = array(
		'loginid' => 'moro',
		'x_tran_key' => 'blaah',
		'test_mode' => 'TRUE',
	);


	public function processorData() {
		return $this->defaults;
	}
	

	public function chargeCard($data) {
		$processorData = $this->_getProcessorData($data);
		$FormattedProcessorData = $this->_getFormattedProcessorData($processorData);
		$gateWayResponse = $this->_getGatewayResponse($FormattedProcessorData);
		return $this->_getGateWayResponseMessage($gateWayResponse);
	}
			
	public function _getProcessorData($data) {
		Configure::load('payment_methods/authorize_net');
		
		$ccexp = $data['CreditCard']['month'] . '/' . $data['CreditCard']['year'];
		
		$DEBUGGING = 1;				# Display additional information to track down problems
		$TESTING = 1;				# Set the testing flag so that transactions are not live
		$ERROR_RETRIES = 2;			# Number of transactions to post if soft errors occur
		$desc = $tax = $shipping = '0';
		### $auth_net_url				= "https://certification.authorize.net/gateway/transact.dll";
		#  Uncomment the line ABOVE for test accounts or BELOW for live merchant accounts
		$auth_net_url = "https://secure.authorize.net/gateway/transact.dll";
		
		$processorData	= array (
			"x_login"				=> Configure::read('authorize_net.x_login'),
			"x_version"				=> "3.1",
			"x_delim_char"			=> "|",
			"x_delim_data"			=> "TRUE",
			"x_url"					=> "FALSE",
			"x_type"				=> "AUTH_CAPTURE",
			"x_method"				=> "CC",
			"x_tran_key"			=> Configure::read('authorize_net.x_tran_key'),
			"x_relay_response"		=> "FALSE",
			"x_card_num"			=> str_replace(" ", "", $data["CreditCard"]['number']),
			"x_card_code"			=> $data['CreditCard']['code'],
			"x_exp_date"			=> $ccexp,
			"x_description"			=> $desc,
			"x_amount"				=> $data['total'],
			"x_tax"					=> $tax,
			"x_freight"				=> $shipping,
			"x_first_name"			=> $data["firstname"],
			"x_last_name"			=> $data["lastname"],
			"x_address"				=> $data["address"],
			"x_city"				=> $data["city"],
			"x_state"				=> $data["state"],
			"x_zip"					=> $data["postcode"],
			"x_country"				=> $data["Order"]['Country']['name'],
			"x_email"				=> $data["email"],
			"x_phone"				=> $data["phone"],
			"x_ship_to_first_name"	=> $data["s_firstname"],
			"x_ship_to_last_name"	=> $data["s_lastname"],
			"x_ship_to_address"		=> $data["s_address"],
			"x_ship_to_city"		=> $data["s_city"],
			"x_ship_to_state"		=> $data["s_state"],
			"x_ship_to_zip"			=> $data["s_postcode"],
			"x_ship_to_country"		=> $data['ShippingCountry']['name'],
		);
		
		return $processorData;
	}
	
	private _getFormattedProcessorData($processorData) {
		$formattedProcessorData = "";
		foreach ($processorData as $key => $value) {
			$formattedProcessorData .= "$key=" . urlencode( $value ) . "&";
		}
		return 	$formattedProcessorData;
	}

/**
 *
 */

	private function _getGatewayResponse($formattedProcessorData) {
		// Post the transaction (see the code for specific information)
		
		
		### $ch = curl_init("https://certification.authorize.net/gateway/transact.dll");
		###  Uncomment the line ABOVE for test accounts or BELOW for live merchant accounts
		$ch = curl_init("https://secure.authorize.net/gateway/transact.dll");  
		### curl_setopt($ch, CURLOPT_URL, "https://secure.authorize.net/gateway/transact.dll");
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim($formattedProcessorData, "& " )); // use HTTP POST to send form data
		
		### Go Daddy Specific CURL Options
		/*
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true); 
    	curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
   		curl_setopt($ch, CURLOPT_PROXY, 'http://proxy.shr.secureserver.net:3128'); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		*/
   		### End Go Daddy Specific CURL Options
   		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
		$gatewayResponse = curl_exec($ch); //execute post and get results
		curl_close ($ch);
		$gatewayResponse $this->response($gatewayResponse);
		return $gatewayResponse;
	}
		

/**
 * Parse through response string
 */
 
 	public function response($resp) {		
		$text = $resp;
		$h = substr_count($text, "|");
		$h++;
		$responsearray = array();

		for($j=1; $j <= $h; $j++){

			$p = strpos($text, "|");

			if ($p === false) { // note: three equal signs
				//  x_delim_char is obviously not found in the last go-around
				// This is final response string
				$responsearray[$j] = $text;
			} else {
				$p++;
				//  get one portion of the response at a time
				$pstr = substr($text, 0, $p);

				//  this prepares the text and returns one value of the submitted
				//  and processed name/value pairs at a time
				//  for AIM-specific interpretations of the responses
				//  please consult the AIM Guide and look up
				//  the section called Gateway Response API
				$pstr_trimmed = substr($pstr, 0, -1); // removes "|" at the end

				if($pstr_trimmed==""){
					$pstr_trimmed="";
				}

				$responsearray[$j] = $pstr_trimmed;

				// remove the part that we identified and work with the rest of the string
				$text = substr($text, $p);

			} // end if $p === false

		} // end parsing for loop
		
		return $responsearray;
		
	} // end chargeCard function

/**
 *
 */
 
	public function _getGateWayResponseMessage($responseArray) {
		$messageArray = array();
		if($responseArray[1] != 1) {
			$messageArray['error'] = $responseArray[4];
		}
		if(empty($messageArray)) {
			return false;
		}
		return $messageArray;
	}
}
?>