<?php
/**
 * BakeSale shopping cart
 * Copyright (c)	2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author          Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright    Copyright (c) 2006-2009, Matti Putkonen
 * @link    	http://bakesalepro.com/
 * @package    	BakeSale
 * @license    	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id$
 */

class ImagesController extends AppController{
    public $uses = array();

/**
 * 
 */

    public function admin_default($id, $model, $image) {
		$data = ClassRegistry::init($model)->findById($id);
        $images = $image . ';' . str_replace($image, '', $data[$model]['images']);
        $this->_save($id, $model, $images);
    }

/**
 *  Show image
 */

    public function admin_get($id, $model, $image) {
        $this->set(compact('id', 'model', 'image'));
    }

/**
 * 
 */

    public function admin_delete($id, $model, $image) {
		$data = ClassRegistry::init($model)->findById($id);
        $images = str_replace($image, '', $data[$model]['images']);
        $this->_save($id, $model, $images);
        $controller = Inflector::tableize($model);
		$action = 'edit';
        $this->redirect(array('controller' => $controller, 'action' => 'edit', 'id' => $id));
    }

/**
 *  Save images field
 */

    private function _save($id, $model, $images) {
        $images = rtrim($images, ";");
        $images = ltrim($images, ";");
        $images = str_replace(';;', ';', $images);
        $this->$model =  ClassRegistry::init($model);
        $this->$model->id = $id;
        $this->$model->saveField('images', $images);
    }

}

?>