<?php
session_start();

// Redirect to sign-in page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <!-- Include Chart.js for the Bitcoin chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        <div class="dashboard-body">
    <div id="account-details" class="account-details">
        <div class="account-item">
            <i class="fas fa-wallet"></i>
            <p>Account Balance</p>
            <span id="wallet-balance">$0</span>
        </div>
        <div class="account-item">
            <i class="fas fa-chart-line"></i>
            <p>Active Trade</p>
            <span id="active-trade">$0</span>
        </div>
        <div class="account-item">
            <i class="fas fa-dollar-sign"></i>
            <p>Total Profit</p>
            <span id="total-profit">$0</span>
        </div>
        <div class="account-item">
            <i class="fas fa-user-friends"></i>
            <p>Affiliate Bonus</p>
            <span id="affiliate-bonus">$0</span>
        </div>
        <div class="account-item">
            <i class="fas fa-cogs"></i>
            <p>Total Trade</p>
            <span id="total-trade">$0</span>
        </div>
        <div class="referral-section">
            <i class="fas fa-gift"></i>
            <p>Referrals</p>
            <span id="referral-earnings">$0</span>
        </div>
    </div>
</div>
            </div>

            <!-- Cryptocurrency Chart Section -->
            <div class="bitcoin-chart">
                <h2>Cryptocurrency Trading</h2>
                <canvas id="crypto-chart"></canvas>
            </div>
        </div>
    </main>
     <!-- Alert Boxes -->
     <div id="alert1" class="alert-box">Smith from United States withdraw $3,000</div>
    <div id="alert2" class="alert-box">Joan from South Africa withdraw $2,500</div>
    <div id="alert3" class="alert-box">Martha from Philippines withdraw $1,500</div>
    <div id="alert4" class="alert-box">Helena from Portugal withraw $7,500</div>
    <div id="alert5" class="alert-box">Paul from United Kingdom withdraw $12,000 </div>
    <div id="alert6" class="alert-box">James from Germany withdraw $8,000</div>

    <script>
        // Chart.js code for displaying Bitcoin price chart
       // Chart.js code for displaying cryptocurrency prices
const ctx = document.getElementById('crypto-chart').getContext('2d');
const cryptoChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'], // Month labels
        datasets: [
            {
                label: 'Bitcoin Price (USD)',
                data: [45000, 47000, 46000, 48000, 51000, 54000, 56000, 58000, 60000, 62000],
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            },
            {
                label: 'Ethereum Price (USD)',
                data: [1500, 1600, 1550, 1620, 1650, 1700, 1800, 1900, 2000, 2100],
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2,
                fill: false
            },
            {
                label: 'Ripple Price (USD)',
                data: [0.8, 0.85, 0.9, 0.95, 1.0, 1.1, 1.2, 1.3, 1.4, 1.5],
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: false
            },
            {
                label: 'Litecoin Price (USD)',
                data: [180, 190, 185, 200, 210, 220, 230, 240, 250, 260],
                borderColor: 'rgba(255, 159, 64, 1)', // Light orange color
                borderWidth: 2,
                fill: false
            },
            {
                label: 'Cardano Price (USD)',
                data: [1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 1.7, 1.8, 1.9, 2.0],
                borderColor: 'rgba(54, 162, 235, 1)', // Blue color
                borderWidth: 2,
                fill: false
            },
            {
                label: 'Dogecoin Price (USD)',
                data: [0.05, 0.06, 0.07, 0.08, 0.09, 0.1, 0.12, 0.14, 0.16, 0.18],
                borderColor: 'rgba(255, 205, 86, 1)', // Yellow color
                borderWidth: 2,
                fill: false
            },
            {
                label: 'Tether Price (USD)',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1], // Tether is pegged to 1 USD
                borderColor: 'rgba(0, 255, 255, 1)', // Cyan color
                borderWidth: 2,
                fill: false
            },
            {
                label: 'Binance Coin (BNB) Price (USD)',
                data: [350, 380, 370, 400, 420, 440, 460, 480, 500, 520],
                borderColor: 'rgba(255, 223, 0, 1)', // Yellow color for Binance Coin
                borderWidth: 2,
                fill: false
            },
            {
                label: 'Solana Price (USD)',
                data: [120, 130, 125, 140, 150, 160, 170, 180, 190, 200],
                borderColor: 'rgba(0, 143, 255, 1)', // Solana's blue color
                borderWidth: 2,
                fill: false
            },
            {
               label: 'Polkadot Price (USD)',
               data: [20, 22, 21, 23, 25, 26, 28, 30, 32, 34],
               borderColor: 'rgba(255, 105, 180, 1)', // Pink color
               borderWidth: 2,
               fill: false
            }

        ]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Months'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Price (USD)'
                }
            }
        }
    }
});

        // Toggle Account Details when 'Account' link is clicked
        document.getElementById('account-link').addEventListener('click', function() {
            document.getElementById('account-details').style.display = 'block';
            document.querySelector('.bitcoin-chart').style.display = 'block';
        });

         // Sign out functionality
         document.getElementById('sign-out').addEventListener('click', function() {
            alert("You have been signed out!");
            window.location.href = "index.html";
        });
    </script>
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
document.addEventListener("DOMContentLoaded", function() {
    fetch('get_dashboard_data.php?timestamp=' + new Date().getTime()) // Add a timestamp to avoid caching
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                // Update dashboard with the data fetched from the backend
                document.getElementById("wallet-balance").textContent = `$${data.wallet_balance}`;
                document.getElementById("active-trade").textContent = `$${data.active_trade}`;
                document.getElementById("total-profit").textContent = `$${data.total_profit}`;
                document.getElementById("affiliate-bonus").textContent = `$${data.affiliate_bonus}`;
                document.getElementById("total-trade").textContent = `$${data.total_trade}`;
                document.getElementById("referral-earnings").textContent = `$${data.referral_earnings}`;
            }
        })
        .catch(error => console.error('Error fetching data:', error));
});

</script>
<script>
    document.getElementById('fund-account-btn').addEventListener('click', function (e) {
    e.preventDefault(); // Prevent the default anchor behavior
    document.getElementById('fund-account-section').scrollIntoView({ behavior: 'smooth' });
});

</script>
<script>
    // Alert IDs and index
    const alerts = ['alert1', 'alert2', 'alert3', 'alert4', 'alert5', 'alert6'];
    let currentIndex = 0;

    // Function to show and hide alerts sequentially
    function showAlert() {
        // Get the current alert element
        const alertId = alerts[currentIndex];
        const alertBox = document.getElementById(alertId);

        // Show the current alert
        alertBox.style.display = 'block';

        // Hide it after 5 seconds
        setTimeout(() => {
            alertBox.style.display = 'none';

            // Move to the next alert
            currentIndex = (currentIndex + 1) % alerts.length;

            // Call showAlert again for the next alert
            setTimeout(showAlert, 1000); // 1 second gap between alerts
        }, 5000); // Display duration: 5 seconds
    }

    // Start the alert sequence
    showAlert();
</script>


</body>
</html>
