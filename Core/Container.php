<?php

namespace Core;

class Container
{
    protected  $bindinngs = [];
    /*set up the method signature*/
    public function bind($key ,$resolver )
    {
        $this->bindinngs[$key] = $resolver;
    }

    public function resolve($key)
    {
        if (! array_key_exists($key, $this->bindinngs)){
            throw  new \Exception("No matching binding found for {$key}");
        }


            $resolver = $this->bindinngs[$key];

            return call_user_func($resolver);

    }
}