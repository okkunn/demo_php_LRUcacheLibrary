<?php

class GetImage {
	
	protected $dir = '/../public_html/img/';
	
	protected $imgType = array (
		1 => 'image/jpeg',
		2 => 'image/png',
		3 => 'image/gif',
	);

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
				if( is_file( $dir . $fileName ) && array_search( mime_content_type($dir.$fileName), $this->imgType ) ){
					$imgArray[] = $fileName;
				}
			}
			closedir($handle);
		return $imgArray;
	}
}