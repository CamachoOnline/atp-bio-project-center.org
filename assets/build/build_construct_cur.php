<?php
function construct_body (){

	$aData = $GLOBALS[ "configData" ];
	$pData = $GLOBALS[ "pageData" ];
	$hData = $GLOBALS[ "headerData" ];
	$fData = $GLOBALS[ "footerData" ];
	
	$Element = "body";

	if ( $aData and $pData ) {
		
		echo '<' . $Element;
		
			set_attributes(get_value($aData, "attributes" ));
			
		echo '>';
		
			// Header
			//construct_header();
			create_object($hData, "header");
			
			// Page
			create_object($pData, "main");
			
			// Footer
			create_object($fData, "footer");
		
		echo '</' . $Element . '>';
		
	}
}
function construct_head() {

	$aData = $GLOBALS[ "configData" ];
	$pData = $GLOBALS[ "pageData" ];
	
	$Element = "head";

	if ( $aData and $pData ) {

		echo '<' . $Element . '>';
		
		// HEAD -> TRACK
		$appTracking = get_value($aData,"track");
		if ( $appTracking ) {
			create_object( $appTracking,"script");
		}
		
		// HEAD -> META (site)
		$appMeta = get_value($aData,"meta");
		if ( $appMeta ) {
			create_object($appMeta,"meta");
		}
		
		// HEAD -> TITLE
		$aTitle = get_value( $aData, "title" );
		$aCountry = get_value( $aData, "country" );
		$pTitle = get_value( $pData[0], "name" );
		if ( $aTitle and $aCountry and $pTitle ) {
			$pageTitle = $pTitle . ' - ' . $aTitle . ' | ' . $aCountry ;
			create_object( $pageTitle, "title" ) ;
		}

		// HEAD -> META (page)
		$pageMeta = get_value($pData[0],"meta");
		if ( $pageMeta ) {
			create_object($pageMeta,"meta");
		}
		
		// HEAD -> STYLES
		$appStyles = get_value($aData,"styles");
		if ( $appStyles ) {
			create_object($appStyles,"link");
		}
		$pageStyles = get_value($pData[0],"styles");
		if ( $pageStyles ) {
			create_object($pageStyles,"link");
		}
		
		// Scripts
		$appScripts = get_value($aData,"scripts");
		if ( $appScripts ) {
			create_object($appScripts,"script");
		}
		$pageScripts = get_value($pData[0],"scripts");
		if ( $pageScripts ) {
			create_object($pageScripts,"script");
		}

		echo '</' . $Element . '>';

	}

}
?>