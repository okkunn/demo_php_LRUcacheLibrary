<?php

require_once( dirname(__FILE__) . '/../library/LruCache.php' );
require_once( dirname(__FILE__) . '/../library/GetImage.php' );

class ImgThread extends Thread {
	public function __construct($key, $name)
	{
		$this->key = $key;
		$this->name = $name;
	}
	
	public function run () {
		$lru = new LruCache(1);
		$lru->put($this->key, $this->name);
		$this->img = $lru->get( $this->key );
		
		sleep(5);
	}
}


$objImg = new GetImage();
$imgArray = $objImg->getImgData();

$start = microtime(true);

// cache put
foreach ( $imgArray as $key => $name ) {
	$imgThread[$key] = new ImgThread($key, $name);
	$imgThread[$key]->start();
}

// cache get
foreach ( $imgArray as $key => $name ) {
	$imgThread[$key]->join();
	$newImageArray[] = $imgThread[$key]->img;
}

var_dump(microtime(true) - $start);
var_dump($newImageArray);exit;


