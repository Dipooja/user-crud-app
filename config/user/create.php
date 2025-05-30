<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once(__DIR__ . '/../db.php');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->email) && !empty($data->password) && !empty($data->dob)) {

    // Check for duplicate email
    $checkQuery = "SELECT COUNT(*) FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->execute([$data->email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists."]);
        exit;
    }

    // Insert user
    $query = "INSERT INTO users (name, email, password, dob) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        $data->name,
        $data->email,
        password_hash($data->password, PASSWORD_DEFAULT),
        $data->dob
    ]);
    echo json_encode(["status" => "success", "message" => "User created."]);

} else {
    echo json_encode(["status" => "error", "message" => "Incomplete data."]);
}
