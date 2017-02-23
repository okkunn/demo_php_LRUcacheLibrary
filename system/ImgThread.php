<?php

require_once( dirname(__FILE__) . '/../library/LruCache.php' );
require_once( dirname(__FILE__) . '/../library/GetImage.php' );

class ImgThread extends Thread {
	public function __construct( $imgArray )
	{
		$this->imgArray = $imgArray;
	}
	
	public function run () {
		$lru = new LruCache( 11 );
		foreach ( $this->imgArray as $key => $name ) {
			$lru->put($key, $name);
		}
		$this->img = $lru->get( 0 );
		sleep(5);
	}
}


$objImg = new GetImage();
$imgArray = $objImg->getImgData();

$start = microtime(true);

$imgThread = new ImgThread( $imgArray );
$imgThread->start();

// cache get
$imgThread->join();
$newImageArray = $imgThread->img;


var_dump(microtime(true) - $start);
var_dump($newImageArray);exit;


