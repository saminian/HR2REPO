<?php
require_once "db.php"; // Ensure you have database connection

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    // Initialize filters
    $filters = [];
    $params = [];

    if (!empty($_GET["full_name"])) {
        $filters[] = "t.full_name LIKE ?";
        $params[] = "%" . $_GET["full_name"] . "%";
    }
    if (!empty($_GET["email"])) {
        $filters[] = "t.email LIKE ?";
        $params[] = "%" . $_GET["email"] . "%";
    }
    if (!empty($_GET["department"])) {
        $filters[] = "t.department LIKE ?";
        $params[] = "%" . $_GET["department"] . "%";
    }

    // Build the query
    $sql = "SELECT t.id, t.full_name, t.email, t.department, c.name AS workshop_name 
            FROM trainees t 
            JOIN categories c ON t.workshop_id = c.id";

    if (!empty($filters)) {
        $sql .= " WHERE " . implode(" AND ", $filters);
    }

    $stmt = $conn->prepare($sql);

    if (!empty($filters)) {
        $types = str_repeat("s", count($params)); // Bind parameters dynamically
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $trainees = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($trainees);
} elseif ($method === "POST") {
    // Create a new trainee
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["full_name"], $data["email"], $data["department"], $data["workshop_name"])) {
        echo json_encode(["error" => "All fields are required"]);
        exit();
    }

    $full_name = $data["full_name"];
    $email = $data["email"];
    $department = $data["department"];
    $workshop_name = $data["workshop_name"];

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM trainees WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["error" => "Email already exists"]);
        exit();
    }

    // Fetch workshop_id using workshop_name
    $stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
    $stmt->bind_param("s", $workshop_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $workshop = $result->fetch_assoc();

    if (!$workshop) {
        echo json_encode(["error" => "Invalid workshop"]);
        exit();
    }

    $workshop_id = $workshop["id"];

    // Insert trainee data
    $stmt = $conn->prepare("INSERT INTO trainees (full_name, email, department, workshop_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $full_name, $email, $department, $workshop_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Trainee added successfully"]);
    } else {
        echo json_encode(["error" => "Failed to add trainee"]);
    }
}
elseif ($method === "PUT") {
    // Update a trainee
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["id"], $data["full_name"], $data["email"], $data["department"], $data["workshop_name"])) {
        echo json_encode(["error" => "All fields are required"]);
        exit();
    }

    $id = $data["id"];
    $full_name = $data["full_name"];
    $email = $data["email"];
    $department = $data["department"];
    $workshop_name = $data["workshop_name"];

    // Fetch workshop_id using workshop_name
    $stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
    $stmt->bind_param("s", $workshop_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $workshop = $result->fetch_assoc();

    if (!$workshop) {
        echo json_encode(["error" => "Invalid workshop"]);
        exit();
    }

    $workshop_id = $workshop["id"];

    // Update trainee data
    $stmt = $conn->prepare("UPDATE trainees SET full_name = ?, email = ?, department = ?, workshop_id = ? WHERE id = ?");
    $stmt->bind_param("sssii", $full_name, $email, $department, $workshop_id, $id);
    $stmt->execute();

    echo json_encode(["message" => "Trainee updated successfully"]);
} elseif ($method === "DELETE") {
    // Delete a trainee
    if (!isset($_GET["id"])) {
        echo json_encode(["error" => "Trainee ID is required"]);
        exit();
    }

    $id = $_GET["id"];
    $stmt = $conn->prepare("DELETE FROM trainees WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(["message" => "Trainee deleted successfully"]);
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
