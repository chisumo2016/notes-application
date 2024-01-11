<?php

use Core\App;
use Core\Database;


$db = App::resolve(Database::class);

$currentUserId = 1;


//$id = $_GET['id'];

//Fetching note from database
$note = $db->query('select * from notes where id = :id', [
    'id' => $_GET['id']
])->findOrFail(); // fetch  find() findOrFail()


/*authorization*/
authorized($note['user_id'] === $currentUserId);


view("notes/show.view.php", [
    'heading' => 'Note',
    'note' => $note
]);



//require "views/notes/show.view.php";