<?php
session_start();

if(isset($_SESSION['admin_logged_in'])){
  header("Location: admin.php");
  exit();
}
$admin_username = 'admin1';
$admin_password = 'admin1234';

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $username = $_POST['username'];
  $password = $_POST['password'];

  if($admin_username == $username && $admin_password == $password){
    $_SESSION['admin_logged_in'] = true;
    header("Location: admin.php");
    exit();
  } else {
      $error = "Invalid username or password.";
  }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title> Study Hub Admin Login</title>
    <link rel = "stylesheet" href ="style_admin.css">
  </head>
  <body>
    <div class = "login-page">
      <div class = "login-container">
    <?php if (isset($error)) echo "<p>$error</p>"?>
        <form class = "login" method = "post">
          <h1>Study Hub Admin Login</h1>
          
            <input type = "text" name = "username" placeholder="Username" required>
            <input type = "password" name = "password" placeholder="Password" required>
            <input type = "submit" value = "Login">
          
        </form>
  </div>
</div>
</body>

</html>