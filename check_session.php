<?php
$conn = new mysqli("localhost", "root", "", "studyhub");

if(!isset($_GET['id'])){
  echo json_encode( ["status" => "error"]);
  exit;
}

$sessionId = intval($_GET['id']);
$res = $conn->query("SELECT status FROM session WHERE id = $sessionId");

if($res && $row = $res->fetch_assoc()){
  echo json_encode(["status" => $row["status"]]);
} else {
  echo json_encode(["status" => "not_found"]);
}


?>