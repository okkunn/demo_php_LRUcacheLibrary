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
		sleep(5);
	}
}


$objImg = new GetImage();
$imgArray = $objImg->getImgData();
$config = getConfig();
$num = $config['cacheNum'];

$start = microtime(true);

$imgThread = new ImgThread( $imgArray, $num );
$imgThread->start();

// cache get
$imgThread->join();
$newImageArray = $imgThread->img;


var_dump(microtime(true) - $start);
var_dump($newImageArray);exit;


