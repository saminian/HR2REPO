<?php
session_start();
header("Content-Type: application/json");

// API URL to fetch users
$apiUrl = "https://admin.gwamerchandise.com/api/users";

// Fetch users from API
$response = file_get_contents($apiUrl);
if ($response === false) {
    echo json_encode(["error" => "Failed to fetch user data"]);
    exit();
}

// Decode JSON response
$usersData = json_decode($response, true);

if (!isset($usersData['users']) || !is_array($usersData['users'])) {
    echo json_encode(["error" => "Invalid user data"]);
    exit();
}

// Read input credentials
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['email']) || empty(trim($data['email']))) {  //  Changed from "name" to "email"
    echo json_encode(["error" => "Email is required"]);
    exit();
}
if (!isset($data['password']) || strlen($data['password']) < 6) {
    echo json_encode(["error" => "Password must be at least 6 characters"]);
    exit();
}

$email = trim($data['email']);
$password = trim($data['password']); // You might need to hash and compare it correctly

// Find the user by email
$user = null;
foreach ($usersData['users'] as $u) {
    if (strtolower(trim($u['email'])) === strtolower($email)) {  //  Match email instead of name
        $user = $u;
        break;
    }
}

// Validate user existence
if (!$user) {
    echo json_encode(["error" => "Invalid email or password"]);
    exit();
}

// Store user data in session
$_SESSION['id'] = $user['id'];
$_SESSION['name'] = $user['name'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];

// Convert role to lowercase for case-insensitive comparison
$role = strtolower(trim($user['role']));

// Redirect logic
 if ($role === 'hr2') {
    $redirectUrl = "/Hr2REPO/pages/dashboard.php"; // Replace with your HR2 dashboard page
} else {
    $redirectUrl = "404Page.php";
}

echo json_encode([
    "success" => true,
    "id" => $_SESSION['id'],
    "name" => $_SESSION['name'],
    "email" => $_SESSION['email'],
    "role" => $_SESSION['role'],
    "redirect" => $redirectUrl
]);
exit();
?>
