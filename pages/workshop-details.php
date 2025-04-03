<?php
// Include the layout and database connection
include '../layout/layout.php';
include '../api/db.php';

// Validate and get workshop ID from URL
$workshop_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($workshop_id <= 0) {
    die("Invalid workshop ID.");
}

//  Fetch workshop details
$sql_workshop = "SELECT w.*, c.name AS category_name FROM workshops w 
                 LEFT JOIN categories c ON w.category_id = c.id 
                 WHERE w.id = ?";
$stmt = $conn->prepare($sql_workshop);
$stmt->bind_param("i", $workshop_id);
$stmt->execute();
$workshop_result = $stmt->get_result();
$workshop = $workshop_result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$workshop) {
    die("Workshop not found.");
}

// Start output buffering
ob_start();
?>

<div class='bg-gray-300 flex justify-center items-center min-h-screen p-5 w-full'>
    <div class='bg-white max-w-2xl w-full p-8 rounded-lg shadow-lg'>
        <h2 class='text-2xl font-bold text-gray-800 text-center mb-4'>
            <?php echo htmlspecialchars($workshop['title']); ?>
        </h2>

        <div class='space-y-4'>
            <p class='text-gray-700'><span class='font-semibold'>Mentor:</span> <?php echo htmlspecialchars($workshop['mentor']); ?></p>
            <p class='text-gray-700'><span class='font-semibold'>Category:</span> <?php echo htmlspecialchars($workshop['category_name']); ?></p>
            <p class='text-gray-700'><span class='font-semibold'>Description:</span> <?php echo htmlspecialchars($workshop['description'] ?? 'N/A'); ?></p>
            <p class='text-gray-700'><span class='font-semibold'>Date:</span> <?php echo htmlspecialchars($workshop['date']); ?></p>
            <p class='text-gray-700'><span class='font-semibold'>Time:</span> <?php echo htmlspecialchars($workshop['time']); ?></p>
        </div>
    </div>
    
    
</div>

<?php
// Capture the output and pass it to hrLayout
$homeContent = ob_get_clean();
hrLayout($homeContent);
?>