<?php  
   App::import('Model','Product'); 

   
   class ProductTestCase extends CakeTestCase { 
        var $fixtures = array('app.product');

    function testPublished() {
            $this->Product =& ClassRegistry::init('Product');
    
            $result = $this->Article->published(array('id', 'title'));
            $expected = array(
                array('Article' => array( 'id' => 1, 'title' => 'First Article' )),
                array('Article' => array( 'id' => 2, 'title' => 'Second Article' )),
                array('Article' => array( 'id' => 3, 'title' => 'Third Article' ))
            );
    
            $this->assertEqual($result, $expected);
        }

   } 
?>