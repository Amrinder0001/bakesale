<?php

/**
 *
 */

class DescriptionHelper extends Helper {

	var	$allowedTags = '<h1><h2><h3><h4><h5><a><img><label><p><br><span><sup><sub><ul><li><ol><table><tr><td><th><tbody><div><hr><em><b><i>';
    var	$evilStyles = array('font', 'font-family', 'font-face', 'font-size', 'font-size-adjust', 'font-stretch', 'font-variant');

/**
 * 
 * 
 */

	public function out($text, $format = 'markdown') {
    switch ($format){
        case 'markdown':
        App::import('Vendor', 'markdown');
            $text = Markdown(strval($text));
        	break; 
        default:
    	}
    return $text;
    }

/**
 * 
 * 
 */

	public function removeEvilStyles($tagSource) {
    	$find = array();
    	$replace = array();
   
    	foreach ($this->evilStyles as $v) {
        	$find[]    = "/$v:.*?;/";
        	$replace[] = '';
    }
   
    return preg_replace($find, $replace, $tagSource);
	}

/**
 * 
 * 
 */

	public function removeEvilTags($source) {
    $source = strip_tags(stripslashes($source), $this->allowedTags);
    return trim(preg_replace('/<(.*?)>/ie', "'<'.removeEvilStyles('\\1').'>'", $source));
	}

}
?>
