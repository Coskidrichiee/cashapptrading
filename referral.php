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
    <title>Referral</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>

        /* Referral Section */
        .referral-section {
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
            border-radius: 8px;
            text-align: center;
            display: block;
            visibility: visible;
            color: #000;  /* Set text color to black */
            background-color: #fff;  /* Set background color to white */
        }

        /* How It Works Section */
        .how-it-works {
            text-align: left;
            margin-top: 20px;
        }

        .how-it-works h3 {
            color: #333;
        }

        .how-it-works ol {
            padding-left: 20px;
            text-align: left;
        }

        .how-it-works li {
            margin: 5px 0;
        }

        /* Rewards Section */
        .rewards-section {
            margin-top: 30px;
            text-align: left;
        }

        .rewards-section h3 {
            color: #333;
        }

        .rewards-section ul {
            padding-left: 20px;
            text-align: left;
        }

        .rewards-section li {
            margin: 5px 0;
        }

        /* Referral Box */
        .referral-box {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            gap: 15px;
        }

        /* Referral Icon */
        .referral-icon {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        /* Referral Link Box */
        .referral-link-box {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Referral Link Input */
        #referralLink {
            padding: 10px;
            width: 250px;
            text-align: center;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Button */
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
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

        <!-- Referral Section -->
        <div id="referralSection" class="referral-section">
            <h2>Your Referral Program</h2>
            <p>Invite friends to join and earn rewards!</p>

            <!-- How it Works Section -->
            <div class="how-it-works">
                <h3>How It Works</h3>
                <ol>
                    <li><strong>Step 1:</strong> Share your unique referral link with friends.</li>
                    <li><strong>Step 2:</strong> When your friend registers using your link and starts trading, you earn rewards.</li>
                    <li><strong>Step 3:</strong> The more friends you refer, the more rewards you get!</li>
                </ol>
            </div>

            <!-- Rewards Section -->
            <div class="rewards-section">
                <h3>What You Get</h3>
                <p>For every successful referral, you earn:</p>
                <ul>
                    <li><strong>$100</strong> for each successful trade made by your referred friend.</li>
                    <li><strong>Exclusive access</strong> to special promotions and bonuses.</li>
                    <li><strong>Priority support</strong> for your account-related queries.</li>
                </ul>
            </div>

            <!-- Referral Link & Icon -->
            <div class="referral-box">
                <img src="images/ref.png" alt="Referral Icon" class="referral-icon">
                <div class="referral-link-box">
                    <input type="text" id="referralLink" readonly>
                    <button onclick="copyReferralLink()">Copy Referral Link</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Function to generate and display the referral link
        window.onload = function() {
            // Placeholder user ID, replace with actual user ID from session or server-side
            const userId = <?php echo $_SESSION['user_id']; ?>;

            // Generate referral link
            const referralLink = `https://finexo.com/referral?ref=${userId}`;

            // Set the referral link in the input box
            document.getElementById('referralLink').value = referralLink;
        }

        // Function to copy the referral link to clipboard
        function copyReferralLink() {
            const referralLinkInput = document.getElementById('referralLink');
            
            // Select and copy the referral link
            referralLinkInput.select();
            referralLinkInput.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand('copy');
            
            // Alert the user that the link is copied
            alert("Referral link copied to clipboard!");
        }

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
