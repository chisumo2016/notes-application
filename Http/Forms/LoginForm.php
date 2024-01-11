<?php

namespace vendor;


use Core\ValidationException;
use Core\Validator;

class LoginForm
{
    //public  $attributes;
    protected  $errors = [];

    public function __construct(public  array $attributes)
    {
        $this->attributes = $attributes;
        if (!Validator::email($attributes['email'])){
            $this->errors['email'] = 'Please provide a valid email address';
        }

        if (!Validator::string($attributes['password'])){
            $this->errors['password'] = 'Please provide a password ';
        }
    }

    public static function validate($attributes)  //$email, $password
    {
        $instance = new static($attributes);

        return  $instance->failed() ? $instance->throw() : $instance;

//        if ($instance->failed()){
//
//
//            $instance->throw();
//            //throw new ValidationException();
//            //ValidationException::throw($instance->errors(), $instance->attributes);
//        }
//        return $instance;
    }

    public function throw()
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }

    public function failed()
    {
        return count($this->errors); //retuurn boolean
    }

    public function errors()
    {
         return $this->errors;
    }

    public function error($field, $message)
    {
        $this->errors[$field] = $message;

        return  $this;
    }
}

