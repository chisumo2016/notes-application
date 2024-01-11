<?php
use Core\Response;
function  dd($value)
{
    echo  "<pre>";
    var_dump($value);
    echo  "</pre>";

    die();
}

//echo $_SERVER['REQUEST_URI'];
function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404 )
{
    http_response_code($code);

    require base_path("views/{$code}.php");
    //require 'views/404.php';

    die();
}

function authorized($connection,  $status = Response::FORBIDDEN )
{
    if (!$connection){
        abort($status);
    }
}

// relative path to the root of the project

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);
    require base_path('views/' . $path); ///views/index.view.php
    //return base_path('views/' . $path); ///views/index.view.php
}

function redirect($path)
{
    header("location: {$path}");
    exit();
}

function old($key, $default = '')
{
        return Core\Session::get('old')[$key] ?? $default;
}

//function login($user)
//{
//    $_SESSION['user'] = [
//        'email' => $user['email']
//    ];
//
//    session_regenerate_id(true);
//}
//
//function logout()
//{
//    $_SESSION = []; //clear super global
//    session_destroy();
//
//    $params = session_get_cookie_params();
//
//    setcookie('PHPSESSID', '' , time() -3600  ,$params['path'], $params['domain'], $params['secure'],$params['httponly']   );
//
//}