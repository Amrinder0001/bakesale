<?php

/**
 */

class  Installer extends InstallerAppModel {
    public $useTable = false;



/*
 * Detect if we are in installation
 */
 
	private function shouldNotExist() {
		$arrErrors = array();
		$files = array(
			CONFIGS . 'database.php', 
			CONFIGS . 'storefronts' . DS . 'bakesale_config.php'
		);
		foreach($files as $key => $row) {
			if(is_file($row)) {
			$arrErrors[$key]['message'] = 'Warning: ' . $row . ' exists';
			$arrErrors[$key]['solution'] = 'Solution: delete file ' . $row . '';
			}
		}
		return $arrErrors;
	}

/**
 * Copy demo products directory to webroot
 */

	public function copyDemoproductImages() {
		uses ('folder');
		$path = APP . 'webroot'  . DS . 'img' . DS . 'uploads' . DS;
		$folder = &new Folder($path);
		@$folder->delete($path);
			
		$backup = APP . 'docs'  . DS . 'uploads' . DS;
		$folder = &new Folder($backup);
		@$folder->copy($path);
	}
	
/**
 *  Write configuration file
 */
 
	public function writeConfigFile() {
		$configFile = CONFIGS . 'core.php';
		$fh = fopen($configFile, 'r');
		$theData = fread($fh, filesize($configFile));
		fclose($fh);
		
		$theData = str_replace("'debug', 1", "'debug', 0", $theData);
		$theData = str_replace("'Cache.disable', true", "'Cache.disable', false", $theData);
		$newData = str_replace("'Cache.check', false", "'Cache.check', true", $theData);
		
		$fh2 = fopen($configFile, 'w');
		fwrite($fh2, $newData);
		fclose($fh2);
		
		clearCache();
	}

/**
 * Write database configuration file
 */

	public function generateDatabaseFile($data) {
		$text = $this->buildCfgFile($data);
		ClassRegistry::init('FileManipulator')->writeFile($text, CONFIGS . 'database.php');
	}	

/**
 * Run SQL text files required for installation
 */

	public function runInstallSql($data) {
		$sqlFiles = array('bakesale', 'essentials');
			
		if($data['Import']['demoproducts'] == 1) {
			$sqlFiles = array_merge($sqlFiles, array('demo_products'));
			$this->copyDemoproductImages();
		}
		ClassRegistry::init('Sql')->executeSqlFiles($sqlFiles, APP . 'docs' . DS . 'sql' . DS);
	}

/**
 * Write app configuration file to server
 */

	public function buildCfgFile($data) {
    
return<<<EOT
<?php
class DATABASE_CONFIG
{
	 var \$default = array('driver' => 'mysql',
               'connect' => 'mysql_connect',
               'host' => '{$data['database_server']}',
               'login' => '{$data['database_user']}',
               'password' => '{$data['database_password']}',
               'database' => '{$data['database_name']}',
               'prefix' => '{$data['table_prefix']}');


}
?>
EOT;
	}


}
?>