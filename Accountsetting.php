<?php
session_start();

// Redirect to sign-in page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

// Handle Profile Picture Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    $target_dir = "uploads/"; // Directory where the file will be saved
    
    // Ensure the 'uploads' directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);  // Create the directory if it doesn't exist
    }

    $target_file = $target_dir . basename($_FILES['profile_pic']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is a valid image
    if (getimagesize($_FILES['profile_pic']['tmp_name']) === false) {
        echo "<script>alert('File is not an image.');</script>";
        $uploadOk = 0;
    }

    // Check file size (Max 100MB)
    if ($_FILES['profile_pic']['size'] > 100 * 1024 * 1024) {
        echo "<script>alert('Sorry, your file is too large. Maximum file size is 100MB.');</script>";
        $uploadOk = 0;
    }

    // Allow only certain file formats (JPG, PNG)
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG files are allowed.');</script>";
        $uploadOk = 0;
    }

    // Try to upload the file if everything is OK
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.');</script>";
    } else {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
            // Save the file path in session for future use (header profile pic)
            $_SESSION['profile_pic'] = $target_file;
            echo "<script>alert('Profile picture uploaded successfully.');</script>";
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
/* General Page Layout */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    color: #333;
}

.content {
    width: 85%;
    max-width: 960px;
    margin: 40px auto;
    background-color: #fff;
    padding: 30px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    transition: transform 0.3s;
}

h1 {
    text-align: center;
    color: #fff;
    font-size: 2em;
    margin-bottom: 20px;
}

.section {
    margin-bottom: 25px;
}

h3 {
    color: #333;
    font-size: 1.6em;
    margin-bottom: 12px;
    font-weight: bold;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-size: 1.2em;
    margin-bottom: 8px;
    display: block;
    color: #555;
}

.form-group input, .form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1.1em;
    box-sizing: border-box;
    background-color: #fafafa;
    transition: border-color 0.3s;
}

.form-group input:focus, .form-group select:focus {
    border-color: #4CAF50;
    outline: none;
}

.form-group input[type="file"] {
    padding: 8px;
    border: none;
    background-color: #f7f7f7;
}

button {
    padding: 12px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.2em;
    transition: background-color 0.3s, transform 0.2s;
}

button:hover {
    background-color: #45a049;
    transform: scale(1.05);
}

#profile-pic {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 15px;
}

.profile-picture {
    text-align: center;
    margin-bottom: 30px;
}

.profile-picture label {
    display: block;
    font-size: 1.2em;
    color: #555;
    margin-bottom: 10px;
}

.profile-picture .form-group {
    margin-top: 10px;
}

.section small {
    display: block;
    color: #888;
    font-size: 0.9em;
    margin-top: 5px;
}

/* Mobile Responsive Design */
@media (max-width: 600px) {
    .content {
        width: 95%;
        padding: 20px;
    }

    h1 {
        font-size: 1.8em;
    }

    .form-group input, .form-group select {
        font-size: 1em;
    }

    button {
        width: 100%;
        font-size: 1.1em;
    }

    #profile-pic {
        width: 120px;
        height: 120px;
    }

    .section h3 {
        font-size: 1.3em;
    }
}

    </style>

</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" style="width: 250px; background-color: #2c3e50; color: #ecf0f1;">
        <div class="sidebar-header" style="padding: 20px; text-align: center;">
            <h2>Dashboard</h2>
        </div>
        <nav class="sidebar-nav" style="padding: 0 10px;">
            <ul style="list-style: none; padding: 0;">
                <li style="margin: 10px 0;"><a href="dashboard.php" style="color: #ecf0f1; text-decoration: none;"><i class="fas fa-user"></i> Account</a></li>
                <li style="margin: 10px 0;"><a href="fundaccount.php" style="color: #ecf0f1; text-decoration: none;"><i class="fas fa-wallet"></i> Fund Account</a></li>
                <li style="margin: 10px 0;"><a href="withdrawal.php" style="color: #ecf0f1; text-decoration: none;"><i class="fas fa-arrow-down"></i> Withdrawal</a></li>
                <li style="margin: 10px 0;"><a href="invest.php" style="color: #ecf0f1; text-decoration: none;"><i class="fas fa-chart-line"></i> Invest</a></li>
                <li style="margin: 10px 0;"><a href="history.php" style="color: #ecf0f1; text-decoration: none;"><i class="fas fa-history"></i> Invest History</a></li>
                <li style="margin: 10px 0;"><a href="transaction.php" style="color: #ecf0f1; text-decoration: none;"><i class="fas fa-exchange-alt"></i> Transactions</a></li>
                <li style="margin: 10px 0;"><a href="referral.php" style="color: #ecf0f1; text-decoration: none;"><i class="fas fa-user-friends"></i> Referral</a></li>
                <li style="margin: 10px 0;"><a href="Accountsetting.php" style="color: #ecf0f1; text-decoration: none;"><i class="fas fa-cogs"></i> Account Settings</a></li>
                <li style="margin: 10px 0;"><a href="logout.php" style="color: #ecf0f1; text-decoration: none;"><i class="fas fa-sign-out-alt"></i> Sign Out</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content" style="margin-left: 260px; padding: 20px;">
        <div class="marquee-container" style="margin-bottom: 20px;">
            <div class="marquee" id="crypto-marquee" style="background-color: #34495e; color: #ecf0f1; padding: 10px; border-radius: 5px;">
                Loading prices...
            </div>
        </div>
        <header class="dashboard-header" style="display: flex; align-items: center; margin-bottom: 20px;">
            <div class="profile-header" style="display: flex; align-items: center;">
                <img src="<?php echo isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'profile-pic.jpg'; ?>" alt="Profile Picture" class="profile-pic" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                <div class="user-info">
                    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                </div>
            </div>
        </header>
        <div class="container">
        <h2>Account Settings</h2>
          <!-- Profile Picture Section -->
        <div class="section">
            <h3>Profile Picture</h3>
            <div class="form-group profile-picture">
                <!-- Display the profile picture if it exists -->
                <?php if (isset($_SESSION['profile_pic'])): ?>
                    <img src="<?php echo $_SESSION['profile_pic']; ?>" alt="Profile Picture" id="profile-pic">
                <?php else: ?>
                    <img src="default-avatar.png" alt="Profile Picture" id="profile-pic">
                <?php endif; ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="file" name="profile_pic" id="upload-pic" accept="image/*">
                    <button type="submit">Upload</button>
                </form>
            </div>
            <small>Upload a new profile picture (Max: 100MB, JPG, PNG).</small>
        </div>
        <!-- Personal Details Section -->
        <div class="section">
            <h3>Personal Details</h3>
            <div class="form-group">
                <label for="full-name">Full Name</label>
                <input type="text" id="full-name" placeholder="Enter your full name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Enter your email">
            </div>
        </div>

        <!-- Change Password Section -->
        <div class="section">
            <h3>Change Password</h3>
            <div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" placeholder="Enter current password">
            </div>
            <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" placeholder="Enter new password">
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" id="confirm-password" placeholder="Confirm new password">
            </div>
        </div>

        <!-- Notification Preferences Section -->
        <div class="section">
            <h3>Notification Preferences</h3>
            <div class="form-group">
                <label for="notifications">Receive Notifications</label>
                <select id="notifications">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>

        <!-- Save Button -->
        <div class="form-group">
            <button id="save-button">Save Changes</button>
        </div>
    </div>
    </main>

    <script>
    // Function to fetch crypto prices from CoinGecko API
    function fetchCryptoPrices() {
        const cryptoIds = [
            'bitcoin', 'ethereum', 'ripple', 'litecoin', 'cardano',
            'dogecoin', 'polkadot', 'binancecoin', 'solana', 'tron'
        ];
        const apiUrl = `https://api.coingecko.com/api/v3/simple/price?ids=${cryptoIds.join(',')}&vs_currencies=usd`;

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                updateMarquee(data);
            })
            .catch(error => {
                console.error('Error fetching cryptocurrency prices:', error);
                document.getElementById('crypto-marquee').innerText = 'Error fetching prices. Please try again later.';
            });
    }

    // Function to update the marquee with the fetched cryptocurrency data
    function updateMarquee(data) {
        const cryptocurrencies = [
            { name: "Bitcoin", id: "bitcoin" },
            { name: "Ethereum", id: "ethereum" },
            { name: "Ripple", id: "ripple" },
            { name: "Litecoin", id: "litecoin" },
            { name: "Cardano", id: "cardano" },
            { name: "Dogecoin", id: "dogecoin" },
            { name: "Polkadot", id: "polkadot" },
            { name: "Binance Coin", id: "binancecoin" },
            { name: "Solana", id: "solana" },
            { name: "Tron", id: "tron" },
        ];

        let marqueeText = cryptocurrencies.map(crypto => {
            if (data[crypto.id]) {
                const marketPrice = data[crypto.id].usd;
                const buyPrice = (marketPrice * 1.02).toFixed(2); // Simulate 2% higher for buy price
                const sellPrice = (marketPrice * 0.98).toFixed(2); // Simulate 2% lower for sell price
                return `
                    ${crypto.name}: 
                    <span class="price">Market: $${marketPrice.toLocaleString()}</span>, 
                    <span class="buy">Buy: $${buyPrice}</span>, 
                    <span class="sell">Sell: $${sellPrice}</span> |
                `;
            } else {
                return `${crypto.name}: Data unavailable | `;
            }
        }).join(" ");

        document.getElementById('crypto-marquee').innerHTML = marqueeText;
    }

    // Fetch prices every 5 seconds
    setInterval(fetchCryptoPrices, 5000);
    fetchCryptoPrices(); // Initial fetch on page load
    </script>
    <script>
        document.getElementById('upload-pic').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-pic').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('save-button').addEventListener('click', function() {
    const fullName = document.getElementById('full-name').value;
    const email = document.getElementById('email').value;
    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const notifications = document.getElementById('notifications').value;

    // Validate fields (basic example)
    if (!fullName || !email) {
        alert('Please fill in all required fields.');
        return;
    }
    if (newPassword && newPassword !== confirmPassword) {
        alert('New passwords do not match.');
        return;
    }

    // Simulate saving data (integration with backend needed)
    alert('Settings saved successfully!');
    
    // Reload page to reflect the updated profile picture and session data
    location.reload();
});

    </script>
</body>
</html>
