<?php
class arrays {

	public $arrays;
	
	function __constructor($arrays) {

		$this->arrays = $arrays;
		
	}
	
	function combine(){
		
		$aArray = $this->arrays;
		
		if(is_array($aArray)){
			
			$Length = count($aArray);

			$output =[];
			for($i = 0; $i < $Length; $i++){

				$iData = $aArray[$i];

				$iLength = count($iData);

				if($iData){

					for($j = 0; $j < $iLength; $j++){
						$jData = $iData[$j];
						if($jData){
							array_push($output,$jData);
						}


					}
				}
			}
			if($output){
				return $output;
			}else{
				return false;
			}
		}
		
	}

}
?>