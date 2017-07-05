<?php


class versao{

	public function auto_version($file) {
		if( !file_exists($file) ){
			return $file;
		}
		$mtime = filemtime($file);
		return $file."?v=" . $mtime;
	}



}