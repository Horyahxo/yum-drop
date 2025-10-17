
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form Submission Confirmation</title>
    	<link rel= "stylesheet" type = "text/css" href= "StyleP.css">

  <style>
    .main {
      background-color: #c4daf2;
      padding: 50px 20px; 
      display: flex; 
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #c4daf2;
      margin: 0;
      padding: 0;
    }
    .container1 {
      width: 80%;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
    }
    h1 {
      text-align: center;
      color: navy; 
    }
    p {
      text-align: center;
      font-size: 20px;
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
<section class="main">

  <div class="container1">
    <h1>Form Submission Confirmation</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $fullname = $_POST['fullname'];
   
      echo "<p>Thank you, $fullname! Your form has been submitted. Our team will contact you with the result.</p>";
    } else {
      echo "<p>Sorry, there was an error processing your request.</p>";
    }
    ?>
  </div>
  </section>


</body>
</html>
