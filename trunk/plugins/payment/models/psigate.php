<?php 
class Psigate extends PaymentAppModel {

	public $useTable = false;

/**
 * Data unique to shop
 */

	public $defaults = array(
    'store_id' => 'teststore',
    'pass_phrase' => 'psigate1234',
    'method' => 'form',
    'result' => '1',
    'charge_type' => '0',
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
    Configure::load('payment_methods/psigateApi');

    $processorData = array (
    	'StoreID' => Configure::read('psigate.store_id'),
    	'Passphrase' => Configure::read('psigate.pass_phrase'),
    	'Subtotal' => $data['total'],
    	'PaymentType' => 'CC',
    	'CardAction' => '0',
    	'CardNumber' => $data['CreditCard']['number'],
    	'CardExpMonth' => $data['CreditCard']['month'],
    	'CardExpYear' => $data['CreditCard']['year'],
    );
    return $processorData;
	}

/**
 * Format data sent to gateway
 *
 * @param $data
 */
 
	private function _getFormattedProcessorData($processorData) {
    $formattedProcessorData = '<Order>';
    foreach($processorData as $key => $value) { 
    	$formattedProcessorData .= '<' . $key . '>' . $value . '</' .$key . '>';
    }
    $formattedProcessorData .= '</Order>';
    return $formattedProcessorData;
	}

/**
 * Send data to gateway and return response
 *
 * @param $data
 */

	private function _getGatewayResponse($formattedProcessorData) {
    $ch = curl_init("https://dev.psigate.com:7989/Messenger/XMLMessenger");  
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $formattedProcessorData, "& " ));
       
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $gatewayResponse = curl_exec($ch);
    curl_close ($ch);
    return $gatewayResponse;
	}

/**
 * Format possible error message
 */

	private function _getGatewayResponseMessage($gatewayResponse) {
    $gatewayResponseMessage = array();
    if(!strstr($gatewayResponse, '<Approved>APPROVED</Approved>')) {
    	$gatewayResponseMessage['error'] = __('Error', true) . $gatewayResponse;
    }
    if(empty($gatewayResponseMessage)) {
    	return false;
    }
    return $gatewayResponseMessage;
	}
}
?>