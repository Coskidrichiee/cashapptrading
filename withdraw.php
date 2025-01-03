<?php
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "broker_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session (assuming user is logged in and user_id is stored in session)
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment-method'];
    $account_info = isset($_POST['account-info']) ? $_POST['account-info'] : null;
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session

    // Insert the withdrawal request into the database (Withdrawals table)
    $stmt = $conn->prepare("INSERT INTO withdrawals (user_id, amount, payment_method, account_info, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("idss", $user_id, $amount, $payment_method, $account_info);

    if ($stmt->execute()) {
        // Record the transaction in the transactions table
        $transaction_type = 'Withdrawal'; // Transaction type
        $transaction_status = 'Pending'; // Status of the transaction

        // Insert transaction into transactions table
        $transaction_stmt = $conn->prepare("INSERT INTO transactions (user_id, transaction_type, amount, status, payment_method, payment_account_info) VALUES (?, ?, ?, ?, ?, ?)");
        $transaction_stmt->bind_param("isisss", $user_id, $transaction_type, $amount, $transaction_status, $payment_method, $account_info);

        if ($transaction_stmt->execute()) {
            echo "Withdrawal request has been submitted successfully and recorded.";
        } else {
            echo "Error recording transaction. Please try again later.";
        }

        $transaction_stmt->close();
    } else {
        // Failure message for withdrawal
        echo "Error submitting withdrawal request. Please try again later.";
    }

    $stmt->close();
}
?>
