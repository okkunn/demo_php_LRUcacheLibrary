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
		
		$subDir = new DirectoryIterator( $dir );
		
		foreach ($subDir as $key => $value) {
			$file = str_replace( $dir, '', $value->getPathname() );
			if( $file != '.' && $file != '..' && $file != '.gitkeep' ) {
				$dirArray[] = dirname(__FILE__) . $this->config['imgPath'] . $file;
			}
		}
		
		foreach ($dirArray as $key => $value) {
			$handle = opendir( $value );
			while ( false !== ( $fileName = readdir( $handle ) ) ) {
				if( is_file( $value  . '/' . $fileName ) && array_search( mime_content_type($value . '/' . $fileName), $this->config['imgType'] ) ){
					$imgArray[$key][] = $fileName;
				}
			}
		}
		closedir($handle);

		return $imgArray;
	}
}