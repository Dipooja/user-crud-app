<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once(__DIR__ . '/../db.php');

$query = "SELECT id, name, email, dob FROM users";
$stmt = $conn->prepare($query);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
