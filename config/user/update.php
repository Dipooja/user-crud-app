<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");

include_once(__DIR__ . '/../db.php');

// Parse ID from URL
if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "User ID missing."]);
    exit;
}

$id = $_GET['id'];

// Get JSON data from request
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->email) && !empty($data->dob)) {
    $query = "UPDATE users SET name = ?, email = ?, dob = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt->execute([$data->name, $data->email, $data->dob, $id])) {
        echo json_encode(["status" => "success", "message" => "User updated."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update user."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Incomplete data."]);
}
