<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include "db.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        $stmt = $conn->prepare("SELECT * FROM new_hired_employees WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo json_encode($result->fetch_assoc() ?: ["error" => "Employee not found"]);
    } else {
        // Get all employees
        $result = $conn->query("SELECT * FROM new_hired_employees");
        $employees = $result->fetch_all(MYSQLI_ASSOC);

        // Get total count of new hired employees
        $countQuery = "SELECT COUNT(*) AS total FROM new_hired_employees";
        $countResult = $conn->query($countQuery);
        $countRow = $countResult->fetch_assoc();
        $totalHired = $countRow['total'];

        // Return both employee data and total count
        echo json_encode([
            "total" => $totalHired,
            "employees" => $employees
        ]);
    }
}
if ($method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data["first_name"], $data["last_name"], $data["email"], $data["gender"], $data["birth_date"], $data["contact"], $data["job_position"], $data["department"])) {
        echo json_encode(["error" => "Missing required fields"]);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO new_hired_employees (first_name, middle_name, last_name, email, gender, birth_date, contact, job_position, salary, department) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssssds",
        $data["first_name"], 
        $data["middle_name"], 
        $data["last_name"], 
        $data["email"], 
        $data["gender"], 
        $data["birth_date"], 
        $data["contact"], 
        $data["job_position"], 
        $data["salary"], 
        $data["department"]
    );

    echo json_encode($stmt->execute() ? ["message" => "Employee added successfully"] : ["error" => "Failed to add employee"]);
}

if ($method === "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data["id"], $data["first_name"], $data["last_name"], $data["email"], $data["gender"], $data["birth_date"], $data["contact"], $data["job_position"], $data["department"])) {
        echo json_encode(["error" => "Missing required fields"]);
        exit();
    }

    $stmt = $conn->prepare("UPDATE new_hired_employees SET first_name=?, middle_name=?, last_name=?, email=?, gender=?, birth_date=?, contact=?, job_position=?, salary=?, department=? WHERE id=?");
    $stmt->bind_param(
        "ssssssssdsi",
        $data["first_name"], 
        $data["middle_name"], 
        $data["last_name"], 
        $data["email"], 
        $data["gender"], 
        $data["birth_date"], 
        $data["contact"], 
        $data["job_position"], 
        $data["salary"], 
        $data["department"], 
        $data["id"]
    );

    echo json_encode($stmt->execute() ? ["message" => "Employee updated successfully"] : ["error" => "Failed to update employee"]);
}

if ($method === "DELETE") {
    if (!isset($_GET["id"])) {
        echo json_encode(["error" => "Employee ID is required"]);
        exit();
    }

    $id = intval($_GET["id"]);
    $stmt = $conn->prepare("DELETE FROM new_hired_employees WHERE id = ?");
    $stmt->bind_param("i", $id);

    echo json_encode($stmt->execute() ? ["message" => "Employee deleted successfully"] : ["error" => "Failed to delete employee"]);
}
?>
