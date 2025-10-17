<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Food Management</title>
			<link rel= "stylesheet" type = "text/css" href= "StyleP.css">

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #c4daf2;
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

        h1 {
            color: #white;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form button {
            padding: 10px 15px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        form button:hover {
            background-color: #555;
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
        <h1>Food Management</h1>
        <?php
        // Database connection
        $DBConnect = mysqli_connect("localhost", "root", "", "yum_drop")
            or die("<p>The database server is not available.</p>");
        echo "<p>Successfully connected to the database server.</p>";

        // Initialize variables
        $name = "";
        $category = "";
        $description = "";
        $price = "";
        $rating = "";
        $food_id = "";
        $image_data = "";

        // Handle form submissions
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["name"])) {
                $name = $_POST["name"];
            }

            if (isset($_POST["category"])) {
                $category = $_POST["category"];
            }

            if (isset($_POST["description"])) {
                $description = $_POST["description"];
            }

            if (isset($_POST["price"])) {
                $price = $_POST["price"];
            }

            if (isset($_POST["rating"])) {
                $rating = $_POST["rating"];
            }

            if (!empty($_FILES["image"]["tmp_name"])) {
        $image_data = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
    }
            if (isset($_POST["food_id"])) {
                $food_id = $_POST["food_id"];
            }

            // Handle add, edit, delete actions
            if (isset($_POST["btnadd"])) {
                $sql = "INSERT INTO food (name, category, description, price, rating, image)
                        VALUES ('$name', '$category', '$description', $price, $rating, '$image_data')";
                mysqli_query($DBConnect, $sql);
                echo "<p>Food item added successfully!</p>";
            } elseif (isset($_POST["btnedit"])) {
                $sql = "UPDATE food SET name='$name', category='$category', description='$description',
                         price=$price, rating=$rating, image='$image_data'
                         WHERE food_id=$food_id";
                mysqli_query($DBConnect, $sql);
                echo "<p>Food item updated successfully!</p>";
            } elseif (isset($_POST["btndelete"])) {
                $sql = "DELETE FROM food WHERE food_id=$food_id";
                mysqli_query($DBConnect, $sql);
                echo "<p>Food item deleted successfully!</p>";
            }
        }

        // Fetch food items from the database
        $query = "SELECT * FROM food";
        $result = mysqli_query($DBConnect, $query);

        // Close the database connection
        mysqli_close($DBConnect);
        ?>
<section class="main">

        <form method="POST" enctype="multipart/form-data">
            <h2>Add/Edit/Delete Food Item</h2>
            <label>Food ID (for editing/deleting)</label>
            <input type="number" name="food_id" placeholder="Enter food ID">
            <label>Name</label>
            <input type="text" name="name" placeholder="Enter food name">
            <label>Category</label>
            <input type="text" name="category" placeholder="Enter food category">
            <label>Description</label>
            <input type="text" name="description" placeholder="Enter food description">
            <label>Price</label>
            <input type="number" step="0.01" name="price" placeholder="Enter food price">
            <label>Rating</label>
            <input type="number" step="0.1" name="rating" placeholder="Enter food rating">
            <label>Image</label>
            <input type="file" name="image" accept="image/*">
            <button name="btnadd">Add</button>
            <button name="btnedit">Edit</button>
            <button name="btndelete">Delete</button>
        </form>

        <div class="food-info">
            <table>
                <caption><strong>Food Items</strong></caption>
                <tr>
                    <th>Food ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Rating</th>
                    <th>Image</th>
                </tr>
                <?php
                // Display food items
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>{$row['food_id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['category']}</td>";
                    echo "<td>{$row['description']}</td>";
                    echo "<td>{$row['price']}</td>";
                    echo "<td>{$row['rating']}</td>";
                    echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' width='200' height='200'></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
	</section >

</body>

</html>