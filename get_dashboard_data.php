<?php
// Start the session to get user data (user_id)
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "broker_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming user_id is saved in session after user logs in
$user_id = $_SESSION['user_id']; // Replace with the actual dynamic user_id from the session

// Query to fetch account details
$query = "SELECT wallet_balance, active_trade, total_profit, affiliate_bonus, total_trade, referral_earnings FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare query"]);
    $conn->close();
    exit;
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if data is fetched successfully
if ($row = $result->fetch_assoc()) {
    // Return data as JSON
    echo json_encode($row);
} else {
    echo json_encode(["error" => "No data found"]);
}

// Close connection
$stmt->close();
$conn->close();
?>
