<?php
class TranslatorController extends TranslatorAppController {

	public function index() {
		$location = APP . '/locale/fin/LC_MESSAGES/default.po';
		//die($location);
		$string = file_get_contents($location);
		$data2 = explode("\n", $string);
		$data = array();
		foreach($data2 as $key => $row) {
			$row = ltrim(rtrim($row));
			if(!empty($row) && !strpos($row, '#:')) {
				$data[$key] = $row;
			}
		}
		$this->set(compact('location'));
		//$this->data = $data;
		
	}
}
?>