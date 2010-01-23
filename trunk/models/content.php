<?php

/**
 * content.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: content.php 437 2007-06-08 12:58:23Z matti $
 */

class Content extends AppModel
{

	public $belongsTo = array('ContentCategory');

}

?>