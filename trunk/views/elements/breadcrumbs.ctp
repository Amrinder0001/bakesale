<?php if($this->params['action'] != 'display') { ?>
<div id="breadcrumbs">
<?php
	$html->addCrumb(__('Homepage', true), "/");
	if(isset($breadcrumbs)) {
    if($this->params['controller'] == 'categories') {
    	unset($breadcrumbs[count($breadcrumbs)-1]);
    }
    foreach($breadcrumbs as $row) {
    	if(isset($this->params['prefix'])) {
        $url = $html->url(array('controller' => 'categories', 'action' => 'show', 'id' => $row['Category']['id']));
    	} else {
        $url = $seo->url($row['Category'], 'categories');
    	}
    	$url = str_replace(Configure::read('App.dir'), '', $url);
    	$html->addCrumb($row['Category']['name'], $url);
    }
	}
	if(!empty($this->pageTitleStart)) {
    $html->addCrumb('<strong>' . $this->pageTitleStart . '</strong>');
	}
	echo $html->getCrumbs();
?></div>
<?php } ?>