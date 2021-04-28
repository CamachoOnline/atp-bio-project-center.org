<?php
// Footer Data
$footer = file_get_contents("assets/data/app/footer_cur.json");
$GLOBALS['footerData'] = json_decode($footer, true);
/*
echo "FOOTER"."<br/>";
echo "-- Data: ".json_encode($GLOBALS['footerData'])."<br/><br/><br/>";
*/
?>