<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include 'db.php'; // Ensure this connects to your DB

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    // Get total count of trainees
    $countQuery = "SELECT COUNT(*) AS total FROM trainees";
    $countResult = $conn->query($countQuery);
    $countRow = $countResult->fetch_assoc();
    
    echo json_encode(["total" => $countRow['total']]);
}
?>
