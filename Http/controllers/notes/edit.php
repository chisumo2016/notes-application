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


//$errors  = [];

//$heading = "Create Note";
view("notes/edit.view.php", [
    'heading' => 'Edit Note',
    'errors'  => [],
    'note' => $note

]);

//require 'views/notes/create.view.php';