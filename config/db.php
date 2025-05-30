<?php
// db.php

$host = "localhost";
$db_name = "user_api_db";  // Change to your database name
$username = "root";    // DB username
$password = "";        // DB password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
    exit;
}
?>
