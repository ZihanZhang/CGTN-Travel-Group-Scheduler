<html>
  <head>
    <title>My first PHP website</title>
  </head>
  <?php
  session_start(); //starts the session
  if($_SESSION['user']){ //checks if user is logged in
  }
  else{
    header("location:index.php"); // redirects if user is not logged in
  }
  $user = $_SESSION['user']; //assigns user value
  $id_exists = false;
  ?>
  <body>
    <h2>Home Page</h2>
    <p>Hello <?php Print "$user"?>!</p> <!--Displays user's name-->
    <a href="logout.php">Click here to logout</a><br/><br/>
    <a href="home.php">Return to Home page</a>
    <h2 align="center">Currently Selected</h2>
    <table border="1px" width="100%">
          <tr>
            <th>Name</th>
            <th>Total</th>
            <th>Day Off</th>
            <th>On Duty1</th>
            <th>On Duty2</th>
            <th>On Duty3</th>
            <th>On Duty4</th>
            <th>Consecutive</th>
          </tr>      
      <?php
        if(!empty($_GET['id']))
        {
          $id = $_GET['id'];
          $_SESSION['id'] = $id;
          $id_exists = true;
          $con = mysqli_connect("localhost", "root","") or die(mysql_error()); //Connect to server
          mysqli_select_db($con, "first_db") or die("Cannot connect to database"); //connect to database
          $query = mysqli_query($con, "Select * from dayoff Where id='$id'"); // SQL Query
          $count = mysqli_num_rows($query);
          if($count > 0)
          {
            while($row = mysqli_fetch_array($query))
            {
              Print "<tr>";
                Print '<td align="center">'. $row['Name'] . "</td>"; // In table data
                Print '<td align="center">'. $row['Total'] . "</td>";
                $do = $row['DayOff1'];
                switch ($do) {
                  case 1:
                    $date = "Monday";
                    break;
                  case 2:
                    $date = "Tuesday";
                    break;
                  case 3:
                    $date = "Wednesday";
                    break;
                  case 4:
                    $date = "Thursday";
                    break;
                  case 5:
                    $date = "Friday";
                    break;
                  case 6:
                    $date = "Saturday";
                    break;
                  case 7:
                    $date = "Sunday";
                    break;
                }
                Print '<td align="center">'. $date."</td>";
                $od1 = $row['OnDuty1'];
                switch ($od1) {
                  case 0:
                    $date1 = "Not Selected";
                    break;
                  case 1:
                    $date1 = "Monday";
                    break;
                  case 2:
                    $date1 = "Tuesday";
                    break;
                  case 3:
                    $date1 = "Wednesday";
                    break;
                  case 4:
                    $date1 = "Thursday";
                    break;
                  case 5:
                    $date1 = "Friday";
                    break;
                  case 6:
                    $date1 = "Saturday";
                    break;
                  case 7:
                    $date1 = "Sunday";
                    break;
                }
                Print '<td align="center">'. $date1."</td>";
                $od2 = $row['OnDuty2'];
                switch ($od2) {
                  case 0:
                    $date2 = "Not Selected";
                    break;
                  case 1:
                    $date2 = "Monday";
                    break;
                  case 2:
                    $date2 = "Tuesday";
                    break;
                  case 3:
                    $date2 = "Wednesday";
                    break;
                  case 4:
                    $date2 = "Thursday";
                    break;
                  case 5:
                    $date2 = "Friday";
                    break;
                  case 6:
                    $date2 = "Saturday";
                    break;
                  case 7:
                    $date2 = "Sunday";
                    break;
                }
                Print '<td align="center">'. $date2."</td>";
                $od3 = $row['OnDuty3'];
                switch ($od3) {
                  case 0:
                    $date3 = "Not Selected";
                    break;
                  case 1:
                    $date3 = "Monday";
                    break;
                  case 2:
                    $date3 = "Tuesday";
                    break;
                  case 3:
                    $date3 = "Wednesday";
                    break;
                  case 4:
                    $date3 = "Thursday";
                    break;
                  case 5:
                    $date3 = "Friday";
                    break;
                  case 6:
                    $date3 = "Saturday";
                    break;
                  case 7:
                    $date3 = "Sunday";
                    break;
                }
                Print '<td align="center">'. $date3."</td>";
                $od4 = $row['OnDuty4'];
                switch ($od4) {
                  case 0:
                    $date4 = "Not Selected";
                    break;
                  case 1:
                    $date4 = "Monday";
                    break;
                  case 2:
                    $date4 = "Tuesday";
                    break;
                  case 3:
                    $date4 = "Wednesday";
                    break;
                  case 4:
                    $date4 = "Thursday";
                    break;
                  case 5:
                    $date4 = "Friday";
                    break;
                  case 6:
                    $date4 = "Saturday";
                    break;
                  case 7:
                    $date4 = "Sunday";
                    break;
                }
                Print '<td align="center">'. $date4."</td>";
                if ($row['Consecutive'] == 0) {
                  $cons = "No";
                }
                else {
                  $cons = "Yes";
                }
                Print '<td align="center">'. $cons. "</td>";
              Print "</tr>";
            }
          }
          else
          {
            $id_exists = false;
          }
        }
      ?>
    </table>
    <br/>
    <?php
    if($id_exists)
    {
    Print '
        <table border="1px" width="100%">
          <tr>
            <th>Name</th>
            <th>Total</th>
            <th>Day Off</th>
            <th>On Duty1</th>
            <th>On Duty2</th>
            <th>On Duty3</th>
            <th>On Duty4</th>
            <th>Consecutive</th>
          </tr>     
          <tr> 
            <form action="edit.php" method="POST">
            <input type="hidden" name="id" value='.$id.' />
            <td align="center"><input type="text" name="name" /></td>
            <td align="center"><select name="total">
              <option value=2>2</option>
              <option value=3>3</option>
            </select></td>
            <td align="center"><select name="dayoff">
              <option value=1>Monday</option>
              <option value=2>Tuesday</option>
              <option value=3>Wednesday</option>
              <option value=4>Thursday</option>
              <option value=5>Friday</option>
              <option value=6>Saturday</option>
              <option value=7>Sunday</option>
            </select></td>
            <td align="center"><select name="onduty1">
              <option value=0>Not Selected</option>
              <option value=1>Monday</option>
              <option value=2>Tuesday</option>
              <option value=3>Wednesday</option>
              <option value=4>Thursday</option>
              <option value=5>Friday</option>
              <option value=6>Saturday</option>
              <option value=7>Sunday</option>
            </select></td>
            <td align="center"><select name="onduty2">
              <option value=0>Not Selected</option>
              <option value=1>Monday</option>
              <option value=2>Tuesday</option>
              <option value=3>Wednesday</option>
              <option value=4>Thursday</option>
              <option value=5>Friday</option>
              <option value=6>Saturday</option>
              <option value=7>Sunday</option>
            </select></td>
            <td align="center"><select name="onduty3">
              <option value=0>Not Selected</option>
              <option value=1>Monday</option>
              <option value=2>Tuesday</option>
              <option value=3>Wednesday</option>
              <option value=4>Thursday</option>
              <option value=5>Friday</option>
              <option value=6>Saturday</option>
              <option value=7>Sunday</option>
            </select></td>
            <td align="center"><select name="onduty4">
              <option value=0>Not Selected</option>
              <option value=1>Monday</option>
              <option value=2>Tuesday</option>
              <option value=3>Wednesday</option>
              <option value=4>Thursday</option>
              <option value=5>Friday</option>
              <option value=6>Saturday</option>
              <option value=7>Sunday</option>
            </select></td>
            <td align="center"><input type="checkbox" name="consecutive" value="yes"/></td>
            <input type="submit" value="edit" />
            </form>
            </tr>
        </table>
    ';
    }
    else
    {
      Print '<h2 align="center">There is no data to be edited.</h2>';
    }
    ?>
  </body>
</html>

<?php
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    $con = mysqli_connect("localhost", "root","") or die(mysql_error()); //Connect to server
    mysqli_select_db($con, "first_db") or die("Cannot connect to database"); //Connect to database
    $id = $_POST['id'];
    $name = $_POST['name'];
    $total = $_POST['total'];
    $dayoff = $_POST['dayoff'];
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
    mysqli_query($con, "UPDATE dayoff SET Name='$name', Total='$total', DayOff1='$dayoff', OnDuty1='$onduty1', OnDuty2='$onduty2', OnDuty3 = '$onduty3', OnDuty4 = '$onduty4', Consecutive = '$consecutive' WHERE id='$id'") ;
    header("location: home.php");
  }
?>