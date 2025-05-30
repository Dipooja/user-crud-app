<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");

include_once(__DIR__ . '/../db.php');

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "User ID is required"]);
    exit;
}

$id = $_GET['id'];

$query = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt->execute([$id])) {
    echo json_encode(["status" => "success", "message" => "User deleted"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete user"]);
}
