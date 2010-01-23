<h1><?php echo $this->pageTitle = __('Page not found (404)', true); ?></h1>
<?php $this->layout = 'shop'; ?>
<?php 
$this->requestAction('/contents/show/6/blank');

$url = $_SERVER['REQUEST_URI'];

if(strstr($url, '.html')) {
	Configure::write('debug', '1');
	$urlArray = explode("-", $url);
	$arrayCount = count($urlArray);
	$controller = controller($urlArray[$arrayCount - 2]);
	$id = str_replace(".html", "", $urlArray[$arrayCount - 1]);
	$replaced = array('-' . $urlArray[$arrayCount - 2] . '-', $id . '.html');
	$myvar = str_replace($replaced, "", $url);
	$url =  '/' . $myvar . '/' . $urlArray[$arrayCount - 2] . '/' . $id;
	$url = str_replace('//', '/', $url);
	$url = str_replace('/a/', '/con/', $url);
	$url = str_replace('/t/', '/ccon/', $url);
	$url = 'http://' . $_SERVER['HTTP_HOST'] . $url;
	header("HTTP/1.1 301 Moved Permanently");
	header("Location:  $url");
	exit();
}

function controller($url) {
	$controllers = array('p' => 'products', 'c' => 'categories', 'a' => 'contents');
	return $controllers[$url];
}

?>
