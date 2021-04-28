<?php
function combine_arrays($arrays = NULL){

	if(is_array($arrays)){
		
		$Length = get_data_count($arrays);
		
		$output =[];
		for($i = 0; $i < $Length; $i++){
			
			$iData = $arrays[$i];
			
			$iLength = get_data_count($iData);
			
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
?>