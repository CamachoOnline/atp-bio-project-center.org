<?php
$pageName = "";
$pageError = [];

$settingsData = "";
$configData = "";
$emailData = "";
$headerData = "";
$pageData = "";
$elementDefData = "";
$footerData = "";

$rootDir = __DIR__;
$file = __FILE__;

//session_start();
include "assets/class/CLASS_core_cur.php";
include "assets/db/DB_core_cur.php";
include "assets/server/SERVER_core_cur.php";
include "assets/build/BUILD_core_cur.php";

            
if(isset($_GET['code']) && !empty($_GET['code'])){

    //$code = mysqli_real_escape_string($GLOBALS["DB"],$_GET['code']);
	$mycode = $_GET['code'];
    $check =  "SELECT usr_tkn, usr_act FROM usr_tbl WHERE usr_tkn='".$mycode."' AND usr_act='0'";            
    $search = mysqli_query($GLOBALS["DB"], $check) or die(mysqli_error()); 
    $match  = mysqli_num_rows($search);
                  
    if($match > 0){
        // We have a match, activate the account
		$update = "UPDATE usr_tbl SET usr_act='1' WHERE usr_tkn='".$mycode."' AND usr_act='0'";
        mysqli_query($GLOBALS["DB"], $update) or die(mysqli_error());
		$pageName = "confirm";
        
    }else{
        // No match -> invalid url or account has already been activated.
		$pageName = "activated";

    }
                  
}else{
    // Invalid approach
    $pageName = "invalid";
	
}
include "assets/app/APP_core_cur.php";
?>