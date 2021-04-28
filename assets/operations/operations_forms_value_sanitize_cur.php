<?php
function operation_form_value_sanitize($value = NULL,$remove_nl=true)
{
    $str = operation_form_value_strip($value);

    if($remove_nl)
    {
        $injections = array('/(\n+)/i',
            '/(\r+)/i',
            '/(\t+)/i',
            '/(%0A+)/i',
            '/(%0D+)/i',
            '/(%08+)/i',
            '/(%09+)/i'
            );
        $str = preg_replace($injections,'',$str);
    }

    return $str;
}
?>