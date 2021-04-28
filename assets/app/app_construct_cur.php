<?php
function app_core_construct(){
	
	$settingsData = $GLOBALS['settingsData'];
	$configData = $GLOBALS['configData'];
	$pageData = $GLOBALS['pageData'];
	$headerData = $GLOBALS['headerData'];
	$footerData = $GLOBALS['footerData'];
	$elementDefData = $GLOBALS['elementDefData'];
	
	if($settingsData && $configData && $pageData && $headerData && $footerData){
		echo '<!doctype html>';

		// HTML
		if (array_key_exists("language",$settingsData)) {
			echo '<html lan="' . $settingsData[ "language" ] . '"';
			if (array_key_exists("direction",$settingsData)) {
					echo ' dir="' . $settingsData[ "direction" ] . '">';
			} else {
					echo '>';
			}
		} else {
            echo '<html>';
		}

			// Head
			create_head();

			// Body
			create_body();

		echo '</html>';
	}
	
}
?>