<?php
class datafile	{

	public $dFile;
	
	function __constructor($sFile = NULL)
	{
	
		$this -> dFile = $sFile;
		
	}
	
	public function get()
	{
		
		$root = $GLOBALS["rootDir"];
		$settings = isset($GLOBALS["settingsData"]) ? $GLOBALS["settingsData"] : NULL;
		$file = $this -> dFile;
		
		$Url = "";
		
		if($root && $file && $settings)
		{

			$directory = isset($settings["application"]["data"]["directory"]) ? $settings["application"]["data"]["directory"] : false;
			$version = isset($settings["application"]["data"]["version"]) ? $settings["application"]["data"]["version"] : false;
			$extension = isset($settings["application"]["data"]["extension"]) ? $settings["application"]["data"]["extension"] : false;
			$tfile = $file.$version.$extension;
			//print_r($tfile);

			//$Url .= $root;
			$Url .= $directory."/";
			$Url .= $tfile;
			print_r($Url);
			$Data = file_get_contents($Url);
			$Json = json_decode($Data, true);
			
			return $Json;

		}
		
	}
}
?>