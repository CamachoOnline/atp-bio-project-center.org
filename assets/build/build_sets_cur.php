<?php
function set_classes($Array){
	
	$Length = get_data_count($Array);
	
	if($Array && $Length > 0){
		
		$aData = $GLOBALS[ "configData" ];
		$pData = $GLOBALS[ "pageData" ];
		
		$cPrefix = get_value($aData,"classpre");
		$jPrefix = get_value($aData,"jspre");
		
		$myClasses = "";
		
		for($i = 0; $i < $Length; $i++){
		
			$class = $Array[$i];
			if($class){
				if($cPrefix){
					$myClasses .= $cPrefix.$class; 
				}else{
					$myClasses .= $class;
				}
				
				if($jPrefix){
					$myClasses .= " ";
					$myClasses .= $jPrefix.$class;
				}

			}else{
				if($i === 0){
					$myClasses .= $cPrefix;
					$myClasses .= " ";
					$myClasses .= $jPrefix;
				}
			
			}
			if($i < ($Length-1)){
				$myClasses .= " ";
			}
		}
		
		return $myClasses;
		
	}
	
}
function set_code($Data){

	$Length = get_data_count($Data);
	
	if($Data){

		for($i = 0; $i < $Length; $i++){
			
			$comment = get_value($Data[$i],"comment");
			$syntax = get_value($Data[$i],"syntax");
			
			if($comment and  get_data_type($comment ) === "string" ){
				
				echo '/* ' . $comment . '*/';
				
			}
			
			if($syntax and get_data_type($syntax ) === "object"){
				
				
				
			}
			
		}
		
	}
	
}
function set_attributes ($Data = NULL, $Tag = NULL, $Type = NULL){

	$Length = get_data_count($Data);
	
	$aData = $GLOBALS[ "configData" ];
	$pData = $GLOBALS[ "pageData" ];
	$eData = $GLOBALS["elementDefData"];
	
	if($Data){
		
		for($i = 0; $i < $Length; $i++){
			
			$name = get_value($Data[$i],"name");
			$value = get_value($Data[$i],"value");
			
			if($name){
				
				if($i != $Length){
				
					echo " ";

				}
				
				echo $name;
				
				echo '="';
			
			}
			

			// Classes
			if($name == "class"){
				if($value){
					
					$aData = get_value($eData,$Tag);
					$tAttr = get_value($aData,"attributes");
					$eClasses = get_element_class ($tAttr);
					$tClasses = $value;

					
					$nClass = NULL;
					if($eClasses and $tClasses and $Tag != "body" and $Tag != "div"){
						$nClass = combine_arrays([$eClasses,$tClasses]);
					}else if($eClasses){
						if($Type){
							$nClass = combine_arrays([$eClasses,["block-".$Type]]);
						}else{
							$nClass = $eClasses;
						}
					}
					if($nClass){
						echo set_classes($nClass);
					}
				}

			}else{

				echo $value;

			}

			echo '"'; 

		}
		
	}else{
		if($Tag and !$Type){
		
			$aData = get_value($eData,$Tag);
			$tAttr = get_value($aData,"attributes");
			$eClasses = get_element_class ($tAttr);
			
			if($aData and $tAttr and $eClasses){
			
				echo ' class="';
				
					echo set_classes($eClasses);
					
				echo '"';
				
			}
		}
	
	}
	
}
?>
