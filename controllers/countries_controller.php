<?php
/**
 * BakeSale shopping cart
 * Copyright (c)	2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author  Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright      Copyright (c) 2006-2009, Matti Putkonen
 * @link                http://bakesalepro.com/
 * @package    BakeSale
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id: countries_controller.php 512 2007-10-05 07:12:41Z matti $
 */

/**
 * Manages the listing of the country information.
 */
 
class CountriesController extends AppController
{

/**
 * Gets information for one country.
 *
 * Information that is stored in the database for the country is retrieved.
 *
 * @param $id int Country ID.
 * @return Data that is stored in the database for the specified country.
 */

    public function info($id) {
        $this->Country->recursive = -1;
        $data = $this->Country->findById($id);
        return $data['Country'];
    }

/**
 * Adds new country
 */
    public function admin_add($abbr = false) {
        if($abbr) {
            $this->data['Country'] = $this->Country->countryFull($abbr);
            $this->redirect(array('action' => 'edit', 'id' => $this->Country->bsAdd($this->data)));
        } else {
            $this->data = $this->Country->allAvailable();
        }
    }

/**
 * Edit country in admin.
 *
 * A list of shipping methods is generated from the database, and the selected methods are highlighted.
 *
 * After the country is edited successfully, the user is redirected back to the <em>previous</em> URL.
 * @param id int The ID field of the country to edit.
 */

    public function admin_edit($id) {
        parent::admin_edit($id);
        $shippingMethods = ClassRegistry::init('ShippingMethod')->find('list');
        $this->set(compact('shippingMethods'));
    }

/**
 * List all countries in the admin page.
 */

    public function admin_index() {
        $this->data = $this->Country->find('all', array('order' => 'Country.sort ASC'));
    }

}

?>