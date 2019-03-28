<?php
    session_start();
    if($_SESSION['user']){
    }
    else{ 
       header("location:index.php");
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $con = mysqli_connect("localhost", "root", "") or die(mysql_error());
      $name = $_POST['name'];
      $dayoff = $_POST['dayoff'];
      $total = $_POST['total'];
      $onduty1 = $_POST['onduty1'];
      $onduty2 = $_POST['onduty2'];
      $onduty3 = $_POST['onduty3'];
      $onduty4 = $_POST['onduty4'];
      if (isset($_POST['consecutive'])) {
        $consecutive = 1;
      }
      else {
        $consecutive = 0;
      }
      mysqli_select_db($con, "first_db") or die("Cannot connect to database");
      mysqli_query($con, "INSERT INTO dayoff(Name, Total, DayOff1, OnDuty1, OnDuty2, OnDuty3, OnDuty4, Consecutive) VALUES ('$name', '$total','$dayoff', '$onduty1', '$onduty2', '$onduty3', '$onduty4', '$consecutive')");
      header("location:home.php");
    }
    else {
      header("location:home.php");
    }
?>