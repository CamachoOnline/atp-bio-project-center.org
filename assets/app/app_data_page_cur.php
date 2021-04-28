<?php
// Page Data
$page = file_get_contents("assets/data/pages/".$GLOBALS['pageName']."_cur.json");
$GLOBALS['pageData'] = json_decode($page, true);
/*
echo "PAGE"."<br/>";
echo "-- Data: ".json_encode($GLOBALS['pageData'])."<br/><br/><br/>";
*/
?>