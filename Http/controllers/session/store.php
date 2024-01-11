<?php


use Core\Authenticator;
use vendor\LoginForm;


$form = LoginForm::validate($attributes = [
    'email'     => $_POST['email'],
    'password'  => $_POST['password'],
]);

$signedIn = (new Authenticator)->attempt(

    $attributes['email'], $attributes['password']
);

/*Authenticate the user*/
if (! $signedIn) {
    $form->error(
   'email', 'No matching account found for that email address and password'
    )->throw();
}

redirect('/');



//return redirect('/login');









//return view('session/create.view.php',[
//    'errors' => $form->errors()
//]);


//return view('session/create.view.php',[
//    'errors' => [
//        'email' => 'No matching account found for that email address and password'
//    ]
//]);







//dd('submit  form');