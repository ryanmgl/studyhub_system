<?php
$conn = new mysqli("localhost", "root", "", "studyhub");

if(!isset($_GET['id'])){
  echo json_encode( ["st_status" => "error"]);
  exit;
}

$sessionId = intval($_GET['id']);
$res = $conn->query("SELECT st_status FROM sessions WHERE id = $sessionId");

if($res && $row = $res->fetch_assoc()){
  echo json_encode(["st_status" => $row["st_status"]]);
} else {
  echo json_encode(["st_status" => "not_found"]);
}


?>