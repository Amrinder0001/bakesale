<?php

uses('Sanitize');

/**
 * BakeSale shopping cart
 * Copyright (c)    2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author          Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright        Copyright (c) 2006-2009, Matti Putkonen
 * @link            http://bakesalepro.com/
 * @package            BakeSale
 * @license            http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id: pages_controller.php 512 2007-10-05 07:12:41Z matti $
 */

/**Included the <i>folder</i> library
  */
  
uses('folder');

/**
 * PagesController takes care of displaying appropriate webpages.
 */

class PagesController extends AppController {

    public $uses = '';

/**
 * Show homepage
 */

    public function display() {
        $this->cacheAction = true;
    }

/*
 * Shows a customised error page for the 404 error.
 *
 * As of now this function is empty (i.e. a placeholder.)
 */

    public function error404() {
    }

/**
 * robots.txt file
 */

    public function robots() {
        $this->layout = 'ajax';
    }

}

?>