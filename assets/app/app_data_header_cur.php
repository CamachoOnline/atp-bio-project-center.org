<?php
// Header Data
$header = file_get_contents("assets/data/app/header_cur.json");
$GLOBALS['headerData'] = json_decode($header, true);
/*
echo "HEADER"."<br/>";
echo "-- Data: ".json_encode($GLOBALS['headerData'])."<br/><br/><br/>";
*/
?>