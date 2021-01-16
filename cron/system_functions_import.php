<?php

function clear_cache($cache_areas = false) {
	global $mcache;

	if ( $mcache ) {

		memcache_flush($mcache);

	} else {

		if ( $cache_areas ) {
			if(!is_array($cache_areas)) {
				$cache_areas = array($cache_areas);
			}
		}

		$fdir = opendir( ENGINE_DIR . '/cache' );

		while ( $file = readdir( $fdir ) ) {
			if( $file != '.' and $file != '..' and $file != '.htaccess' and $file != 'system' ) {

				if( $cache_areas ) {

					foreach($cache_areas as $cache_area) if( strpos( $file, $cache_area ) !== false ) @unlink( ENGINE_DIR . '/cache/' . $file );

				} else {

					@unlink( ENGINE_DIR . '/cache/' . $file );

				}
			}
		}
	}
}

function convert_unicode($t, $to = 'windows-1251') {

	$to = strtolower( $to );

	if( $to == 'utf-8' ) {

		return $t;

	} else {

		if( function_exists( 'mb_convert_encoding' ) ) {

			$t = mb_convert_encoding( $t, $to, "UTF-8" );

		} elseif( function_exists( 'iconv' ) ) {

			$t = iconv( "UTF-8", $to . "//IGNORE", $t );

		} else $t = "The library iconv AND mbstring is not supported by your server";

	}

	return $t;
}


?>