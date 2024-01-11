<?php
namespace  Core;
class Validator
{
    public static  function string($value , $min=1, $max = INF)
    {
        $value = trim($value);

        return strlen($value) > $min && strlen($value) < $max;
        //return strlen(trim($value)) == 0;
    }

    public static function email($value)
    {
         return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
