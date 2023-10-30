<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];


// Validate form inputs.
$errors = [];
if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}
if (!Validator::string($password, 7, 255)) {
    $errors['password'] = 'Please provide a password of at least seven characters.';
}
if (!empty($errors)) {
    return view('registration/create.view.php', [
        'errors' => $errors
    ]);
}


$db = App::resolve(Database::class);
// Check if account already exists.
$user = $db->query('select * from users where email = :email', [
    'email' => $email
])->find();

if ($user) {
    // Someone with that email is already in the db.
    // If yes, redirect to a login page.
    header('location: /');
    exit();

} else {
    // If not, save one to DB, log user in and give access.
    $db->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
        'email' => $email,
        'password' => $password,
    ]);

    // Mark that user has logged in.
    $_SESSION['users'] = [
        'email' => $email
    ];

    header('location: /');
    exit();

}