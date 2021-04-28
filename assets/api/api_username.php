<?php
$rootDir = __DIR__;
$file = __FILE__;

/* VARIABLES & ARRAYS */
$settingsData = "";

/* INCLUDES */
include "../class/CLASS_core_cur.php";
include "../db/DB_core_cur.php";
include "../operations/OPERATIONS_core_cur.php";

if($_POST){
	
	$fName = NULL;
	$lName = NULL;
	foreach($_POST as $key => $value)
    {
		if($key === 'usr_fnm'){
			$fName = $value;
		}
		if($key === 'usr_lnm'){
			$lName = $value;
		}
	}
	
	if(isset($fName) && isset($lName)){
		$val = operation_form_generate_username($fName,$lName);

		if($val){
			echo $val;
		}else{
			echo false;
		}
	}
}
?>