<?php
$conn = new mysqli('localhost', 'root', '', 'studyhub');

if($conn->connect_error){
  die("Connection failed: ". $conn->connect_error);
}
$activeCheck = $conn->query("SELECT COUNT(*) as count FROM sessions WHERE st_status = 'in_use'");
$activeRow = $activeCheck->fetch_assoc();
$hasActive = $activeRow['count'] > 0;

if ($hasActive) {
    echo "<script>alert('Report generation blocked. There are still active sessions.'); window.location.href = 'admin.php';</script>";
    exit;
}
date_default_timezone_set("Asia/Manila");
$today = date("Y-m-d");

$sql = "
  SELECT s.*, u.type
  FROM sessions s
  LEFT JOIN users u ON s.username = u.username
  WHERE DATE(s.start_time) = '$today' AND s.st_status = 'ended'
";

$result = $conn->query($sql);

$totalRevenue = 0;
$lines = [];
$lines[] = "Daily Report for $today";
$lines[] = "=========================";

while($row = $result->fetch_assoc()){
  $start = strtotime($row['start_time']);
  $end = strtotime($row['end_time']); 
  $usedMinutes = ceil(($end-$start) / 60);
  $rate = ($row['type'] === 'basic')? 0.50 : 0.40;
  $cost = $usedMinutes * $rate;
  $totalRevenue += $cost;

  $lines[] = "User: {$row['username']} | Type: {$row['type']} | Study Table: {$row['study_table']} | Used: {$usedMinutes} mins | ₱". number_format($cost, 2);
}

$lines[] = "==========================";
$lines[] = "Total revenue for $today: ₱" . number_format($totalRevenue, 2);

$report = implode("\n",$lines);

$filename = "daily_report_" . $today . ".txt";
file_put_contents($filename, $report);

header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"$filename\"");
readfile($filename);
unlink($filename);
exit;






?>