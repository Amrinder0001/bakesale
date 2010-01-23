<?php

/**
 * @brief Images helper
 *
 * @package BakeSale
 * @version $Id: images.php 492 2007-08-03 11:36:11Z drayen $
 */

class ImagesHelper extends Helper {
	

    public $helpers = array('Html');
    public $cacheDir = 'cache/';
	public $uploadDir = 'uploads/';



   public function __construct() {
       $this->types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); 
	   $this->fullpath = WWW_ROOT;
	   $this->fullServerPath = ROOT . DS . APP_DIR . DS . WEBROOT_DIR;
	   $this->imgBase = '/' . $this->webroot . $this->themeWeb . 'img' . '/';
   }
	
	// relative to IMAGES_URL path 
  /**
   * Automatically resizes an image and returns formatted IMG tag
   *
   * @param string $path Path to the image file, relative to the webroot/img/ directory.
   * @param integer $width Image of returned image
   * @param integer $height Height of returned image
   * @param boolean $aspect Maintain aspect ratio (default: true)
   * @param array    $htmlAttributes Array of HTML attributes.
   * @param boolean $return Wheter this method should return a value or output it. This overrides AUTO_OUTPUT.
   * @return mixed    Either string or echos the value, depends on AUTO_OUTPUT and $return.
   * @return html return entire html complex or just the file name.
     */
 
	public function resize($path, $alt = false, $width = false, $height = false, $aspect = true, $htmlAttributes = array(), $return = false, $html = true) {
    if(!$width) {
    	$width = Configure::read('Image.thumb_width');
    }
    if(!$height) {
    	$height = Configure::read('Image.thumb_height');
    }	
    if(!$alt) {
    	$alt = 'thumb';
    }
    
    $htmlAttributes['alt'] = $alt;
    
    	$fullpath = WWW_ROOT . DS . 'img' . DS;
    	$url = $fullpath . $path;


    
    if (!($size = getimagesize($url))) {
    	return; // image doesn't exist 
    }
    
    if ($aspect) { // adjust to aspect.
    	if (($size[1]/$height) > ($size[0]/$width)) { // $size[0]:width, [1]:height, [2]:type
        $width = ceil(($size[0]/$size[1]) * $height);
    	} else {
        $height = ceil($width / ($size[0]/$size[1]));
        }
    }	
    $relfile = $this->imgBase . $this->cacheDir . $width . 'x' . $height . '_' . basename($path); // relative file
    $cachefile = $fullpath . $this->cacheDir . $width . 'x' . $height . '_' . basename($path);  // location on server
    if(!$this->_ThumbnailSize($url, $width, $height)) {
        return $this->_imageHtml($this->imgBase . $path, $alt);
    }
    if (file_exists($cachefile)) {
    	$csize = getimagesize($cachefile);
    	$cached = ($csize[0] == $width && $csize[1] == $height); // image is cached
    	if (@filemtime($cachefile) < @filemtime($url)) // check if up to date
        $cached = false;
    	} else {
        $cached = false;
    	}

    if (!$cached) {
      $resize = ($size[0] > $width || $size[1] > $height) || ($size[0] < $width || $size[1] < $height);
    } else {
      $resize = false;
    }
    if ($resize) {
    $this->_resizeImage($url, $width, $height, $size, $cachefile);
	} elseif (!$cached) { 
    copy($url, $cachefile);
	}
	$htmlAttributes['width'] = $width;
	$htmlAttributes['height'] = $height;
	$relfile = $this->Html->url($relfile);
	$relfile = Configure::read('SpeedOptimization.static_url') . $relfile;
	if($html) {
    	return $this->output(sprintf($this->Html->tags['image'], $relfile, $this->Html->_parseAttributes($htmlAttributes, null, '', ' ')), $return);
	} else {
    return $relfile;
	}
  } 

/**
 * Resize image
 */

	public function _resizeImage($url, $width, $height, $size, $cachefile) {
		$image = call_user_func('imagecreatefrom' . $this->types[$size[2]], $url);
		if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor ($width, $height))) {
			imageAlphaBlending($temp, false);
			imageSaveAlpha($temp, true);
			imagecopyresampled ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
		} else {
			$temp = imagecreate ($width, $height);
			imagecopyresized ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
		}
		call_user_func("image" . $this->types[$size[2]], $temp, $cachefile);
		imagedestroy ($image);
		imagedestroy ($temp);
	}


/**
 * Show single image
 */

	public function _imageHtml($image, $alt = false) {
		$imageArray = array_merge($this->_imageSize(WWW_ROOT . $image), array($alt));
		return $this->Html->image($image, $imageArray);
	}


/**
 * Show single image
 */

	public function singleImage($file, $alt = false, $width = false, $height = false) {
		return $this->resize($this->uploadDir . $file, $alt, $width, $height);
	}

/**
 * Show single image
 */

	public function singleImageSrc($file) {
		return $this->resize($this->uploadDir . $file, false, false, false, true, array(), false, false);
	}


/**
 * Show product thmbnail or error image
 */

	public function mainImage($data, $imgLink = false, $width = false, $height = false) {
		$imageArray = $this->_imageArray($data['images']);
		if(empty($imageArray)) {
			$imgLink = false;
			$imageArray[0] = 'error.png';
		}
		if($imgLink) {
			$link = $this->imageLink($imageArray[0]);
			$imgLink = $link['full'];
			return '<a href="' . $link['url'] . '">' . $this->resize($this->uploadDir . $imageArray[0], $data['name'], $width, $height) . '</a>' . $imgLink;
		} else {
			return $this->resize($this->uploadDir . $imageArray[0], $data['name'], $width, $height);    	
		}
	}

/**
 * Show product main image thumbnail in admin
 */

	public function adminMainImage($data, $imgLink = false, $width = false, $height = false) {
		$imageHtml = $this->resize($this->uploadDir . $data['main_image'], $data['name'], $width, $height);
		return $imageHtml . $this->_adminImageLink($data['main_image']) .  $this->_adminImageLink($data['main_image'], 'default');
	;
	}

/**
 * Create image delete link
 */

	public function _adminImageLink($image, $type = 'delete') {
		$url = '/admin/images/' . $type . '/' . $this->params['pass'][0] . '/'  . $this->params['models'][0] . '/' . $image;
		return $this->Html->link($type, $url, array('class' => $type));
	}

/**
 * Show images in admin
 */

	public function adminImageList($data) {
		$placeHolder = false;
		if(empty($data['images'])) {
			$data['images'] = 'error.png';
			$placeHolder = true;
		}
    	$images = explode(";", $data['images']);
    	$list = '<ul class="cols">';
    	foreach($images as $row) {
        $list .= '<li>';
        $list .= $this->resize($this->uploadDir . $row);
        if(!$placeHolder) {
        	$list .= $this->_adminImageLink($row);
        	$list .= $this->_adminImageLink($row, 'default');
        }
        $list .= '</li>';
    	}
    	$list .= '</ul>';
    	return $list;
	}

/**
 * TODO
 */

	public function ImageList($images, $ulClass = false, $alt = false, $width = false, $height = false ) {
		$imageArray = $this->_imageArray($images);
		return $this->imageListHtml($imageArray, $ulClass, $alt, $width, $height);
	}

/**
 * TODO
 */

	public function _imageArray($images) {
		$imageArray = array();
		if(!empty($images)) {
			if(!strstr($images, ';')) {
			$imageArray[0] = $images;
			} else {
			$imageArray = explode(";", $images);
			}
		}
		return $imageArray;
	}

/**
 * TODO
 */

	public function extraImageList($data) {
		$images = $data['images'];
		$list = '';
		if(strstr($images, ';')) {
			$imageArray = explode(";", $images);
			unset($imageArray[0]);
			$list = $this->imageListHtml($imageArray, 'cols', $data['name']);
		}
		return $list;
	}

/**
 * TODO
 */

	public function imageListHtml($images, $ulCssClass = '', $alt = '', $width = false, $height = false) {
		if(!empty($ulCssClass)) {
			$ulCssClass = ' class="' . $ulCssClass . '"';
		}
		$list = '<ul' . $ulCssClass . '>';
		foreach($images as $row) {
			$image = $this->resize($this->uploadDir . $row, $alt, $width, $height);
			$link = $this->imageLink($row);
			$list .= '<li><a href="' . $link['url'] . '">' . $image . '</a>';
			$list .= $link['full'];
			$list .= '</li>';
		}
		$list .= '</ul>';
		return $list;
	}

/**
 * TODO
 */

	public function imageLink($image, $cssClass = '') {
		$link['url'] = $this->Html->url('/img/uploads/' . $image);
		$link['full'] = '<a href="' . $link['url'] . '">' . __('Larger image', true) . '</a>';    
		return $link;
	}



/*
 * test thumbnail size againts the larger image size TODO
 * 
 */

	public function _ThumbnailSize($image, $thumbWidth, $thumbHeight) {
		$dimension = $this->_imageSize($image);
		
		if ($dimension['height'] > $thumbHeight || $dimension['width'] > $thumbWidth) {
			return true;
		}
		return false;
	}

/*
 * test thumbnail size againts the larger image size TODO
 * 
 */

	private function _imageSize($image) {
		$size = getimagesize($image);
		$dimension['width'] = $size[0];
		$dimension['height'] = $size[1];
		return $dimension;
	}


}
?>