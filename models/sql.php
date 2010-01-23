<?php
class Sql extends AppModel {
	public $useTable = false;

/**
 * strip the sql comment lines out of an uploaded sql file.
 * Originally from Coppermine Picture Gallery http://coppermine.sf.net
 */

	public function removeRemarks($sql) {
		$lines= explode("\n", $sql);
		$sql= "";
		$linecount= count($lines);
		$output= "";
		for ($i= 0; $i < $linecount; $i++) {
			if (($i != ($linecount -1)) || (strlen($lines[$i]) > 0)) {
				if (isset ($lines[$i][0]) && $lines[$i][0] != "#") {
					$output .= $lines[$i] . "\n";
				} else {
					$output .= "\n";
				}
				$lines[$i]= "";
			}
		}
		return $output;
	}


/**
 * Split up our string into "possible" SQL statements.
 */

	public function splitSqlFile($sql, $delimiter) {
		$tokens= explode($delimiter, $sql);
		$sql= "";
		$output = array ();
		$matches = array ();
		$token_count = count($tokens);
		for ($i= 0; $i < $token_count; $i++) {
			if (($i != ($token_count -1)) || (strlen($tokens[$i] > 0))) {
			$total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
			$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
	
			$unescaped_quotes= $total_quotes - $escaped_quotes;
			if (($unescaped_quotes % 2) == 0) {
				$output[] = $tokens[$i];
				$tokens[$i] = "";
			} else {
				$temp = $tokens[$i] . $delimiter;
				$tokens[$i]= "";
				$complete_stmt= false;
	
				for ($j= $i +1;(!$complete_stmt && ($j < $token_count)); $j++) {
				$total_quotes= preg_match_all("/'/", $tokens[$j], $matches);
				$escaped_quotes= preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
	
				$unescaped_quotes= $total_quotes - $escaped_quotes;
	
				if (($unescaped_quotes % 2) == 1) {
					$output[] = $temp . $tokens[$j];
					$tokens[$j] = "";
					$temp= "";
					$complete_stmt= true;
					$i= $j;
				} else {
					$temp .= $tokens[$j] . $delimiter;
					$tokens[$j]= "";
				}
				}
			}
			}
		}
    return $output;
	}

/**
 *
 */

	public function executeSqlFiles($files = array(), $path) {
		App::import('Model', 'ConnectionManager');
		$db = & ConnectionManager :: getDataSource('default');
		foreach ($files as $row) {
			$sqlFile = $path . $row . '.sql';
			$sql = file_get_contents($sqlFile);
			$sql = $this->removeRemarks($sql);
			$sql = $this->splitSqlFile($sql, ';');
			foreach ($sql as $q) {
				$q = str_replace("bs_", $db->config['prefix'], $q);
				$db->query($q);
			}
		}
	}


}
?>