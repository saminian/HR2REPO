<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

include 'db.php'; // Ensure this connects to your DB

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $query = "SELECT id, first_name, last_name, final_score, status FROM employeeseval";
    $result = $conn->query($query);
    $employees = [];

    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    echo json_encode($employees);
}
elseif ($method == 'POST') {
    // Get JSON payload
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    if (!isset($data['id']) || !isset($data['first_name']) || !isset($data['last_name']) || !isset($data['final_score'])) {
        echo json_encode(["error" => "Missing required fields"]);
        exit;
    }

    $id = intval($data['id']);
    $first_name = $conn->real_escape_string($data['first_name']);
    $last_name = $conn->real_escape_string($data['last_name']);
    $final_score = floatval($data['final_score']);  

    // Determine Pass/Fail based on final_score
    $status = ($final_score >= 75) ? 'Pass' : 'Fail';

    // Check if employee already exists
    $checkQuery = "SELECT id FROM employeeseval WHERE id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["error" => "Employee evaluation already exists"]);
    } else {
        // Insert evaluation with Pass/Fail status
        $insertQuery = "INSERT INTO employeeseval (id, first_name, last_name, final_score, status, updated_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("issds", $id, $first_name, $last_name, $final_score, $status);

        if ($stmt->execute()) {
            echo json_encode(["message" => "New employee evaluation added successfully", "status" => $status]);
        } else {
            echo json_encode(["error" => "Failed to insert new evaluation", "sql_error" => $stmt->error]);
        }
    }
}
?>
