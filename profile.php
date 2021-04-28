<?php
include "assets/db/DB_core_cur.php";
if(!isset($_SESSION["LOGGEDIN"]))
{
	
 	header("Location: https://atp-bio-project-center.org/index_sign.php");
	
}
else
{

	/* Name of Page */
	$pageName = str_replace(".php","",basename($_SERVER['PHP_SELF']));

	/* Store page errors */
	$pageError = [];

	/* Store data */
	$settingsData = "";
	$configData = "";
	$emailData = "";
	$headerData = "";
	$pageData = "";
	$elementDefData = "";
	$footerData = "";
	$userData ="";

	/* Application Includes */
	include "assets/class/CLASS_core_cur.php";
	include "assets/build/BUILD_core_cur.php";
	include "assets/app/APP_core_cur.php";
	
}
?>