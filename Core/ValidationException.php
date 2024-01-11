<?php

namespace Core;

class ValidationException  extends \Exception  //inheritance
{
    public readonly array  $errors  ;
    public readonly array  $old  ;
    //protected $old = [] ;
    public static function throw($errors, $old)
     {
        $instance = new static;

        $instance->errors = $errors;
        $instance->old = $old;

        throw $instance;
     }

    public function errors()
    {
        return $this->errors;
    }
}