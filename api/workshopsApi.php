<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
include "db.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    if (isset($_GET["id"])) {
        // Fetch single workshop by ID
        $id = intval($_GET["id"]);
        $stmt = $conn->prepare("SELECT * FROM workshops WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $workshop = $result->fetch_assoc();
            echo json_encode($workshop);
        } else {
            echo json_encode(["error" => "Workshop not found"]);
        }
        $stmt->close();
    } else {
        // Fetch all workshops
        $query = "SELECT id, title, mentor, category_id, description, date, time, venue FROM workshops";
        $result = $conn->query($query);
        $workshops = [];

        while ($row = $result->fetch_assoc()) {
            $row['venue'] = $row['venue'] ?? '';
            $workshops[] = $row;
        }

        echo json_encode($workshops);
    }
} 
elseif ($method === "POST") {
    // Create new workshop
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Check required fields
    if (!isset($data["title"], $data["mentor"], $data["category_id"], $data["date"], $data["time"])) {
        echo json_encode(["error" => "Missing required fields"]);
        exit();
    }

    // Validate date is not in the past (2024 or earlier)
    $date = $data["date"];
    $dateYear = date('Y', strtotime($date));
    $currentYear = date('Y');
    
    if ($dateYear < $currentYear) {
        echo json_encode(["error" => "Past dates (before 2025) are not allowed!"]);
        exit();
    }
    // Future years (2026+) are allowed

    $title = $data["title"];
    $mentor = $data["mentor"];
    $category_name = $data["category_id"];
    $description = isset($data["description"]) ? $data["description"] : null;
    $time = $data["time"];
    $venue = isset($data["venue"]) ? $data["venue"] : null;

    // Find category ID from name
    $stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(["error" => "Invalid category name"]);
        exit();
    }

    $stmt->bind_result($category_id);
    $stmt->fetch();
    $stmt->close();

    // Insert workshop
    $stmt = $conn->prepare("INSERT INTO workshops (title, mentor, category_id, description, date, time, venue) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $title, $mentor, $category_id, $description, $date, $time, $venue);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Workshop added successfully"]);
    } else {
        echo json_encode(["error" => "Failed to add workshop"]);
    }
}
elseif ($method === "PUT") {
    // Update workshop
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data["id"], $data["title"], $data["mentor"], $data["category_id"], $data["date"], $data["time"])) {
        echo json_encode(["error" => "Missing required fields"]);
        exit();
    }

    // Validate date is not in the past (2024 or earlier)
    $date = $data["date"];
    $dateYear = date('Y', strtotime($date));
    $currentYear = date('Y');
    
    if ($dateYear < $currentYear) {
        echo json_encode(["error" => "Past dates (before 2025) are not allowed!"]);
        exit();
    }
    // Future years (2026+) are allowed

    $id = $data["id"];
    $title = $data["title"];
    $mentor = $data["mentor"];
    $category_id = $data["category_id"];
    $description = isset($data["description"]) ? $data["description"] : null;
    $time = $data["time"];
    $venue = isset($data["venue"]) ? $data["venue"] : null;

    // Update workshop
    $stmt = $conn->prepare("UPDATE workshops SET title=?, mentor=?, category_id=?, description=?, date=?, time=?, venue=? WHERE id=?");
    $stmt->bind_param("ssissssi", $title, $mentor, $category_id, $description, $date, $time, $venue, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Workshop updated successfully"]);
    } else {
        echo json_encode(["error" => "Failed to update workshop"]);
    }
} 
elseif ($method === "DELETE") {
    // Delete workshop
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["id"])) {
        echo json_encode(["error" => "Missing workshop ID"]);
        exit();
    }

    $id = $data["id"];
    $stmt = $conn->prepare("DELETE FROM workshops WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Workshop deleted successfully"]);
    } else {
        echo json_encode(["error" => "Failed to delete workshop"]);
    }
} 
else {
    echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();