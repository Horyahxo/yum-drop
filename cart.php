
<head>
    <meta charset="UTF-8">
    <title>Yum Drop -  Cart</title>
    <link rel="stylesheet" href="StyleP.css"> <!-- Link to your CSS file -->
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #c4daf2; /* Background color to match provided style */
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background-color: #1a1a4b; /* Dark background for header */
            color: #fff;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header .logo img {
            width: 150px;
        }

        .message {
            text-align: center;
            margin-top: 50px;
            font-size: 20px;
            color: #555;
        }

        .message a {
            color: #1a1a4b;
            text-decoration: none;
            font-weight: bold;
        }

        .message a:hover {
            text-decoration: underline;
        }

        .cart {
            background-color: #fff; /* White background */
            border-radius: 10px; /* Rounded corners */
            padding: 20px; /* Add padding */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add box shadow for depth */
            width: 300px; /* Set width */
            text-align: center; /* Center text */
            margin: 20px auto; /* Center horizontally and add space between cart and message */
        }

        .cart ul {
            list-style-type: none; /* Remove bullet points */
            padding: 0; /* Remove default padding */
        }

        .cart li {
            margin-bottom: 10px; /* Add margin between items */
        }

        .cart li button {
            background-color: #ff5733; /* Custom button color */
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease; /* Smooth transition */
        }

        .cart li button:hover {
            background-color: #e9451e; /* Darker color on hover */
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <a href="Homepage_for_all_logIN.html"><img src="Logo.png" alt="Yum Drop Logo" width="150"></a>
        </div>
        <nav>
            <ul>
                <li><a href="Categories.html">Menu</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="driver_form.html">Become a Driver</a></li>
                <li><a href="contact_us.html">Contact Us</a></li>
            </ul>
        </nav>
        <div class="buttons">
      <a href="login_form.php" class="login">Log in</a>
        </div>
    </header

    <div class="container">
        <?php
        session_start();
        $DBConnect = mysqli_connect("localhost", "root", "", "yum_drop") or die("<p>The database server is not available.</p>");

        // Check if the session variable 'cart' is set and not empty
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            echo "<div class='cart'>";
            echo "<h2>Cart Items</h2>";
            echo "<ul>";
            $totalPrice = 0; // Initialize total price variable
            foreach ($_SESSION['cart'] as $food_id) {
                $sql = "SELECT * FROM food WHERE food_id = $food_id";
                $result = $DBConnect->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $totalPrice += $row['price']; // Add item price to total
                        echo "<li>" . $row['name'] . " - $" . $row['price'] . "</li>";
                    }
                }
            }
            echo "</ul>";
            echo "<p>Total Price: $" . number_format($totalPrice, 2) . "</p>";

            // Form for checkout
            echo "<form method='post' action='check.php'>";
            echo "<h3>Select Payment Method:</h3>";
            echo "<input type='radio' name='payment_method' value='apple_pay' required> Apple Pay<br>";
            echo "<input type='radio' name='payment_method' value='mada' required> Mada<br>";
            echo "<input type='radio' name='payment_method' value='cash' required> Cash<br>";
            echo "<input type='hidden' name='total_price' value='" . number_format($totalPrice, 2) . "'>";
            echo "<button type='submit'>Checkout</button>";
            echo "</form>";

            echo "</div>";

            // Close the database connection
            mysqli_close($DBConnect);
        } else {
            echo "<div class='message'>";
            echo "<p>Your cart is empty. <a href='Categories.html'>Explore our menu</a> and add some delicious items!</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>

</html>