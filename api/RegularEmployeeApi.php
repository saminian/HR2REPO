<?php
header("Content-Type: application/json");
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM regular_employees WHERE id = $id";
    } else {
        $sql = "SELECT * FROM regular_employees";
    }
    $result = $conn->query($sql);
    $employees = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($employees);
} 
elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $sql = "INSERT INTO regular_employees (user_id, first_name, middle_name, last_name, email, department, position, phone, address, date_of_birth, gender, nationality, marital_status, start_date, end_date, employment_status, status, profile_picture) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssssss", $data['user_id'], $data['first_name'], $data['middle_name'], $data['last_name'], $data['email'], $data['department'], $data['position'], $data['phone'], $data['address'], $data['date_of_birth'], $data['gender'], $data['nationality'], $data['marital_status'], $data['start_date'], $data['end_date'], $data['employment_status'], $data['status'], $data['profile_picture']);
    echo json_encode(["success" => $stmt->execute()]);
} 
elseif ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $sql = "UPDATE regular_employees SET first_name=?, middle_name=?, last_name=?, email=?, department=?, position=?, phone=?, address=?, date_of_birth=?, gender=?, nationality=?, marital_status=?, start_date=?, end_date=?, employment_status=?, status=?, profile_picture=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssssi", $data['first_name'], $data['middle_name'], $data['last_name'], $data['email'], $data['department'], $data['position'], $data['phone'], $data['address'], $data['date_of_birth'], $data['gender'], $data['nationality'], $data['marital_status'], $data['start_date'], $data['end_date'], $data['employment_status'], $data['status'], $data['profile_picture'], $data['id']);
    echo json_encode(["success" => $stmt->execute()]);
} 
elseif ($method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = intval($data['id']);
    $sql = "DELETE FROM regular_employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    echo json_encode(["success" => $stmt->execute()]);
} 
else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>