<?php

	Configure::write('debug', 1);

	Configure::write('App.encoding', 'UTF-8');

	Configure::write('Routing.prefixes', array('admin'));

	Configure::write('Cache.disable', true);

	Configure::write('Cache.check', false);

	define('LOG_ERROR', 2);

	Configure::write('Session.save', 'php');

	Configure::write('Session.table', 'cake_sessions');

	Configure::write('Session.database', 'default');

	Configure::write('Session.cookie', 'CAKEPHP');

	Configure::write('Session.timeout', '1200');

	Configure::write('Session.start', true);

	Configure::write('Session.checkAgent', true);

	Configure::write('Security.level', 'low');

	Configure::write('Security.salt', 'BshG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi');

	Configure::write('Security.cipher_seed', '1303799309657453542496749683645');

  	Cache::config('default', array(
 		'engine' => 'Memcache', //[required]
 		'duration'=> 3600, //[optional]
 		'probability'=> 100, //[optional]
  		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
  		'servers' => array(
  			'127.0.0.1:11211' // localhost, default port 11211
  		), //[optional]
  		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
 	));
?>