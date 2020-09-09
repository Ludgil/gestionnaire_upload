<?php 

function normalize_filename($file){
	//remplacer les accents par des lettres sans accents
	$accent = array('ç','æ','œ','á','é','í','ó','ú','à','è','ì','ò','ù','ä','ë','ï','ö','ü','ÿ','â','ê','î','ô','û','å','ø');
	$without_accent = array('c','ae','oe','a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','y','a','e','i','o','u','a','o');
	$new_name_file = str_replace($accent, $without_accent, $file);
	//trim + mise en minuscule 
	$new_name_file = strtolower(trim($new_name_file));
	// remplacer les espaces par des -
	$new_name_file = str_replace(' ', '', $new_name_file);
	// // suppression des caractéres spéciaux
	$new_name_file = preg_replace('/[^A-Za-z0-9\-]/', '', $new_name_file);
	return $new_name_file;

}

function niceArrayForFile($arr) {
	//réarrange le tableau contenant les fichiers 
		foreach( $arr as $key => $all ){
			foreach( $all as $i => $val ){
				$new[$i][$key] = $val;   
			}   
		}
		return $new;
}

