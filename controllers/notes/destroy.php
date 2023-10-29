<?php

// To destroy or remove the resource from DB.

use Core\App;
use Core\Database; // DB class instantiate.

// Container
$db = App::resolve(Database::class);

$currentUserId = 1;

// SQL execution query.
$note = $db->query('select * from notes where id = :id', [
    'id' => $_POST['id']
])->findOrFail();

authorise($note['user_id'] === $currentUserId);

// DELETE current note on form submission.
$db->query('DELETE from notes WHERE id= :id', [
    'id' => $_POST['id']
]);

header('location:/notes');
exit();


