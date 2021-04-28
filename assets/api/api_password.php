<?php
$rootDir = __DIR__;
$file = __FILE__;

/* VARIABLES & ARRAYS */
$settingsData = "";

/* INCLUDES */
include "../class/CLASS_core_cur.php";
include "../db/DB_core_cur.php";
include "../operations/OPERATIONS_core_cur.php";

$val = operation_form_generate_password();

if($val){
	echo $val;
}else{
	echo false;
}
?>