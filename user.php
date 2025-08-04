<?php 
$conn = new mysqli("localhost","root", "", "studyhub");

$showTimer = false;
$planMinutes = 0;
$sessionEnded = false;
$receipt = "";
$sessionId = null;

if($conn->connect_error){
  die("Connection failed: ".$conn->connect_error);
}

if(isset($_GET['end'])){
  $sessionId = $_GET['end'];
  $stmt = $conn->prepare("SELECT * FROM sessions WHERE id = ?");
  $stmt->bind_param("i",$sessionId);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows >0){
    $row = $result ->fetch_assoc();
    
    if($row['st_status'] == 'in_use'){
      $end_time = date("Y-m-d H:i:s");
      $stmt = $conn->prepare("UPDATE sessions SET st_status ='ended',end_time = ? WHERE id = ?");
      $stmt->bind_param("si", $end_time, $row['id']);
      $stmt->execute();
    }
    
    $start = new DateTime($row['start_time']);
    $now = new DateTime();
    $end = new DateTime();

      if($row['end_time']){
        $end = new DateTime($row['end_time']);
      }
      $elapsed = floor(($end->getTimestamp() - $start->getTimestamp())/60);
      
      if($elapsed > $row['time_plan']) $elapsed = $row['time_plan'];

    $getType = $conn->prepare("SELECT type FROM users WHERE username = ?");
    $getType->bind_param("s", $row['username']);
    $getType->execute();
    $typeRow = $getType->get_result();
    $typeRow = $typeRow->fetch_assoc();
    $userType = $typeRow ? $typeRow['type'] : 'basic';

    $rate = ($userType =='basic')? 0.5 : 0.4;
    $cost = $elapsed * $rate;

    $receipt ="
    <!DOCTYPE html>
    <html lang = 'en'> 
    <head>  
      <meta charset = 'UTF-8'>
      <title> Receipt</title>
      <link rel = 'stylesheet' href = 'style_user. css'>
    </head>
    <body>
      <div>
        <h2>Session Receipt</h2>
        <div class = 'receipt_details'>
          <p><strong>User:</strong>".htmlspecialchars($row['username'])."</p>
          <p><strong>Study Table No.:</strong>".htmlspecialchars($row['study_table'])."</p>
          <p><strong>Time Used:</strong> ". $elapsed . ' '.(($elapsed == 0 || $elapsed == 1) ? 'minute':'minutes')."</p>
          <p>Total Cost: ₱".number_format($cost, 2)."</p>
          <a href='user.php'>Start a new session</a>
        </div>
      </div>

    </body>

    </html>
    ";
    $sessionEnded = true;
    }
}

//start a session
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['username'], $_POST['study_table'], $_POST['time_plan'])){
  $user = trim($_POST['username']);
  $studytable = $_POST['study_table'];
  $plan = $_POST['time_plan'];


//check if registered
$checkRegistered = $conn->prepare("SELECT * FROM users WHERE username = ?");
$checkRegistered->bind_param("s", $user);
$checkRegistered->execute();
$checkResult = $checkRegistered->get_result();

if($checkResult->num_rows === 0){
  echo "User is not registered";
  exit();
}

//check if study table is in use
$checkST = $conn->prepare("SELECT * FROM sessions WHERE study_table = ? AND st_status = 'in_use'");  //finds study table passed that is in use
$checkST->bind_param("s", $studytable);
$checkST->execute();
$result_check_st = $checkST->get_result();

if($result_check_st->num_rows > 0){ //if any exists
  $curr_session = $result_check_st->fetch_assoc();
  if($curr_session['username'] !=$user){
    echo "<script>
    alert('The table is already in use.');
    window.location.href = 'user.php';
    </script>";
    exit;
  }
}

$start = date("Y-m-d H:i:s");
$status = 'in_use';
//insert form info to sql
$stmt = $conn->prepare("INSERT INTO sessions (username, time_plan, study_table, start_time, st_status) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssss", $user, $plan, $studytable, $start, $status);

//display of running timer
if ($stmt->execute()){
  $planMins = $plan;
  $sessionId = $stmt->insert_id;
  $showTimer = true;

?>

<!DOCTYPE html>
<html lang = 'en'>
<head>
  <meta charset = 'UTF-8'>
  <title>Session Timer</title>
  <link rel = 'stylesheet' href = 'style_user.css'>
</head>
<body>
  <div class = 'session_timer_box'>
    <h2>Session Running</h2>
    <p><strong>Welcome, </strong><?= htmlspecialchars($user)?></p>
    <p><strong>Study Table: </strong><?= htmlspecialchars($studytable) ?> | <strong>Plan: </strong> <?=htmlspecialchars($planMins) ?></p>
    <div id = 'timer'></div>
    <a href = 'user.php?end=<?=$sessionId?>' class ='end_button'>End Session Now</a>
  </div>

  <script>
      function startTimer(durationMins, sessionId){
        let time = durationMins * 60;
        const timerDisplay = document.getElementById("timer");

        const countdown = setInterval(()=>{
          let minutes = Math.floor(time / 60);
          let seconds = time % 60;

          timerDisplay.innerHTML = `<h3>Time Left: ${minutes}m ${seconds < 10 ? "0": ""}${seconds}s</h3>`;
          
          if (time <=0) {
            clearInterval(countdown);
            timerDisplay.innerHTML = "<h3 style ='color:red;'>Session Ended. Time has run out. </h3>";
            setTimeout(()=>{
              window.location.href = "user.php?end=" + sessionId;
            }, 2000);
          }
          time--;
        }, 1000);

        const checkSession = setInterval(() => {
          fetch(`check_sessions.php?id=${sessionId}`)
            .then(res => res.json())
            .then(data=>{
              if (data.st_status === "ended"){
                clearInterval(countdown);
                clearInterval(checkSession);
                fetch("user.php?end=" + sessionId)
                  .then(response => response.text())
                  .then(html => {
                    document.body.innerHTML =html;
                  });
              }
            })
        }, 2000);
      }
        startTimer(<?= $planMins?>, <?=$sessionId?>)
  </script>

</body>
</html>
<?php
  exit;
    }else{
      echo "<p style='color:red;'>Failed to insert session: " . $stmt->error . "</p>";
  }
} ?>

<?php if($_SERVER["REQUEST_METHOD"] != "POST" && !$sessionEnded): ?>
<!DOCTYPE html>
<html>
  <head>
    <title>User Session</title>
    <link rel = 'stylesheet' href = 'style_user.css'>
  </head>
  <body>
    <form method = 'post'>
      Username: <input type="text" name ="username" required><br><br>
      Choose your time plan:
      <select name = 'time_plan' required>
        <option value ='' selected hidden>Choose your time plan</option>
        <option value ='30'>30 minutes</option>
        <option value ='60' >1 hour</option>
      </select><br><br>

      Choose your study table:
      <select name ='study_table' required>
        <option value =""selected hidden>Choose your study table</option>
        <option value ='S1' required>Study Table 1</option>
        <option value ='S2'>Study Table 2</option>
        <option value ='S3'>Study Table 3</option>
        <option value ='S4'>Study Table 4</option>
        <option value ='S5'>Study Table 5</option>
      </select> <br><br>
      <input type = 'submit' value = 'Start Session'>
    </form>
  </body>
</html>
<?php endif; ?>

<?php
if ($sessionEnded) {
  echo "<hr>$receipt";
  exit;
}
?>