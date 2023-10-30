<?php

// Shows a form to edit.

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = 1;

// GET request to show the note.
$note = $db->query('select * from notes where id = :id', [
    'id' => $_GET['id']
])
    //     // If cannot find note, we abort with 404.
    ->findOrFail();

// // Authorise current user access.
authorise($note['user_id'] === $currentUserId);


view("notes/edit.view.php", [
    'heading' => 'Edit Note',
    'errors' => [],
    'note' => $note
]);