<?php
$email_file = file_get_contents("assets/data/settings/email_cur.json");
$GLOBALS['emailData'] = json_decode($email_file, true);
/*
echo "EMAIL"."<br/>";
echo "-- Data: ".json_encode($GLOBALS['emailData'])."<br/><br/><br/>";
*/
?>