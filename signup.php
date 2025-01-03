<?php
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
    // Sanitize inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $phone_number = htmlspecialchars(trim($_POST['phone_number']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $currency = htmlspecialchars($_POST['currency']);
    $country = htmlspecialchars($_POST['country']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $terms_accepted = isset($_POST['terms']) ? 1 : 0;

    // Validate inputs
    if (empty($username) || empty($full_name) || empty($phone_number) || empty($email) || empty($currency) || empty($country) || empty($password)) {
        die("All fields are required!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format!");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match!");
    }

    if (!$terms_accepted) {
        die("You must accept the terms and conditions!");
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO users (username, full_name, phone_number, email, currency, country, password_hash, terms_accepted) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sssssssi", $username, $full_name, $phone_number, $email, $currency, $country, $password_hash, $terms_accepted);

    if ($stmt->execute()) {
        echo '<script>
            alert("Registration successful!");
            window.location.href = "signin.html";
        </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
