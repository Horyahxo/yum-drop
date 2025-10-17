<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Yum Drop - Cart</title>
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
            padding: 20px; /* Add padding */
        }
  
        header {
            background-color: #1a1a4b; /* Dark background for header */
            color: #fff;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px; /* Add margin bottom */
        }

        header .logo img {
            width: 150px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        .cart-container {
            display: flex;
            justify-content: center;
        }

        .cart {
            background-color: #fff; /* White background */
            border-radius: 10px; /* Rounded corners */
            padding: 20px; /* Add padding */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add box shadow for depth */
            width: 300px; /* Set width */
            text-align: center; /* Center text */
            margin-right: 20px; /* Add margin */
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

        .bill {
            margin-top: 40px; /* Add margin on top */
            padding: 20px; /* Add padding */
            background-color: #fff; /* White background */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add box shadow for depth */
            width: 300px; /* Set width */
            text-align: center; /* Center text */
        }

        .bill h2 {
            margin-bottom: 10px; /* Add margin bottom */
        }

        .bill p {
            margin-bottom: 20px; /* Add margin bottom */
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
    </header>

    <div class="container">
        <div class="cart-container">
            <div class="cart">
                <?php
                session_start();
                $DBConnect = mysqli_connect("localhost", "root", "", "yum_drop") or die("<p>The database server is not available.</p>");

                // Check if the session variable 'cart' is set and not empty
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
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

                    // If form is submitted, update payment method
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $paymentMethod = $_POST['payment_method'];
                        // Insert order into the database
                        $status = "Pending";
                        $query = "INSERT INTO orders (status, total_amount, payment_method) VALUES ('$status', $totalPrice, '$paymentMethod')";
                        mysqli_query($DBConnect, $query) or die(mysqli_error($DBConnect));

                        // Retrieve order details
                        $orderId = mysqli_insert_id($DBConnect);
                        $orderDate = date("Y-m-d H:i:s");

                        // Print bill
                        echo "<div class='bill'>";
                        echo "<h2>Bill</h2>";
                        echo "<p>Order ID: " . $orderId . "</p>";
                        echo "<p>Order Date: " . $orderDate . "</p>";
                        echo "<p>Total Amount: $" . number_format($totalPrice, 2) . "</p>";
                        echo "<p>Payment Method: " . $paymentMethod . "</p>";
                        echo "</div>";
                    } else {
                        // Display form to choose payment method
                        echo "<form method='post'>";
                        echo "<label for='payment_method'>Select Payment Method:</label><br>";
                        echo "<select id='payment_method' name='payment_method'>";
                        echo "<option value='Cash on Delivery'>Cash on Delivery</option>";
                        echo "<option value='Credit Card'>Credit Card</option>";
                        // Add more payment options as needed
                        echo "</select><br><br>";
                        echo "<input type='submit' value='Submit'>";
                        echo "</form>";
                    }
                } else {
                    echo "<p>Your cart is empty.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
