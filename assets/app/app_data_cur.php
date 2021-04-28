<?php
function app_core_data(){
	
	// Settings Data
	if(isset($GLOBALS['settingsData']) && $GLOBALS['settingsData']==""){

		include "app_data_settings_cur.php";

	}

	// Config Data
	if(isset($GLOBALS['configData']) && $GLOBALS['configData']==""){

		include "app_data_config_cur.php";

	}
	
	// Email Data
	if(isset($GLOBALS['emailData']) && $GLOBALS['emailData']==""){

		include "app_data_email_cur.php";

	}

	// Header Data
	if(isset($GLOBALS['headerData']) && $GLOBALS['headerData']==""){

		include "app_data_header_cur.php";

	}
	
	// Page Data
	if(isset($GLOBALS['pageData']) && $GLOBALS['pageData']==""){

		include "app_data_page_cur.php";

	}

	// Element Definitions
	if(isset($GLOBALS['elementDefData']) && $GLOBALS['elementDefData']==""){

		include "app_data_definitions_cur.php";

	}

	// Footer Data
	if(isset($GLOBALS['footerData']) && $GLOBALS['footerData']==""){

		include "app_data_footer_cur.php";

	}

	if(isset($GLOBALS['pageName']) && isset($GLOBALS['settingsData']) && isset($GLOBALS['configData']) && isset($GLOBALS['emailData']) && isset($GLOBALS['headerData']) && isset($GLOBALS['pageData']) && isset($GLOBALS['elementDefData']) && isset($GLOBALS['footerData'])){
		
		app_core_construct();
		
	}
	
}
app_core_data();
?>