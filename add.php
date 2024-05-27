<?php
require_once ("connection.php");
$bulk = new MongoDB\Driver\BulkWrite;

if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $target = "./images/" . basename($_FILES['image']['name']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $user = [
        "_id" => new MongoDB\BSON\ObjectId,
        "username" => $username,
        "email" => $email,
        "password" => $hashedPassword,
        'image' => $target
    ];
    $bulk->insert($user);
    $client->executeBulkWrite('dbyeartwo.account', $bulk);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        header('Location: tables.php');
    } else {
        $msg = "Vai! Vai! Vai!!!";
    }
}
?>