<?php
require_once "db.php"; 

header("Content-Type: application/json");

$sql = "SELECT 
            SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END) AS presentCount,
            SUM(CASE WHEN status = 'Absent' THEN 1 ELSE 0 END) AS absentCount,
            SUM(CASE WHEN status = 'Late' THEN 1 ELSE 0 END) AS lateCount
        FROM attendance";

$result = $conn->query($sql);

if ($result) {
    $counts = $result->fetch_assoc();
    echo json_encode($counts);
} else {
    echo json_encode(["error" => "Failed to fetch attendance summary"]);
}
?>
