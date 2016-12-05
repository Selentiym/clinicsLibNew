<?php
	$images = array_map(function($image){
		$rez = array();
		$curAdr = trim($image);
		if ($curAdr) {
			$rez["addr"] = $curAdr;
			return $rez;
		} else {
			return '';
		}
	}, explode(';', $clinic->pictures));
	$images = array_filter($images, function($im){
		return $im["addr"] ? $im : '';
	});
	//print_r($images);
	
	$this->widget('application.extensions.simpleScroll.scroll',array(
		'images' => $images,
		'baseAddr' =>  $clinic -> giveImageFolderRelativeUrl()
	));//*/
?>