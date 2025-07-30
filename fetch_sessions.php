<?php
$conn = new mysqli("localhost", "root", "", "studyhub");

if($conn->connect_error){
  die("Connection error:".$conn->connect_error);
}

$query = $conn->query("
          SELECT s.*,u.type
          FROM sessions s
          LEFT JOIN users u ON s.user_name = u.username
          WHERE status = 'in_use'
          ");

while($row = $query->fetch_assoc()){
  $start = new DateTime($row['start_time']);
  $now = new DateTime();
  $end = clone($start);
  $end->modify("+".intval($row['time_plan']."minutes"));

  $remaining_secs = $end->getTimeStamp() - $now->getTimeStamp();

  if($remaining_secs > 0){
    $minutes = floor($remaining_secs/60);
    $seconds = $remaining_secs % 60;
    $time_left = "{$minutes}m". str_pad($seconds, 2, "0", STR_PAD_LEFT). "s time remaining";
  } else{
    echo "Time expired.";
  }


echo "<tr>";
echo "<td>". $row['id']. "</td>";
echo "<td>". htmlspecialchars($row['user_name']). "</td>";
echo "<td>". htmlspecialchars($row['type']). "</td>";
echo "<td>". htmlspecialchars($row['time_plan'])."mins. </td>";
echo "<td>". htmlspecialchars($row['study_table']). "</td>";
echo "<td>". $start_time. "</td>";
echo "<td>". $time_left. "</td>";
echo "<td> <a href='admin.php'?end=".$row['id']." onclick = 'return confirm(\"Are you sure you want to end the session?\")'</td>";

echo "</tr>";
}
?>