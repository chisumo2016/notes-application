<?php

use Core\App;
use Core\Database;


$db = App::resolve(Database::class);

//dd($db);

//$config = require base_path('config.php');
//$db = new Database($config['database']);

$currentUserId = 1;

//form was submitted . delete the current note
//dd($_POST);

$note = $db->query('select * from notes where id = :id', [
    'id' => $_POST['id']
])->findOrFail(); // fetch  find() findOrFail()


authorized($note['user_id'] === $currentUserId);

$db->query('delete  from notes where id = :id', [
    'id' => $_GET['id']
]);

header('location: /notes');
exit();




//require "views/notes/show.view.php";