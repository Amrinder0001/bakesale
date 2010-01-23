<?php
class FileManipulator extends AppModel {
	public $useTable = false;

/**
 * Unzip file
 */

	public function unZip($fromFile, $toDir) {
        $zip = new ZipArchive;
    	$zip->open($fromFile);
    	$zip->extractTo($toDir);
    	$zip->close();
	}


/**
 *
 */

	public function writeFile($text, $file) {
		$file_starter = fopen($file, 'w') or die("can't open file");
		fwrite($file_starter, $text);
		fclose($file_starter);
	}

}
?>