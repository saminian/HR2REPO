<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

include 'db.php'; // Ensure this connects to your DB

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    // Get total count of evaluated employees
    $countQuery = "SELECT COUNT(*) AS total FROM employeeseval";
    $countResult = $conn->query($countQuery);
    $countRow = $countResult->fetch_assoc();
    $totalEmployees = $countRow['total'];

    // Get employee evaluation records
    $query = "SELECT id, first_name, last_name, final_score, status FROM employeeseval";
    $result = $conn->query($query);
    $employees = [];

    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    echo json_encode([
        "total" => $totalEmployees,
        "employees" => $employees
    ]);
}
?>
