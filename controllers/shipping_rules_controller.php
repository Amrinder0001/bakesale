<?php

/**
 * @brief Shipping rules controller
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: shipping_rules_controller.php 520 2007-11-14 01:48:32Z matti $
 *
 */


class ShippingRulesController extends AppController
{
    public $uses = array('ShippingRule', 'ShippingMethod');


/**
 * add shipping rule
 */

    public function admin_add() {
        if (!empty($this->data)) {
            $this->ShippingRule->save($this->data);
        }
        $this->data['ShippingRule']['id'] = $this->ShippingRule->getLastInsertID();
        $this->set('data', $this->data['ShippingRule']);
        $this->layout = 'ajax';
        $this->viewPath = 'shared';
    }

}
?>