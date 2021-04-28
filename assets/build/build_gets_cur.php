<?php
function get_articles($data = NULL){

	$aData = $GLOBALS["configData"];
	$hData = $GLOBALS["headerData"];
	$pData = $GLOBALS["pageData"];
	$fData = $GLOBALS["footerData"];
	
	$pDef = $GLOBALS["pageDefData"];
	$cDef = $GLOBALS["compDefData"];
	$eDef = $GLOBALS["elementDefData"];

	if ($data and $pData and $aData and $eDef) {

		$Length = get_data_count($data);
		$articles = [];

		for ($i = 0; $i < $Length; $i++) {

			$file = get_value($data[$i], "file");
			
			if ($file) {
			
				$articleFile = get_filepath("/assets/build/data/articles/" . $file);
				$articleData = get_data($articleFile);

				if ( $articleData ) {
					array_push($articles, $articleData);
				}
			}

		}
		
		return $articles;
		
	}

}
function get_components($data = NULL){

	$aData = $GLOBALS["configData"];
	$hData = $GLOBALS["headerData"];
	$pData = $GLOBALS["pageData"];
	$fData = $GLOBALS["footerData"];
	
	$pDef = $GLOBALS["pageDefData"];
	$cDef = $GLOBALS["compDefData"];
	$eDef = $GLOBALS["elementDefData"];

	if ($data and $pData and $aData and $eDef) {

		$Length = get_data_count($data);
		$components = [];

		for ($i = 0; $i < $Length; $i++) {

			$file = get_value($data[$i], "file");
			
			if ($file) {
			
				$componentFile = get_filepath("/assets/build/data/components/cmp_" . $file);
				$componentData = get_data($componentFile);

				if ( $componentData ) {
					array_push($components, $componentData);
				}
			}

		}
		
		return $components;
		
	}

}
function get_element_class($eData = NULL){
	$Data = $eData;
	$output = NULL;
	if($Data and get_data_type($Data)==="array"){
		
		$Length = get_data_count($Data);
		for($i = 0; $i < $Length; $i++){
			
			$Attribute = $Data[$i];
			$Name = get_value($Attribute, "name");
			$Value = get_value($Attribute, "value");
			if($Name === "class"){
				
				$output = $Value;
			
			}
		
		}
	
	}
	if($output){
		return $output;
	}else{
		return false;
	}
}
function get_value($Obj = NULL, $Name = NULL){
	if($Obj and $Name){
		$type = get_data_type($Obj);
		if($type === "object" or $type === "array"){
			if(array_key_exists($Name,$Obj)){
				return $Obj[$Name];
			}else{
				return false;
			}
		}
	}else{
		return false;
	}
}
function get_data_type($Obj = NULL) {
		//return gettype($Obj);
		if(is_array($Obj)){
			return "array";
		}else if(is_string($Obj)){
			return "string";
		}else{
			return "object";
		}
}
function get_data_count($Obj = NULL) {
		return count($Obj);
}
function get_data($File = NULL){
	if($File){
		$Data = file_get_contents($File);
		if($Data){
			$Json = json_decode($Data, true);
			return $Json;
		}else{
			return false;
		}
	}
}
function get_filepath($path = NULL){
	$root = $GLOBALS[ "rootDir" ];
	$aData = $GLOBALS[ "configData" ];
	return $root.$path. $aData["version"] . $aData["extension"];
}
?>