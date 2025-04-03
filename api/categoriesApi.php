<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include "db.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    if (isset($_GET["id"])) {
        // Fetch one category by ID
        $id = $_GET["id"];
        $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo json_encode($result->fetch_assoc() ?: ["error" => "Category not found"]);
    } else {
        // Fetch all categories
        $result = $conn->query("SELECT * FROM categories");
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    }
}

if ($method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data["name"])) {
        echo json_encode(["error" => "Category name is required"]);
        exit();
    }

    $name = $data["name"];
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    
    echo json_encode(["message" => "Category added"]);
}

if ($method === "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data["id"], $data["name"])) {
        echo json_encode(["error" => "Category ID and name are required"]);
        exit();
    }

    $id = $data["id"];
    $name = $data["name"];

    $stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    
    echo json_encode(["message" => "Category updated"]);
}

if ($method === "DELETE") {
    if (!isset($_GET["id"])) {
        echo json_encode(["error" => "Category ID is required"]);
        exit();
    }

    $id = $_GET["id"];
    $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    echo json_encode(["message" => "Category deleted"]);
}
?>
