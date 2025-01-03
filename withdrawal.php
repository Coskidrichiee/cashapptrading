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
    <title>Withdrawal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
     /* General styles */
.container {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.page-header {
    text-align: center;
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 30px;
    margin-bottom: 10px;
}

.page-header p {
    font-size: 20px;
    color: #fff;
    background-color: #2c3e50;
    padding: 20px 10px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-size: 16px;
    display: block;
    margin-bottom: 5px;
}

input, select, textarea {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

textarea {
    resize: vertical;
}

.btn-submit {
    background-color: #2c3e50;
    color: #fff;
    border: none;
    padding: 15px;
    width: 100%;
    font-size: 18px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-submit:hover {
    background-color: #2980b9;
}

.message {
    text-align: center;
    margin-top: 20px;
    font-size: 16px;
    color: #27ae60;
}

/* Error message styling */
.message.error {
    color: #e74c3c;
}
.payment-modal {
    display: none; /* Hide modals by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    padding-top: 60px;
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close-btn {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 0;
    right: 25px;
    padding: 10px;
}

.close-btn:hover,
.close-btn:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
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
    <header class="page-header">
        <h1>Withdrawal</h1>
        <p>Request a withdrawal from your account.</p>
    </header>

    <form id="withdraw-form" class="withdraw-form" method="POST" action="withdraw.php">
    <div class="form-group">
        <label for="withdraw-amount">Amount to Withdraw:</label>
        <input type="number" id="withdraw-amount" name="amount" placeholder="Enter amount" required>
    </div>

    <div class="form-group">
        <label for="payment-method">Payment Method:</label>
        <select id="payment-method" name="payment-method" required>
            <option value="bank-transfer">Bank Transfer</option>
            <option value="paypal">PayPal</option>
            <option value="bitcoin">Bitcoin</option>
        </select>
    </div>

    <div class="form-group">
        <label for="account-info">Account Details (optional):</label>
        <textarea id="account-info" name="account-info" rows="4" placeholder="Enter payment account details (if needed)"></textarea>
    </div>

    <button type="submit" id="withdraw-button" class="btn-submit">Submit Withdrawal Request</button>
</form>

<!-- Bank Transfer Modal -->
<div id="bank-transfer-modal" class="payment-modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('bank-transfer-modal')">&times;</span>
        <h3>Bank Transfer Details</h3>
        <label for="bank-name">Account Name:</label>
        <input type="text" id="account-name" name="account-name" placeholder="Enter your account name">
        <label for="bank-account">Bank Account Number:</label>
        <input type="text" id="bank-account" name="bank-account" placeholder="Enter your bank account number">
        <label for="bank-name">Bank Name:</label>
        <input type="text" id="bank-name" name="bank-name" placeholder="Enter your bank name">
        <button onclick="saveBankDetails()">Save Bank Details</button>
    </div>
</div>

<!-- PayPal Modal -->
<div id="paypal-modal" class="payment-modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('paypal-modal')">&times;</span>
        <h3>PayPal Account Details</h3>
        <label for="paypal-email">PayPal Email:</label>
        <input type="email" id="paypal-email" name="paypal-email" placeholder="Enter your PayPal email">
        <button onclick="savePayPalDetails()">Save PayPal Details</button>
    </div>
</div>

<!-- Bitcoin Modal -->
<div id="bitcoin-modal" class="payment-modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('bitcoin-modal')">&times;</span>
        <h3>Bitcoin Address</h3>
        <label for="bitcoin-address">Bitcoin Address:</label>
        <input type="text" id="bitcoin-address" name="bitcoin-address" placeholder="Enter your Bitcoin address">
        <button onclick="saveBitcoinDetails()">Save Bitcoin Details</button>
    </div>
</div>

<div id="message" class="message"></div>

</main>

    <script>
        // Handle form submission
document.getElementById("withdraw-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the form from submitting normally
    
    const amount = document.getElementById("withdraw-amount").value;
    const paymentMethod = document.getElementById("payment-method").value;
    const accountInfo = document.getElementById("account-info").value;

    // Simple validation
    if (amount <= 0 || isNaN(amount)) {
        displayMessage("Please enter a valid withdrawal amount.", "error");
        return;
    }

    // Show a confirmation message
    displayMessage(`Withdrawal request for ${amount} via ${paymentMethod} has been submitted successfully!`, "success");

    // Optionally, you can clear the form after submission
    document.getElementById("withdraw-form").reset();
});

// Function to display messages
function displayMessage(message, type) {
    const messageContainer = document.getElementById("message");
    messageContainer.textContent = message;
    messageContainer.className = "message " + (type || "success");
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
        $(document).ready(function () {
    $('#withdraw-form').submit(function (e) {
        e.preventDefault(); // Prevent form submission

        // Collect form data
        var formData = {
            amount: $('#withdraw-amount').val(),
            'payment-method': $('#payment-method').val(),
            'account-info': $('#account-info').val()
        };

        // Send the data to PHP script via AJAX
        $.ajax({
            type: 'POST',
            url: 'withdraw.php', // Your PHP script to handle the form data
            data: formData,
            success: function (response) {
                $('#message').html(response); // Display the response message
            },
            error: function () {
                $('#message').html("There was an error submitting your request. Please try again.");
            }
        });
    });
});

    </script>
    <script>
       document.getElementById('payment-method').addEventListener('change', function() {
    var selectedMethod = this.value;
    openModal(selectedMethod);
});

function openModal(method) {
    // Close all modals first
    closeModal('bank-transfer-modal');
    closeModal('paypal-modal');
    closeModal('bitcoin-modal');
    
    // Show the modal for the selected method
    if (method === 'bank-transfer') {
        document.getElementById('bank-transfer-modal').style.display = 'block';
    } else if (method === 'paypal') {
        document.getElementById('paypal-modal').style.display = 'block';
    } else if (method === 'bitcoin') {
        document.getElementById('bitcoin-modal').style.display = 'block';
    }
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function saveBankDetails() {
    // Correcting the variable name for accountName
    var bankAccount = document.getElementById('bank-account').value;
    var bankName = document.getElementById('bank-name').value;
    var accountName = document.getElementById('account-name').value;  // Fixed the duplicate variable declaration

    // Optionally, send the data to the server via AJAX or store in a hidden field
    document.getElementById('account-info').value = `Account Name: ${accountName}, Bank Account: ${bankAccount}, Bank Name: ${bankName}`;
    closeModal('bank-transfer-modal');
}

function savePayPalDetails() {
    var paypalEmail = document.getElementById('paypal-email').value;

    document.getElementById('account-info').value = `PayPal Email: ${paypalEmail}`;
    closeModal('paypal-modal');
}

function saveBitcoinDetails() {
    var bitcoinAddress = document.getElementById('bitcoin-address').value;

    document.getElementById('account-info').value = `Bitcoin Address: ${bitcoinAddress}`;
    closeModal('bitcoin-modal');
}


    </script>
</body>
</html>
