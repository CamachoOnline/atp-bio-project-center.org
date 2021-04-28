<?php
function operation_form_generate_username($fname = NULL, $lname = NULL)
{
    if($fname && $lname){
		
        return operation_form_value_sanitize(ucfirst($fname).ucfirst($lname));
		
    }
}
?>