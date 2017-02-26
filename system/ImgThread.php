<?php

require_once( dirname(__FILE__) . '/../library/LruCache.php' );
require_once( dirname(__FILE__) . '/../library/GetImage.php' );
require_once( dirname(__FILE__) . '/../etc/config.php' );

class ImgThread extends Thread {
	public function __construct( $imgArray, $num )
	{
		$this->imgArray = $imgArray;
		$this->num = $num;
	}
	
	public function run () {
		$lru = new LruCache( $this->num );
		foreach ( $this->imgArray as $key => $name ) {
			$lru->put($key, $name);
		}
		$this->img = $lru->get( 0 );
		sleep(10);
	}
}


$objImg = new GetImage();
$imgArray = $objImg->getImgData();
$config = getConfig();
$num = $config['cacheNum'];


foreach ( $imgArray as $key => $value ) {
	$imgThread[$key] = new ImgThread( $value, $num );
	// cache put
	$imgThread[$key]->start();
}
$start = microtime(true);

foreach ( $imgArray as $key => $value ) {
	// cache get
	$imgThread[$key]->join();
	$newImage = $imgThread[$key]->img;
	var_dump($newImage);
}

var_dump(microtime(true) - $start);
exit;


