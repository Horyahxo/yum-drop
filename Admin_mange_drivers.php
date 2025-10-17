<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
			<link rel= "stylesheet" type = "text/css" href= "StyleP.css">

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
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
	  .button_out {
      padding: 8px 18px;
      background-color: red; 
      color: #white;
      border: none;
      border-radius: 5px;
      margin-right: 60px;
      margin-top: 20px; /* Add margin to separate it from the navigation */
    }
    h1 {
        color: #white;
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
    .driver-info {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
  
    form label {
        color: #333;
    }
    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
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
<?php
// 1- create connection 
$DBConnect = mysqli_connect("localhost", "root", "", "yum_drop")
    Or die("<p>The database server is not available.</p>");
             

// Fetch and display driver information
$query = "SELECT * FROM Drivers";
$result = mysqli_query($DBConnect, $query);

$name= "" ; 
$age = "";
$phone = "";
$license= "" ; 
$status = "";

if(isset($_POST['name'])){
	$name=$_POST['name'];
}

if(isset($_POST['age'])){
	$age=$_POST['age'];
}

if(isset($_POST['phone'])){
	$phone=$_POST['phone'];
}
if(isset($_POST['license'])){
	$license=$_POST['license'];
}

if(isset($_POST['status'])){
	$status=$_POST['status'];
}

$sqls = "";
if(isset($_POST['btnadd'])){
$sqls = "INSERT INTO Drivers VALUES ('$name', $age,$phone, $license,'$status')";
 mysqli_query($DBConnect, $sqls);

}
if(isset($_POST['btnedit'])){
    $sqls = "UPDATE Drivers SET name= '$name', age= $age, Phone_num= $phone, status= '$status' WHERE license= $license";
    mysqli_query($DBConnect, $sqls);
}

if(isset($_POST['btndelete'])){
    $sqls = "DELETE FROM Drivers WHERE license= $license";
    mysqli_query($DBConnect, $sqls);
}

// close connection 
mysqli_close($DBConnect);

?>

<div class="container">
    <div class="driver-adjust">
	<form  method = "post">
	<label> Name</label>
	<input type = "text" id = "DrName" name = "name">
	<label> Age</label>
	<input type = "text" id = "DrAge" name = "age">
	<label> Phone Number</label>
	<input type = "text" id = "DrPhone" name = "phone">
	<label> license</label>
	<input type = "text" id = "DrLicense" name = "license">
	<label> Status</label>
	<input type = "text" id = "DrStatus" name = "status">
	<button name= "btnadd">Add</button>
		<button name= "btnedit">Edit</button>
	<button name= "btndelete">Delete</button>
	</form>
</div>
<br>
    <div class="driver-info">
      <table>
	  <caption>	<strong>  Driver Info </strong></caption>
	  <tr>
	  <th>name</th>
	  <th>Age</th>
	  <th>Phone Number</th>
	  <th>license</th>
	  <th>status </th>
	  </tr>
	  <?php
	  while( $row = mysqli_fetch_array($result)){
		  echo "<tr>";
		  echo "<td>".$row['name']."</td>";
		    echo "<td>".$row['age']."</td>";
			echo "<td>".$row['Phone_num']."</td>";
		  echo "<td>".$row['license']."</td>";
		    echo "<td>".$row['status']."</td>";
		   echo "</tr>";

	  }
	  ?>
	  </table>
</div>
</body>
</html>