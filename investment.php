<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "broker_db"; // Replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'You must be logged in to invest.']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $plan_name = $_POST['plan_name'];
    $amount = floatval($_POST['amount']);

    // Define return percentages based on plans
    $return_percentages = [
        'Basic' => 5,
        'Standard' => 7,
        'Premium' => 10,
        'Gold' => 12,
        'Platinum' => 15,
        'Diamond' => 18,
    ];

    if (!array_key_exists($plan_name, $return_percentages)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid plan selected.']);
        exit;
    }

    // Validate amount based on plan ranges
    $valid_ranges = [
        'Basic' => [100, 999],
        'Standard' => [1000, 4999],
        'Premium' => [5000, 20000],
        'Gold' => [20001, 50000],
        'Platinum' => [50001, 100000],
        'Diamond' => [100001, PHP_INT_MAX],
    ];

    [$min, $max] = $valid_ranges[$plan_name];
    if ($amount < $min || $amount > $max) {
        echo json_encode(['status' => 'error', 'message' => "Amount must be between $min and $max for $plan_name."]);
        exit;
    }

    $return_percentage = $return_percentages[$plan_name];

    // Insert investment into the database
    $stmt = $conn->prepare("INSERT INTO investments (user_id, plan_name, amount_invested, return_percentage) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('isdi', $user_id, $plan_name, $amount, $return_percentage);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Investment successfully created.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to create investment.']);
    }

    $stmt->close();
    $conn->close();
}
?>
