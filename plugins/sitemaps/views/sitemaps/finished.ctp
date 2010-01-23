<h1><?php __('Sitemap created'); ?></h1>
<p><?php __('Submit your sitemap:');?> </p>
<ul>
    <li><a href="http://www.google.com/webmasters/sitemaps/ping?sitemap=<?php echo $sitemap_url; ?>">Google</a></li>
    <li><a href="http://www.yahoo.com/ping?sitemap=<?php echo $sitemap_url; ?>">Yahoo</a></li>
    <li><a href="http://api.moreover.com/ping?u=<?php echo $sitemap_url; ?>">MSN</a></li>
</ul>
