<?php

// Is where that Edit form will submit.

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$currentUserId = 1;

// GET request to show the note.
$note = $db->query('select * from notes where id = :id', [
    'id' => $_POST['id']
])
    // If cannot find note, we abort with 404.
    ->findOrFail();

// Authorise current user access.
authorise($note['user_id'] === $currentUserId);

// Validate form

$errors = [];

if (!Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required.';
}

// No validation errors, then update DB.

if (count($errors)) {
    return view("notes/edit.view.php", [
        'heading' => 'Note',
        'note' => $note,
        'errors' => $errors,
    ]);
}
$db->query('update notes set body = :body where id = :id', [
    'id' => $_POST['id'],
    'body' => $_POST['body'],
]);

// Redirect user
header('location: /notes');
die();