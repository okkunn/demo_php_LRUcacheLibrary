<?php


function getConfig() {
	$config = array(
		'cacheNum' => 10,
		'imgType'  => array (
			1 => 'image/jpeg',
			2 => 'image/png',
			3 => 'image/gif',
		),
		'imgPath' => '/../public_html/img/',
	);
	
	
	return $config;
}