<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$email      = $_POST['email'];
$password   = $_POST['password'];

/*validate the form inputs*/
$errors = [];
if (!Validator::email($email)){
    $errors['email'] = 'Please provide a valid email address';
}

if (!Validator::string($password, 7 , 255)){
    $errors['password'] = 'Please provide a password of at least seven characters.';
}

if (! empty($errors)){
    return view('registration/create.view.php',[
        'errors' => $errors
    ]);
}


/*check if the account already exists*/
$user = $db->query('SELECT * FROM  users WHERE email = :email',[
    'email' => $email
])->find();

//dd($user );

if ($user){
    /*then someone with that email already exists and has an account */

    /*If yes, redirect to  a login page */
    header('location: /');
    exit();

}else{
    /*If not, save one to the database and ten log the user in and redirect session */
    $db->query('INSERT INTO users (email, password) VALUES (:email, :password)',[
        'email'    => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT), //never store database password in clear  text
    ]);

    /**Mark that tthe user has logged in*/
    login($user);
//    $_SESSION['user'] = [
//        'email' => $email
//    ];

    header('location: /'); //DASHBOARD ,SETTING AREA
    exit();
}
