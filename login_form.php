<?php
session_start();

@include 'config.php';

if(isset($_SESSION['admin_name'])){
   header('location: Homepage_for_admin_logOUT.html');
   exit;
}

if(isset($_SESSION['user_name'])){
   header('location: Homepage_for_all_logOUT.html');
   exit;
}

if(isset($_POST['submit'])) {

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']); 

   $select = "SELECT * FROM user_database WHERE email = '$email' AND password = '$pass'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0) {
     $row = mysqli_fetch_assoc($result);

      if($row['user_type'] == 'admin'){
       $_SESSION['admin_name'] = $row['name'];
       header('location: Homepage_for_admin_logOUT.html');
       exit;
     } elseif($row['user_type'] == 'user'){
       $_SESSION['user_name'] = $row['name'];
       header('location: Homepage_for_all_logOUT.html');
       exit;
     }
   } else {
     $error = 'Incorrect email or password!!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>
   <link rel="stylesheet" href="CSSstyle.css">
   <style>
     body {
      font-family: Arial, sans-serif;
      background-color: #fff; 
    }
   </style>
</head>
<body>
<div class="form-container">
   <form action="" method="post">
      <h3>Login Now</h3>
       <?php 
       if(isset($error)) {
          echo '<div class="error-msg">' . $error . '</div>';
       }
       ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login Now" class="form-btn">
      <p>Don't have an account? <a href="register_form.php">Register Now</a></p>
   </form>
</div>
</body>
</html>
