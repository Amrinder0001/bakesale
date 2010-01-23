<?php 
		header("Content-type: text/$filetype; charset: UTF-8"); 
		header("Expires: ".gmdate("D, d M Y H:i:s", time()+315360000)." GMT");
		header("Cache-Control: max-age=315360000");

	function callback($buffer, $filetype = 'Javascript') {
		if($filetype == 'Javascript') {
			$buffer = JSMin::minify($buffer);
		} else {
			$buffer = cssmin::minify($buffer);
		}
		return $buffer;
	}
	

	echo $message;

	foreach($data as $row) {
    if(Configure::read('debug') == 0) {
    	ob_start("callback");
        require_once($row['path'] . $row['file']);
	       $s2 = ob_get_contents();
    	ob_end_clean();
    	echo callback($s2, $filetype);
	   } else {
    	require_once($row['path'] . $row['file']);
	   }
	}

?>