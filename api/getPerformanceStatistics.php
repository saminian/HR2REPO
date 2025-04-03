<?php
require_once "db.php";

header("Content-Type: application/json");

$sql = "SELECT 
            ps.trainee_id, 
            t.full_name,
            ps.department,
            ps.avg_score,
            ps.attendance_rate,
            ps.evaluation_status,
            ps.last_evaluation
        FROM performance_statistics ps
        JOIN trainees t ON ps.trainee_id = t.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $trainees = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(["status" => "success", "data" => $trainees]);
} else {
    echo json_encode(["status" => "error", "message" => "No performance records found"]);
}

$conn->close();
?>
