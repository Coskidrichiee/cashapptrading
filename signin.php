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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $password_hash);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $password_hash)) {
            // Start session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;

            // Alert sign-in success and redirect
            echo '<script>
                alert("Sign in successful!");
                window.location.href = "dashboard.php";
            </script>';
            exit();
        } else {
            echo '<script>alert("Invalid password!");</script>';
        }
    } else {
        echo '<script>alert("No account found with that email!");</script>';
    }

    $stmt->close();
}

$conn->close();
?>
