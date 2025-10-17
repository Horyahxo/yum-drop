<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Yum Drop - Food Items</title>
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



        .main {
            margin-top: 70px;
            background-color: #c4daf2; 
            color: navy;
            padding: 20px 20px; 
            display: flex;
            flex-wrap: wrap; /* Ensure items wrap to next line if not enough space */
            justify-content: center; 
            gap: 40px; /* Gap between food items */
        }

        .food-item {
            background-color: #fff; /* White background for food items */
            border-radius: 10px; /* Rounded corners */
            padding: 20px; /* Add padding */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add box shadow for depth */
            width: 300px; /* Set width for each food item */
            text-align: center; /* Center text */
        }

        .food-item img {
            width: 200px;
            height: 200px;
            margin: 0 auto; /* Center image */
            border-radius: 50%; /* Make image round */
            object-fit: cover; /* Maintain aspect ratio */
        }

        .food-item .description {
            margin: 10px 0; /* Adjust margin */
        }

        .food-item span {
            display: block;
            margin-bottom: 10px; /* Margin between elements */
        }

        .add-to-cart {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .add-to-cart:hover {
            background-color: #45a049;
        }
		.cart {
    background-color: #fff; /* White background */
    border-radius: 10px; /* Rounded corners */
    padding: 20px; /* Add padding */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add box shadow for depth */
    width: 300px; /* Set width */
    text-align: center; /* Center text */
    margin-top: 20px; /* Add space between cart and food items */
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

    <!-- Header section -->
    
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
      <a href="login_form" class="login">Log in</a>
    </div>

        <h1>Yum Drop - Food Items</h1>
    </header>

    <!-- Main content section -->
    <div class="container main">
        <?php
        // Database connection
        $DBConnect = mysqli_connect("localhost", "root", "", "yum_drop")
            or die("<p>The database server is not available.</p>");

        // Function to add item to cart
        function addToCart($food_id) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            array_push($_SESSION['cart'], $food_id);
        }

        // Function to remove item from cart
        function removeFromCart($food_id) {
            if (($key = array_search($food_id, $_SESSION['cart'])) !== false) {
                unset($_SESSION['cart'][$key]);
            }
        }

        // Check if add to cart button is clicked
        if (isset($_POST['add_to_cart'])) {
            $food_id = $_POST['food_id'];
            addToCart($food_id);
        }

        // Check if delete button is clicked
        if (isset($_POST['delete'])) {
            $food_id = $_POST['food_id'];
            removeFromCart($food_id);
        }

        // Fetch food items from the database
        $query = "SELECT * FROM food WHERE category = 'sweets'";
        $result = mysqli_query($DBConnect, $query);

        // Display food items in the specified format
        while ($row = mysqli_fetch_array($result)) {
            echo '<div class="food-item">';
            echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' alt='{$row['name']}'>";
            echo "<span>{$row['name']}</span>";
            echo "<span class='description'>{$row['description']}</span>";
            echo "<span>Rating: {$row['rating']}</span>";
            echo "<span>Price: {$row['price']}</span>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='food_id' value='" . $row['food_id'] . "'>";
            echo "<button type='submit' name='add_to_cart' class='add-to-cart'>Add to Cart</button>";
            echo "</form>";
            echo '</div>';
        }

        // Display items in the cart

echo "<div class='cart'>";
echo "<h2>Cart Items</h2>";

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo "<ul>";
    $totalPrice = 0; // Initialize total price variable
    foreach ($_SESSION['cart'] as $food_id) {
        $sql = "SELECT * FROM food WHERE food_id = $food_id";
        $result = $DBConnect->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalPrice += $row['price']; // Add item price to total
                echo "<li>" . $row['name'] . " - $" . $row['price'] . " <form method='post' action=''>
                      <input type='hidden' name='food_id' value='" . $row['food_id'] . "'>
                      <button type='submit' name='delete'>Delete</button></form></li>";
            }
        }
    }
    echo "</ul>";
    echo "<p>Total Price: $" . number_format($totalPrice, 2) . "</p>"; // Display total price
} else {
    echo "<p>Your cart is empty.</p>";
}

echo "</div>";

        // Close the database connection
        mysqli_close($DBConnect);
        ?>
    </div>

   

</body>

</html>
