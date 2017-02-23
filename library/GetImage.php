<?php

require_once( dirname(__FILE__) . '/../etc/config.php' );

class GetImage {
	
	public function __construct()
	{
		$this->config = getConfig();
	}
	
	public function getImgData()
	{
		// imageFile
		$imgArray = array();
		$dir = dirname(__FILE__) . $this->config['imgPath'];
		
		$handle = opendir( $dir );
		while ( false !== ( $fileName = readdir( $handle ) ) ) {
			if( is_file( $dir . $fileName ) && array_search( mime_content_type($dir.$fileName), $this->config['imgType'] ) ){
				$imgArray[] = $fileName;
			}
		}
		closedir($handle);
		
		return $imgArray;
	}
}