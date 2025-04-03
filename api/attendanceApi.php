<?php
require_once "db.php"; 

header("Content-Type: application/json");
$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    if (isset($_GET["fetchOptions"])) {
        // Fetch trainees and workshops for select options
        $traineesSql = "SELECT id, full_name FROM trainees";
        $workshopsSql = "SELECT id, title FROM workshops";

        $traineesResult = $conn->query($traineesSql);
        $workshopsResult = $conn->query($workshopsSql);

        $response = [
            "trainees" => $traineesResult->fetch_all(MYSQLI_ASSOC),
            "workshops" => $workshopsResult->fetch_all(MYSQLI_ASSOC)
        ];
        echo json_encode($response);
        exit();
    }

    // Fetch trainee attendance
    $sql = "SELECT a.id, t.full_name, w.title AS workshop_name, a.status, a.date
            FROM attendance a
            LEFT JOIN trainees t ON a.trainee_id = t.id
            LEFT JOIN workshops w ON a.workshop_id = w.id";
    $result = $conn->query($sql);
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} 
elseif ($method === "POST") {
    // Mark attendance
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data["trainee_id"], $data["workshop_id"], $data["status"])) {
        echo json_encode(["error" => "All fields are required"]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO attendance (trainee_id, workshop_id, status, date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $data["trainee_id"], $data["workshop_id"], $data["status"]);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Attendance recorded successfully"]);
    } else {
        echo json_encode(["error" => "Failed to record attendance"]);
    }
}
?>
