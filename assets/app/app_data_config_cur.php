<?php
// Config Data                                                                                                                                             
$config = file_get_contents("assets/data/config/config_cur.json");
$GLOBALS['configData'] = json_decode($config, true);
/*
echo "CONFIG"."<br/>";
echo "-- Data: ".json_encode($GLOBALS['configData'])."<br/><br/><br/>";
*/
?>