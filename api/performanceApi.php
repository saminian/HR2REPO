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

    // Fetch performance evaluations
    $sql = "SELECT p.id, t.full_name, w.title AS workshop_name, 
                   p.evaluation_score, p.feedback, p.evaluation_date
            FROM performance_evaluations p
            LEFT JOIN trainees t ON p.trainee_id = t.id
            LEFT JOIN workshops w ON p.workshop_id = w.id";
    $result = $conn->query($sql);
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} 
elseif ($method === "POST") {
    // Submit performance evaluation
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data["trainee_id"], $data["workshop_id"], $data["evaluation_score"], $data["feedback"])) {
        echo json_encode(["error" => "All fields are required"]);
        exit();
    }

    // Ensure score is between 0 and 100
    if ($data["evaluation_score"] < 0 || $data["evaluation_score"] > 100) {
        echo json_encode(["error" => "Evaluation score must be between 0 and 100"]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO performance_evaluations (trainee_id, workshop_id, evaluation_score, feedback) 
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iids", $data["trainee_id"], $data["workshop_id"], $data["evaluation_score"], $data["feedback"]);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Performance evaluation recorded successfully"]);
    } else {
        echo json_encode(["error" => "Failed to record evaluation"]);
    }
}
?>
