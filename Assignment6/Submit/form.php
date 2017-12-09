<?php
session_start();

if($_GET['logout'] == 'true') {
    session_unset();
    session_destroy();
    header("Location: login.php");
}
$userName = "";
if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $userName .= $_SESSION['name'];
} else {
    header("Location: login.php");
}

?>

<?php
$eventName = $_POST['eventname'];
$startTime = $_POST['starttime'];
$endTime = $_POST['endtime'];
$location = $_POST['location'];
$day = $_POST['day'];
$errorMessage = '';

if (!empty($_POST['submit'])) {
  if (empty($eventName)) {
      $errorMessage .= "Please provide a value for Event Name<br>";
  }
  if (empty($startTime)) {
      $errorMessage .= "Please select a value for Start Time<br>";
  }
  if (empty($endTime)) {
      $errorMessage .= "Please select a value for End Time<br>";
  }
  if (empty($location)) {
      $errorMessage .= "Please provide a value for Location<br>";
  }


  class Day {
    function Day($a,$b,$c,$d,$e) {
      $this->eventName = $a;
      $this->startTime = $b;
      $this->endTime = $c;
      $this->location = $d;
      $this->day = $e;
    }
  }
  if(empty($errorMessage)) {
    $events = fopen('calendar.txt','a+') or die("Cannot open file!");
    $day = new Day($eventName, $startTime, $endTime, $location, $day);
    $day = json_encode($day);
    if (file_get_contents('calendar.txt') == '') {
      fwrite($events, $day);
    } else {
      fwrite($events, ", ");
      fwrite($events, $day);
    }
    fclose($events);
  }
}

if(isset($_POST['reset'])) {
  unlink('calendar.txt');
  header('Location: calendar.php');
}

?>


<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="utf-8">
        <title>Calendar Input</title>
    </head>
    <body>
        <div class="nav">
            <nav>
            <a class="left" href="calendar.php">My Calendar</a>
            <a class="active" href="form.php">Form Input</a>
            <a class="right" href="calendar.php?logout=true">Log out</a>
            <a class="right" ><?php echo "Welcome " . $userName; ?></a>
            </nav>
        </div>

      <h1>Calendar Input</h1>
      <div class="errorMessage">
        <?php if(!empty($errorMessage)) {
            echo '<p>' . $errorMessage . '</p>';
        }
        ?>
      </div>
        <form id="form" action="form.php" method="POST">
            <p>
              <label>Event Name</label>
              <input id="eventName" type="text" name="eventname" placeholder="Class name"><br>
            </p>
            <p>
              <label>Start Time</label>
              <input type="time" name="starttime"><br>
            </p>
            <p>
              <label>End Time</label>
              <input type="time" name="endtime"><br>
            </p>
            <p>
              <label>Location</label>
              <input id="location" type="text" name="location" placeholder="Class location"><br>
            </p>
            <p>
              <label>Day of the week</label>
              <select name="day">
                  <option value="Monday" selected>Monday</option>
                  <option value="Tuesday">Tuesday</option>
                  <option value="Wednesday">Wednesday</option>
                  <option value="Thursday">Thursday</option>
                  <option value="Friday">Friday</option>
              </select>
            </p>
        <br>
          <p><input class='submit' type="submit" name="submit"> <input class='submit' type="submit" name='reset' value='Clear'></p>

        </form>

        <div class="reference">
          <p>This page has been tested on Chrome, Firefox and Safari.</p>
        </div>

      </body>
</html>

