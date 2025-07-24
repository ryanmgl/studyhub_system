<?php
session_start();

if(!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}
?>

<?php
$conn = new mysqli("localhost", "root", "", "studyhub");
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_name'])){
  $newUser = trim($_POST['user_name']);
  if($newUser != ""){
    $newType = $_POST['user_type'];
    $stmt = $conn->prepare("INSERT IGNORE INTO users (username, type)VALUES (?,?)");
    $stmt->bind_param("ss",$newUser, $newType);
    $stmt->execute();
    echo"<p>User '$newUser' is registered successfully.</p>";
  }
};

if(isset($_GET['delete_user'])){
  $deleteUser = $_GET['delete_user'];
  $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
  $stmt->bind_param("s", $deleteUser);
  
  if ($stmt->execute()){
    echo "<p>User '$deleteUser' is removed.</p>";
  }

}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel = "stylesheet" href = "style_admin.php">
</head>
<body>
<a href = "admin_login.php">Logout</a>

<div>
  <div>
  <form method = "post">
    <h1>Register User</h1>
    <input type = "text" name = "user_name" placeholder="Enter name" required>
    <select name = "user_type">
      <option value="basic">Basic</option>
      <option value="vip">VIP</option>
    </select>
    <input type ="submit" value ="Register">
  </form>
  </div>
  

  <div>
    <h1>Active Sessions</h1>
    <table border = "1" cellpadding = "10">
      <thead>
      <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Type</th>
        <th>Study Table</th>
        <th>Time Remaining</th>
        <th>End</th>
      </tr>
      </thead>
    </table>
  </div>

  <div>
    <h1>Remove User</h1>
    <table border = "1" cellpadding = "10">
    <thead>
      <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $count = 1;
      $deleteQuery = $conn->query("SELECT * FROM users ORDER BY username ASC");
      while ($user = $deleteQuery->fetch_assoc()):
      ?>
      <tr>
        <td> <?= htmlspecialchars($user['username']) ?></td>
        <td> <?= htmlspecialchars($user['type'])?></td>
        <td> 
          <a href="?delete_user=<?= urlencode($user['username']) ?>" onclick ="return confirm('Are you sure to remove this user?')">Remove</a>
        </td>
      </tr>

      <?php endwhile;?>
    </tbody>
    </table>
  </div>
</div>

</body>
</html>