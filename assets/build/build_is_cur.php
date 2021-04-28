<?php
function is_valid_class($class){
	$nValid = [];
	if(in_array($class, $nValid, true)){
		return false;
	}else{
		return true;
	}
}
?>