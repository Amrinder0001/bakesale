<?php
class SearchComponent extends Object
{
	public $controller; 

/*
 * Build and execute search query
 */
	
    public function query(&$model, $keywords, $searchFields, $multipleKeywords = 0, $matchType = 0, $fields = '*', $limit = 50, $page = 1, $order = false)
    {        
    $modelName = explode('.', $searchFields[0]);

        $conditions = "(";
        
        $keywords = explode(' ', $keywords);
        $keyCount = count($keywords);
        
        for($k = 0; $k < $keyCount; $k++)
        {
        
    	for($i=0; $i < count($searchFields); $i++)
    	{
        $searchField = $searchFields[$i];
        
        switch ($matchType) 
        {
        case ANYWHERE:
        	$conditions .= "$searchField LIKE '%$keywords[$k]%'";   
        	break;
        case EXACT:
        	$conditions .= "$searchField = '$keywords[$k]'";   
        	break;
        case ENDS_WITH:
        	$conditions .= "$searchFields LIKE '%$keywords[$k]'";   
        	break;
        case STARTS_WITH:
        	$conditions .= "$searchField LIKE '$keywords[$k]%'";   
        	break;
        }
        
        if ($i < count($searchFields)-1 )
        {
        	$conditions .= " OR ";
            }
        
        }
        
        if ($k < $keyCount-1 )
    	{
        
        switch ($multipleKeywords) 
        {
        case ANY:
        	$conditions .= ") OR (";
        	break;
        case ALL:
        	$conditions .= ") AND ("; 
        	break;
        }
        }
        else
        {
            $conditions .= ')';
        }
        }
    $model->recursive = 1;
    $extra = '';
    if($modelName[0] != 'Order') {
    	$extra = ' and ' . $modelName[0] . '.active = 1';
    }
    return $model->findAll($conditions . $extra, $fields, $order, $limit, $page);
	}
}
?>
