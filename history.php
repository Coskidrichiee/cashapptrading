<?php
session_start();

// Redirect to sign-in page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "broker_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch investment records
$sql = "SELECT user_id, plan_name, amount_invested, return_percentage, investment_date, status FROM investments";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment History</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        /* General styles */
/* Investment Section */
.investment-section {
    background: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.investment-section header {
    margin-bottom: 20px;
}

.investment-section table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.investment-section table th, .investment-section table td {
    text-align: left;
    padding: 10px;
    border: 1px solid #ddd;
}

.investment-section table th {
    background-color: #34495e;
    color: #ecf0f1;
}

.investment-section table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.investment-section table tr:hover {
    background-color: #ddd;
}

.investment-section .status {
    padding: 5px 10px;
    border-radius: 5px;
    text-align: center;
}

.status.active {
    background-color: #27ae60;
    color: white;
}

.status.pending {
    background-color: #f39c12;
    color: white;
}

.status.failed {
    background-color: #e74c3c;
    color: white;
}


/* Responsive styles */
@media (max-width: 768px) {

    .investment-section table th, .investment-section table td {
        display: block;
        width: 100%;
        box-sizing: border-box;
    }

    .investment-section table tr {
        margin-bottom: 15px;
        display: block;
        border: 1px solid #ddd;
    }

    .investment-section table th {
        background-color: transparent;
        color: #34495e;
        font-weight: bold;
    }

    .investment-section table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }

    .investment-section table td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        text-align: left;
        font-weight: bold;
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
        <div class="investment-section">
    <header class="section-header">
        <h1>Investment Plans</h1>
        <p>Choose an investment plan and start growing your wealth.</p>
    </header>
    <div class="container">
        <div class="header">
            <h1>Investment History</h1>
            <p>Track your past investments and their statuses.</p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>User Id</th>
                    <th>Plan Name</th>
                    <th>Amount Invested</th>
                    <th>Return (%)</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if records are available
                if ($result->num_rows > 0) {
                    // Output data for each row
                    while ($row = $result->fetch_assoc()) {
                        // Determine status class
                        $statusClass = strtolower($row["status"]);
                        echo "<tr>
                            <td data-label='Investment ID'>{$row['user_id']}</td>
                            <td data-label='Plan Name'>{$row['plan_name']}</td>
                            <td data-label='Amount Invested'>\${$row['amount_invested']}</td>
                            <td data-label='Return (%)'>{$row['return_percentage']}%</td>
                            <td data-label='Date'>{$row['investment_date']}</td>
                            <td data-label='Status' class='status {$statusClass}'>{$row['status']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No investments found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
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

</body>
</html>
<?php
// Close the database connection
$conn->close();
?>
