<?php

/**
 * BakeSale shopping cart
 * Copyright (c)	2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright (c) 2006-2009, Matti Putkonen
 * @link			http://bakesalepro.com/
 * @package			BakeSale
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Manages brands and related products.
 *
 * This controller lets you add, view, and remove brands from the shop.
 */

class BrandsController extends AppController
{
 	
    public $paginate = array('limit' => 15, 'page' => 1, 'order'=>array('Brand.name'=>'asc')); 


/**
 * Displays the available brands in a menu.
 *
 * The brands are searched by the criteria <code>brands.active=1</code>.
 */

    public function menu() {
		return $this->Brand->bsFindAllActive();
    }

/**
 * Displays all brands in a admin.
 *
 */

    public function admin_index() {
		$this->data = $this->paginate('Brand');
    }

/**
 * Shows (active) brands in the shop.
 *
 * @param id int
 * The ID field of the brand to show.
 */

    public function show($id) {
        $this->cacheAction = true;
        $this->data = $this->Brand->bsFindOne(-1, compact('id'));
    }

/**
 * Shows (active) products for brand
 *
 * The search goes two levels deep.
 *
 * @param id int
 * The ID field of the brand to show.
 */

    public function products($id) {
        return $this->Brand->bsFindOne(2, compact('id'));
    }

}
?>
