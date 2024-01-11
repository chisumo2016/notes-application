<?php
   /**find  the corresponding note */

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$currentUserId = 1;


//$id = $_GET['id'];

//Fetching note from database
$note = $db->query('select * from notes where id = :id', [
    'id' => $_POST['id']
])->findOrFail();


/**authorize that the current user can edit the note*/
authorized($note['user_id'] === $currentUserId);

/**validate the form*/

$errors = [];

if (!Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required';
}
   /**if no validation errors, update  the record in the database table*/
if (count($errors)) {


    view("notes/create.view.php", [
        'heading' => 'Edit  Note',
        'errors'  => $errors,
        'note' => $note
    ]);
}

$db->query('update notes set body = :body WHERE   id= :id',[
    'id'    => $_POST['id'],
    'body' => $_POST['body'],
]);

/**redirect the user*/

header('location: /notes');

die();