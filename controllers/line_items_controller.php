<?php

class LineItemsController extends AppController
{
    public $uses = array('LineItem', 'Order');

/**
 * add product to shopping cart
 */

    public function add() {
        $this->data['LineItem']['order_id'] = $this->Order->getCartId();
        $this->LineItem->addToCart($this->data['LineItem']);
        $this->Session->write('Order.id', $this->data['LineItem']['order_id']);
        $this->redirect(array('controller' => 'products', 'action' => 'show', 'id' => $this->data['LineItem']['product_id'], 'cart' => 'added'));
    }

/**
 * Update quantities in shopping cart
 */

    public function edit_quantities() {
        $this->LineItem->editQuantities($this->data);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

/**
 * Delete product from shopping cart
 *
 * @param id int
 * The ID field of the order_product to remove.
 */

    public function delete($id) {
        $this->LineItem->delete($id);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

/**
 * Moves products from shopping cart to order (MP: move to model ?).
 *
 * @param $order_id int Order ID
 */

    public function convert($order_id) {
        $data = $this->requestAction('/orders/get_products/');
        foreach($data['LineItem'] as $row) {
            $this->LineItem->stockControl($row);
            $this->data['LineItem'] = array_merge(
                $row['Product'],
                $this->LineItem->generatedOrderInfo($order_id, $row)
            );
            $this->LineItem->create();
            $this->LineItem->save($this->data);
            unset($this->data);
        }
    }

/**
 * Adds new product in order.
 *
 * Redirects the user to the <code>/admin/orders/edit</code> view after adding the product.
 *
 * @param $order_id int Order ID
 */

    public function admin_add() {
        if (!empty($this->data)) {
            if ($this->LineItem->save($this->data)) {
                $this->redirect('/admin/orders/edit/' . $this->data['LineItem']['order_id']);
            }
        }
    }

/**
 * Adds new product in order.
 *
 * Redirects the user to the <code>/admin/orders/edit</code> view after adding the product.
 *
 * @param $id int Order ID
 */

    public function admin_edit($id) {
        if (!empty($this->data)) {
            if ($this->LineItem->save($this->data)) {
                $this->redirect('/admin/orders/edit/' . $this->data['LineItem']['order_id']);
            }
        } else {
            $this->data = $data = $this->LineItem->read(null, $id);
            $this->set(compact('data'));
            $this->render('admin_add');
        }
    }
}
?>