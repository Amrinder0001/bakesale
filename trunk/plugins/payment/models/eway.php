<?php 
class Eway extends PaymentAppModel {

	public $useTable = false;

/**
 * Data unique to shop
 */

	public $defaults = array(
    'customer_id' => '87654321',
    );

	public function processorData() {
    return $this->defaults;
	}
	
/**
 * Format map order data to fields required by gateway
 *
 * @param $data
 */
 
	public function chargeCard($data) {
    $processorData = $this->_getProcessorData($data);
    $FormattedProcessorData = $this->_getFormattedProcessorData($processorData);
    $gatewayResponse = $this->_getGatewayResponse($FormattedProcessorData);
    return $this->_getGatewayResponseMessage($gatewayResponse);
	}

/**
 * Format map order data to fields required by gateway
 *
 * @param $data
 */

	public function _getProcessorData($data) {
    Configure::load('payment_methods/eway');

    $processorData = array (
    	'ewayCustomerID' => Configure::read('eway.customer_id'),
    	'ewayTotalAmount' => $data['total'],
    	'ewayCardNumber' => $data['CreditCard']['number'],
    	'ewayCardExpiryMonth' => $data['CreditCard']['month'],
    	'ewayCardExpiryYear' => $data['CreditCard']['year'],
    );
    return $processorData;
	}

/**
 * Format data sent to gateway
 *
 * @param $data
 */
 
	private function _getFormattedProcessorData($processorData) {
    $formattedProcessorData = '<ewaygateway>';
    foreach($processorData as $key => $value) { 
    	$formattedProcessorData .= '<' . $key . '>' . htmlentities($value) . '</' .$key . '>';
    }
    $fields .= '</ewaygateway>';
    
    return $formattedProcessorData;
	}

/**
 * Send data to gateway and return response
 *
 * @param $data
 */

	private function _getGatewayResponse($formattedProcessorData) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.eway.com.au/gateway/xmltest/testpage.asp');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $formattedProcessorData);
    curl_setopt($ch, CURLOPT_TIMEOUT, 240);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $gatewayResponse = curl_exec($ch);
    curl_close ($ch);
    return $gatewayResponse;
	}

/**
 * Format possible error message
 */

	private function _getGatewayResponseMessage($gatewayResponse) {
    $gatewayResponseMessage = array();
    if(!strstr($gatewayResponse, '<ewayTrxnStatus>False</ewayTrxnStatus>')) {
    	$gatewayResponseMessage['error'] = __('Error', true) . $gatewayResponse;
    }
    if(empty($gatewayResponseMessage)) {
    	return false;
    }
    return $gatewayResponseMessage;
	}
}
?>