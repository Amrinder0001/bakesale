<?php echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'."\n"; ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
	if(!empty($data)) { 
    foreach ($data as $key => $row){
    	foreach ($row as $key2 => $row2){
        foreach ($row2 as $key3 => $row3){
        	$model = $key3;
        	$controller =  strtolower(Inflector::pluralize($model));
        }
        ?>
	<url>
    <loc><?php echo FULL_BASE_URL . $seo->url($row2[$model], $controller) ?></loc>
    <lastmod><?php echo $time->toAtom($row2[$model]['modified']); ?></lastmod>
	</url> 

        <?php
        //debug($row2);
    	}
    } 
	} 
?>
  </urlset>