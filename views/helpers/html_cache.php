<?php
/*
 * HTML Cache CakePHP Helper
 * Copyright (c) 2008 Matt Curry
 * www.PseudoCoder.com
 * http://github.com/mcurry/cakephp/tree/master/helpers/html_cache
 * http://www.pseudocoder.com/archives/2008/09/03/cakephp-html-cache-helper/
 *
 * @author      mattc <matt@pseudocoder.com>
 * @license     MIT
 *
 */

class HtmlCacheHelper extends Helper {
  function afterLayout() {
    if (Configure::read('debug') > 0) {
      return;
    }

    $view =& ClassRegistry::getObject('view');

    //handle 404s
    if ($view->name == 'CakeError') {
      $path = $this->params['url']['url'];
    } else {
      $path = $this->here;
    }

    $path = implode(DS, array_filter(explode('/', $path)));
    if($path !== '') {
      $path = DS . ltrim($path, DS);
    }
    $path = WWW_ROOT . 'cache' . $path;

    $file = new File($path, true);
    $file->write('/* I came from cache */' . $view->output);
  }
}
?>
