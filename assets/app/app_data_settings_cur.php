<?php
$settings = file_get_contents("assets/data/settings/settings_cur.json");
$GLOBALS['settingsData'] = json_decode($settings, true);
/*
echo "SETTINGS"."<br/>";
echo "-- Data: ".json_encode($GLOBALS['settingsData'])."<br/><br/><br/>";
*/
?>