<?php
// Start or resume a session
session_start();

// Database connection
$DBConnect = mysqli_connect("localhost", "root", "", "yum_drop")
    or die("<p>The database server is not available.</p>");

// Check if the place_order action is triggered
if (isset($_POST['place_order'])) {
    // Initialize variables
    $total_amount = 0;
    $order_id = null;

    // Calculate total amount
    foreach ($_SESSION['cart'] as $food_id) {
        $query = "SELECT price FROM food WHERE food_id = $food_id";
        $result = mysqli_query($DBConnect, $query);
        $row = mysqli_fetch_array($result);
        $total_amount += $row['price'];
    }

    // Insert order into the database
    $status = "Placed";
    $query = "INSERT INTO orders (status, total_amount) VALUES ('$status', $total_amount)";
    mysqli_query($DBConnect, $query);
    $order_id = mysqli_insert_id($DBConnect);

    // Clear the cart after placing the order
    $_SESSION['cart'] = array();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Yum Drop - Food Items</title>
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

        footer {
            background-color: lightpink; 
            color: navy;
            padding: 20px 0;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            text-align: center;
        }

        footer h2 {
            margin: 0;
            font-size: 1.5em;
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
    </style>
</head>

<body>

    <!-- Header section -->
    <header>
        <div class="logo">
            <a href="#"><img src="Logo.png" alt="Yum Drop Logo"></a>
        </div>
        <h1>Yum Drop - Food Items</h1>
    </header>

    <!-- Main content section -->
    <div class="container main">
        <?php
        // Fetch food items from the database
        $query = "SELECT * FROM food";
        $result = mysqli_query($DBConnect, $query);

        // Display food items in the specified format
        while ($row = mysqli_fetch_array($result)) {
            echo '<div class="food-item">';
            echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' alt='{$row['name']}'>";
            echo "<span>{$row['name']}</span>";
            echo "<span class='description'>{$row['description']}</span>";
            echo "<span>Rating: {$row['rating']}</span>";
            echo "<span>Price: {$row['price']}</span>";
            // Add a form to submit the item to the cart
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='food_id' value='{$row['food_id']}'>";
            echo "<button class='add-to-cart' type='submit' name='add_to_cart'>Add to Cart</button>"; // Add to Cart button
            echo "</form>";
            echo '</div>';
        }
        ?>
    </div>

    <!-- Place Order -->
    <div class="container">
        <h2>Place Order</h2>
        <form action="" method="post">
            <button type="submit" name="place_order">Place Order</button>
        </form>
    </div>


</body>
</html>
