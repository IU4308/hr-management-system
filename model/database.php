<?php
$dsn = 'mysql:host=localhost;dbname=hrms';
$username = 'root';
try {
    $db = new PDO($dsn, $username);
} catch (PDOException $e) {
    $error = "Database Error: ";
    $error .= $e->getMessage();
    include('view/error.php');
    exit();
}
