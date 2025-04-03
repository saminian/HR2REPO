<?php
require_once "db.php"; // Ensure you have a database connection

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    if (isset($_GET["id"])) {
        // Fetch a single category by ID (without description)
        $id = intval($_GET["id"]);
        $stmt = $conn->prepare("SELECT id, name FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
            echo json_encode($category);
        } else {
            echo json_encode(["error" => "Category not found"]);
        }
        $stmt->close();
    } else {
        // Fetch all categories (without description)
        $query = "SELECT id, name FROM categories"; 
        $result = $conn->query($query);
        $categories = [];

        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        echo json_encode($categories);
    }
}
?>