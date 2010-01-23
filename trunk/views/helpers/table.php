<?php

/**
 *
 */

class TableHelper extends Helper {
	public $helpers = array('Form', 'Html', 'Price', 'Session', 'Images');

	public function create() {
    $table = '<table id="' . $this->params['controller'] . '">';
    $table .= $this->getThead();
    $table .= $this->getTfooter();
    $table .= $this->getTbody();
    $table = '</table>';
	}

	private function getThead() {
    $thead = '<thead>';
    $thead .= '<tr>';
    $thead .= '</tr>';
    $thead .= '</thead>';
    return $thead;
	}

	private function getTfooter() {
    $thead = '<tfoot>';
    $thead .= '<tr>';
    $thead .= '</tr>';
    $thead .= '</tfoor>';
	}

	private function getTbody() {
    $thead = '<tbody>';
    $thead .= '</tbody>';
	}


}