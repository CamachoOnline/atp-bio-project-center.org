<?php
// Element Definitions
$def = file_get_contents("assets/data/definitions/def_el_cur.json");
$GLOBALS['elementDefData'] = json_decode($def, true);
/*
echo "DEFINITIONS"."<br/>";
echo "-- Data: ".json_encode($GLOBALS['elementDefData'])."<br/><br/><br/>";
*/
?>