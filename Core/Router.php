<?php
namespace  Core;
use Core\Middleware\Auth;
use Core\Middleware\Guest;
use Core\Middleware\Middleware;

class Router
{
    protected $routes = [];  // routes array

    public function  add($method , $uri , $controller)
    {
        //$this->routes[] = compact('method' , 'uri' , 'controller');

        $this->routes[] =[
            'uri' => $uri,
            'controller' => $controller,
             'method'=> $method,
             'middleware'=> null,

            //'method'=>'GET'
        ];

        return $this;
    }

      public function get($uri , $controller)
      {
         //$this->add('GET' , $uri , $controller);
         return $this->add('GET' , $uri , $controller);
      }

    public function post($uri , $controller)
    {
        return $this->add('POST' , $uri , $controller);
    }

    public function delete($uri , $controller)
    {
        return $this->add('DELETE' , $uri , $controller);
    }

    public function patch($uri , $controller)
    {
        return $this->add('PATCH' , $uri , $controller);

    }

    public function put($uri , $controller)
    {
        return $this->add('PUT' , $uri , $controller);

    }

    public function only($key)  //middleware
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;  //999999] php 8

        return  $this; //chain further

        //dd($this->routes);
    }

    public function route($uri, $method) //get delete put post request
    {
        foreach ($this->routes as $route){
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)){ // === match

                Middleware::resolve($route['middleware']);


                return require  base_path('Http/controllers/' . $route['controller']);
                //return require  base_path($route['controller']);
            }
        }
        //abort
        $this->abort();
    }

    ///**option to abort status code*/
    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");
        //require 'views/404.php';

        die();
    }

    public function previousUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }
}



//

////$routes = require('routes.php');
//
///**Handle routing*/
//function routeToController($uri,$routes)
//{
//    if (array_key_exists($uri , $routes)){
//        require base_path($routes[$uri]);
//        //require $routes[$uri];
//    }else{
//        abort();
//    }
//}
//
///**option to abort status code*/
//function abort($code = 404)
//{
//    http_response_code($code);
//
//    require base_path("views/{$code}.php");
//    //require 'views/404.php';
//
//    die();
//}
//
////dd(parse_url($uri));
//

////dd($_SERVER);
///
//$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
//$routes = require  base_path('routes.php');
//routeToController($uri,$routes);


