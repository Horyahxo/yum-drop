<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="StyleP.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

     
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .button_out {
            padding: 8px 18px;
            background-color: red;
            color: #fff;
            border: none;
            border-radius: 5px;
            margin-right: 60px;
            margin-top: 20px; /* Add margin to separate it from the navigation */
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <a href="Homepage_for_admin_logOUT.html"><img src="Logo.png" alt="Yum Drop Logo" width="150"></a>
        </div>
        <h1>Admin Panel</h1>
        <div class="button_out">
            <a href="logout.php">Log out</a>
        </div>
    </header>

    <div class="container">
        <h2>Order Information</h2>

        <?php
        // Create connection
        $DBConnect = mysqli_connect("localhost", "root", "", "yum_drop")
            or die("<p>The database server is not available.</p>");

        // Query to fetch orders
        $query = "SELECT * FROM orders";
        $result = mysqli_query($DBConnect, $query);

        if ($result) {
            echo "<table>";
            echo "<caption><strong>Order Info</strong></caption>";
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Status</th>";
            echo "<th>Total Amount</th>";
            echo "<th>Order Date</th>";
            echo "<th>Payment Method</th>";
            echo "</tr>";

            // Loop through the results and display each order
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['order_id'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>$" . number_format($row['total_amount'], 2) . "</td>";
                echo "<td>" . $row['order_date'] . "</td>";
                echo "<td>" . $row['payment_method'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No orders found.</p>";
        }

        // Close connection
        mysqli_close($DBConnect);
        ?>
    </div>
</body>
</html>