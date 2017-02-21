<?php

class GetImage {
	
	protected $num = 10;
	
	protected $dir = '/../public_html/img/';

	public function __construct()
	{
	}
	
	public function getImgData()
	{
		// imageFile
		$imgArray = array();
		$dir = dirname(__FILE__) . $this->dir;
		
			$handle = opendir( $dir );
			while ( false !== ( $fileName = readdir( $handle ) ) ) {
				if( is_file( $dir . $fileName ) ){
					$imgArray[] = $fileName;
				}
			}
			closedir($handle);
		
		return $imgArray;
	}
}