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
    <title>Investment</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
/* General Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    color: #333;
}

/* Investment Section */
.investment-section {
    max-width: 900px;
    margin: 40px auto;
    background-color: #fff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Section Header */
.section-header {
    text-align: center;
    margin-bottom: 40px;
}

.section-header h1 {
    font-size: 28px;
    color: #2c3e50;
    margin-bottom: 10px;
}

.section-header p {
    font-size: 16px;
    color: #fff;
    background-color: #2c3e50;
    padding: 20px 10px;
}

/* Investment Options */
.investment-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.plan {
    background-color: #fdfdfd;
    border: 1px solid #dfe6e9;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.plan:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.plan h3 {
    font-size: 22px;
    color: #34495e;
    margin-bottom: 10px;
}

.plan p {
    font-size: 16px;
    color: #7f8c8d;
    margin: 10px 0;
}

.plan .select-plan {
    display: inline-block;
    padding: 12px 25px;
    background-color: #2c3e50;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.plan .select-plan:hover {
    background-color: #2980b9;
}

/* Form Section */
.investment-form {
    margin-top: 30px;
}

.investment-form h2 {
    font-size: 22px;
    margin-bottom: 20px;
    text-align: center;
    color: #2c3e50;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-size: 16px;
    margin-bottom: 5px;
    color: #333;
}

input {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #dfe6e9;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s ease;
}

input:focus {
    border-color: #3498db;
}

/* Button Styles */
.btn-invest {
    width: 100%;
    padding: 15px;
    background-color: #2c3e50;
    color: #fff;
    border: none;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-invest:hover {
    background-color: #2980b9;
}

/* Success and Error Messages */
.message {
    margin-top: 20px;
    text-align: center;
    font-size: 16px;
}

.message.success {
    color: #27ae60;
}

.message.error {
    color: #e74c3c;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .investment-options {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }

    .plan {
        padding: 15px;
    }

    .plan h3 {
        font-size: 20px;
    }

    .plan p {
        font-size: 14px;
    }

    .plan .select-plan {
        padding: 10px 20px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .section-header h1 {
        font-size: 24px;
    }

    .plan h3 {
        font-size: 18px;
    }

    .plan p {
        font-size: 13px;
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

    <div class="investment-options">
        <!-- Investment Plan 1 -->
        <div class="plan">
            <h3>Basic Plan</h3>
            <p>Invest: $100 - $999</p>
            <p>Return: 5% weekly</p>
            <button class="select-plan" data-plan="Basic">Invest Now</button>
        </div>

        <!-- Investment Plan 2 -->
        <div class="plan">
            <h3>Standard Plan</h3>
            <p>Invest: $1,000 - $4,999</p>
            <p>Return: 7% weekly</p>
            <button class="select-plan" data-plan="Standard">Invest Now</button>
        </div>

        <!-- Investment Plan 3 -->
        <div class="plan">
            <h3>Premium Plan</h3>
            <p>Invest: $5,000 - $20,000</p>
            <p>Return: 10% weekly</p>
            <button class="select-plan" data-plan="Premium">Invest Now</button>
        </div>

        <!-- Investment Plan 4 -->
        <div class="plan">
            <h3>Gold Plan</h3>
            <p>Invest: $20,001 - $50,000</p>
            <p>Return: 12% weekly</p>
            <button class="select-plan" data-plan="Gold">Invest Now</button>
        </div>

        <!-- Investment Plan 5 -->
        <div class="plan">
            <h3>Platinum Plan</h3>
            <p>Invest: $50,001 - $100,000</p>
            <p>Return: 15% weekly</p>
            <button class="select-plan" data-plan="Platinum">Invest Now</button>
        </div>

        <!-- Investment Plan 6 -->
        <div class="plan">
            <h3>Diamond Plan</h3>
            <p>Invest: $100,001 and above</p>
            <p>Return: 18% weekly</p>
            <button class="select-plan" data-plan="Diamond">Invest Now</button>
        </div>
    </div>
</div>
        <form id="investment-form" class="investment-form" style="display: none;">
            <h2>Invest in <span id="selected-plan"></span></h2>
            <div class="form-group">
                <label for="investment-amount">Enter Investment Amount:</label>
                <input type="number" id="investment-amount" placeholder="Enter amount" required>
            </div>
            <button type="submit" class="btn-invest">Submit Investment</button>
        </form>

        <div id="message" class="message"></div>
    </div>
</main>

    <script>
        // Handle plan selection
document.querySelectorAll('.select-plan').forEach(button => {
    button.addEventListener('click', function() {
        const selectedPlan = this.getAttribute('data-plan');
        document.getElementById('selected-plan').textContent = selectedPlan;
        document.getElementById('investment-form').style.display = 'block';
        scrollToForm();
    });
});

// Handle investment form submission
document.getElementById('investment-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const amount = document.getElementById('investment-amount').value;
    const selectedPlan = document.getElementById('selected-plan').textContent;

    if (amount <= 0 || isNaN(amount)) {
        displayMessage('Please enter a valid investment amount.', 'error');
        return;
    }

    displayMessage(`Investment of $${amount} in the ${selectedPlan} plan has been submitted successfully!`, 'success');
    document.getElementById('investment-form').reset();
    document.getElementById('investment-form').style.display = 'none';
});

// Function to display success or error messages
function displayMessage(message, type) {
    const messageDiv = document.getElementById('message');
    messageDiv.textContent = message;
    messageDiv.className = `message ${type}`;
}

// Scroll to form when plan is selected
function scrollToForm() {
    const form = document.getElementById('investment-form');
    form.scrollIntoView({ behavior: 'smooth' });
}

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
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.select-plan');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const plan = this.getAttribute('data-plan');
                const amount = prompt(`Enter the amount to invest in the ${plan} plan:`);

                if (!amount || isNaN(amount)) {
                    alert('Invalid amount.');
                    return;
                }

                fetch('investment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `plan_name=${encodeURIComponent(plan)}&amount=${encodeURIComponent(amount)}`
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === 'success') {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
<script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.select-plan');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const plan = this.getAttribute('data-plan');
                const amount = prompt(`Enter the amount to invest in the ${plan} plan:`);

                if (!amount || isNaN(amount)) {
                    alert('Invalid amount.');
                    return;
                }

                fetch('invest.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `plan_name=${encodeURIComponent(plan)}&amount=${encodeURIComponent(amount)}`
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === 'success') {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>

</script>

</body>
</html>
