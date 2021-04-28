<?php
$compInc = 0;
$artInc = 0;

function create_meta ($sData = NULL)
{

	$DATA = $sData;
	
	if($DATA){
	
		$TYPE = get_data_type($DATA);
		
		if($TYPE === "array"){
		
			$LENGTH = get_data_count($DATA);

			$gElemDefData = $GLOBALS[ "elementDefData" ];
			
			for($i=0;$i<$LENGTH;$i++){
			
				$ITEM_DATA = $DATA[$i];
				echo '<meta';
					set_attributes($ITEM_DATA['attributes']);
				echo '/>';
			
			}
		}
	}

}
function create_styles ($sData = NULL)
{

	$DATA = $sData;
	if($DATA){
	
		$TYPE = get_data_type($DATA);
		
		if($TYPE === "array"){
		
			$LENGTH = get_data_count($DATA);

			$gElemDefData = $GLOBALS[ "elementDefData" ];
			
			for($i=0;$i<$LENGTH;$i++){
			
				$ITEM_DATA = $DATA[$i];
				echo '<link';
					set_attributes($ITEM_DATA['attributes']);
				echo '/>';
			
			}
		}
	}
}
function create_scripts ($sData = NULL)
{

	$DATA = $sData;
	if($DATA){
	
		$TYPE = gettype($DATA);
		
		if($TYPE === "array"){
		
			$LENGTH = count($DATA);

			$gElemDefData = $GLOBALS[ "elementDefData" ];
			
			for($i=0;$i<$LENGTH;$i++){
			
				$ITEM_DATA = $DATA[$i];
				echo '<script';
					set_attributes($ITEM_DATA['attributes']);
				echo '></script>';
			
			}
		}
	}
}

function create_footer()
{
	
	$fData = $GLOBALS["footerData"];
	
	$element = 'footer';
	
	if ($fData) {

		$footer = new block();
		$footer -> data = $fData;
		$footer -> element = $element;
		
		$footer -> open();

		
		$footer -> close();
	}
	

}
function create_main()
{

	$data = $GLOBALS["pageData"];
	
	$element = 'main';
	
	if ($data) {

		$main = new block();
		$main -> data = $data;
		$main -> element = $element;
		
		$main -> open();
 		$main -> title();
		$main -> content();
		$main -> close();
	}

}
function create_data()
{
	$usrid = $_SESSION["LOGGEDIN"];
	$usrData = NULL;
	$demData = NULL;
	$intData = NULL;
	
	if($usrid)
	{
		
		$udata = new block();
        $udata -> element = "script";	
        $udata -> open();
        
			//echo '/* USER DATA */'."\n";
			//echo 'let USERID="'.$usrid.'";'."\n";

			$jsdata = NULL;
			
			$myDBaccess = new access_db();

			$usrData = $_SESSION["USERDATA"];
			if($usrData)
			{
				echo '/* USER DATA */'."\n";
				echo 'let usr_data = '.json_encode($usrData).';'."\n";//,JSON_PRETTY_PRINT
			}	
			
			$intData = $myDBaccess -> getIntData($usrData["int_id"]);
			if($intData)
			{
				echo '/* INSTITUTION DATA */'."\n";
				echo 'let int_data = '.json_encode($intData).'\n';

			}
			
			$demData = $myDBaccess -> getDemData($usrData["usr_id"]);
			if($demData)
			{
				echo '/* DEMOGRAPHICS DATA */'."\n";
				echo 'let dem_data = '.json_encode($demData).'\n';

			}
			
			$proData = $myDBaccess -> getProData($usrData["pro_ids"]);
			if($proData)
			{
				echo '/* PROJECT DATA */'."\n";
				echo 'let pro_data = '.json_encode($proData).'\n';

			}
			/*
			*/
 
		$udata -> close();
		
	}

}
function create_header()
{

	$hData = $GLOBALS["headerData"];
	
	$element = 'header';
	
	if ($hData) {

		$header = new block;
		$header -> data = $hData;
		$header -> element = $element;
		
		$header -> open();
		
		
		$header -> close();
	}

}
function create_body()
{

	$hData = $GLOBALS["headerData"];
	$pData = $GLOBALS["pageData"];
	$fData = $GLOBALS["footerData"];
	$attributes = $pData["attributes"];
	
	$element = "body";
	
	if ($hData and $pData and $fData) {

		$body = new block();
		$body -> data = $pData;
		$body -> element = $element;
		
		$body -> open();
		
			if($GLOBALS["pageName"]=="profile")
			{
				
				create_data();
				
			}
		
			create_header();
			create_main();
			create_footer();
			
		$body -> close();
		
	}

}
function create_head_title($sData = NULL,$pData = NULL)
{

	$sTitle = get_value( $sData, "title" );
	$aCountry = get_value( $sData, "country" );
	$pTitle = get_value( $pData, "name" );

	if ( $sTitle and $aCountry and $pTitle ) {
		$pageTitle = $pTitle . ' - ' . $sTitle . ' | ' . $aCountry ;
		//create_object("title", $pageTitle) ;
	}

}
function create_head()
{
	
	$sData = $GLOBALS["settingsData"];
	$aData = $GLOBALS["configData"];
	$hData = $GLOBALS["headerData"];
	$pData = $GLOBALS["pageData"];
	$fData = $GLOBALS["footerData"];
	$eDef = $GLOBALS["elementDefData"];
	
	if($aData
		and $pData
	){
		
		echo '<head>';
		
		$TRACKING = get_value($aData,"track");
		if ($TRACKING) {
			create_scripts($TRACKING);
		}
		
		$META = get_value($aData,"meta");
		if ($META) {
			create_meta($META);
		}
		
		create_head_title($sData,$pData);
		
		$META = get_value($pData,"meta");
		if ($META) {
			create_meta($META);
		}
		
		$STYLES = get_value($aData,"styles");
		if ($STYLES) {
			create_styles($STYLES);
		}
		
		$SCRIPTS = get_value($aData,"scripts");
		if ($SCRIPTS) {
			create_scripts($SCRIPTS);
		}
		
		echo '</head>';
	
	}

}
?>