<?php
function operation_form_value_hash($value = NULL)
{
    if($value){
        $hVal = password_hash($value, PASSWORD_DEFAULT);
        return $hVal;
    }else{
        return false;
    }
}
?>