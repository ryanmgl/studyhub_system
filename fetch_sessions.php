<?php
$conn = new mysqli("localhost", "root", "", "studyhub");

if($conn->connect_error){
  die("Connection error:".$conn->connect_error);
}

$query = $conn->query("
          SELECT s.*,u.type
          FROM sessions s
          LEFT JOIN users u ON s.username = u.username
          WHERE s.st_status = 'in_use'
          ");

if($query->num_rows == 0){
  echo "<tr><td colspan='8' style='text-align:center;'>No active sessions found.</td></tr>";

}else{
  while($row = $query->fetch_assoc()){
    $start = new DateTime($row['start_time']);
    $now = new DateTime();
    $end = clone($start);
    $end->modify("+".intval($row['time_plan'])."minutes");

    $remaining_secs = $end->getTimeStamp() - $now->getTimeStamp();

    if($remaining_secs > 0){
      $minutes = floor($remaining_secs/60);
      $seconds = $remaining_secs % 60;
      $time_left = "{$minutes}m ". str_pad($seconds, 2, "0", STR_PAD_LEFT). "s time remaining";
    } else{
      echo "Time expired.";
    }


  echo "<tr>";
  echo "<td>". $row['id']. "</td>";
  echo "<td>". htmlspecialchars($row['username']). "</td>";
  echo "<td>". htmlspecialchars($row['type']). "</td>";
  echo "<td>". htmlspecialchars($row['time_plan'])."mins. </td>";
  echo "<td>". htmlspecialchars($row['study_table']). "</td>";
  echo "<td>". htmlspecialchars($row['start_time']). "</td>";
  echo "<td>{$time_left}</td>";
  echo "<td><a href='#' onclick='endSession(". $row['id'] . "); return false;'>End</a> </td>";
  echo "</tr>";
  }
}