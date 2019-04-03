<html>
    <head>
        <title>My first PHP Website</title>
    </head>
   <?php
   session_start(); //starts the session
   if($_SESSION['user']){ // checks if the user is logged in  
   }
   else{
      header("location: index.php"); // redirects if user is not logged in
   }
   $user = $_SESSION['user']; //assigns user value
   ?>
    <body>
        <h2>Home Page</h2>
        
        <a href="logout.php">Click here to go logout</a><br/><br/>
        <h2 align="center">My list</h2>
        <table border="1px" width="100%">
          <tr>
            <th>Name</th>
            <th>Total</th>
            <th>Day Off</th>
            <th>On Duty1</th>
            <th>On Duty2</th>
            <th>Consecutive</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
          <?php
            require_once("WorkDay.php");
            require_once("Person.php");

            $monday = new WorkDay("Monday");
            $tuesday = new WorkDay("Tuesday");
            $wednesday = new WorkDay("Wednesday");
            $thursday = new WorkDay("Thursday");
            $friday = new WorkDay("Friday");
            $saturday = new WorkDay("Saturday");
            $sunday = new WorkDay("Sunday");
            
            $days[] = $monday;
            $days[] = $tuesday;
            $days[] = $wednesday;
            $days[] = $thursday;
            $days[] = $friday;
            $days[] = $saturday;
            $days[] = $sunday;

            $people = array();

            $con = mysqli_connect("localhost", "root","") or die(mysql_error()); //Connect to server
            mysqli_select_db($con, "first_db") or die("Cannot connect to database"); //connect to database
            $query = mysqli_query($con, "Select * from dayoff"); // SQL Query
            while($row = mysqli_fetch_array($query))
            {
              $person = new Person($row['id'], $row['Name'], $row['Total'], $row['DayOff1'], $row['OnDuty1'], $row['OnDuty2'], $row['OnDuty3'], $row['OnDuty4'], $row['Consecutive']);
              $people[] = $person;
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
                if ($od1 != 0) {
                  $days[$od1 - 1]->people[] = $person;
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
                if ($od2 != 0) {
                  $days[$od2 - 1]->people[] = $person;
                }
                Print '<td align="center">'. $date2."</td>";
                if ($row['Consecutive'] == 0) {
                  $cons = "No";
                }
                else {
                  $cons = "Yes";
                }
                Print '<td align="center">'. $cons. "</td>";
                Print '<td align="center"><a href="edit.php?id='. $row['id'] .'">edit</a> </td>';
                Print '<td align="center"><a href="#" onclick="myFunction('.$row['id'].')">delete</a> </td>';
              Print "</tr>";
            }
          ?>
          <tr>
            <form name="addform" action="add.php" method="POST" onsubmit="return validateForm()">
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
              <option value=0>None</option>
              <option value=1>Monday</option>
              <option value=2>Tuesday</option>
              <option value=3>Wednesday</option>
              <option value=4>Thursday</option>
              <option value=5>Friday</option>
              <option value=6>Saturday</option>
              <option value=7>Sunday</option>
            </select></td>
            <td align="center"><select name="onduty2">
              <option value=0>None</option>
              <option value=1>Monday</option>
              <option value=2>Tuesday</option>
              <option value=3>Wednesday</option>
              <option value=4>Thursday</option>
              <option value=5>Friday</option>
              <option value=6>Saturday</option>
              <option value=7>Sunday</option>
            </select></td>
            <td align="center"><input type="checkbox" name="consecutive" value="yes"/></td>
            <input type="submit" value="add" />
            </form>
          </tr>
        </table>
        <br>
        <br>

        <table border="1px" width="100%">
          <tr>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Sunday</th>
          </tr>
        <?php 
          for($i = 0; $i < 10; $i++) {
            $has = false;
            foreach ($days as $d) {
              if (array_key_exists($i, $d->people)) {
                $has = true;
              }
            }
            if (!$has) {
              break;
            }
            print "<tr>";
            for ($j = 0; $j < 7; $j++) {
              if (array_key_exists($i, $days[$j]->people)) {
                print "<td align='center'>".$days[$j]->people[$i]->name."</td>";
              }
              else {
                print "<td></td>";
              }
            }
            print "</tr>";
          }

        ?>
        </table>
        <br>
        <br>

        <table border="1px" width="100%">
          <tr>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Sunday</th>
          </tr>
        <?php 

          $dmonday = new WorkDay("Monday");
          $dtuesday = new WorkDay("Tuesday");
          $dwednesday = new WorkDay("Wednesday");
          $dthursday = new WorkDay("Thursday");
          $dfriday = new WorkDay("Friday");
          $dsaturday = new WorkDay("Saturday");
          $dsunday = new WorkDay("Sunday");

          $dayoffs = array();
          
          $dayoffs[] = $dmonday;
          $dayoffs[] = $dtuesday;
          $dayoffs[] = $dwednesday;
          $dayoffs[] = $dthursday;
          $dayoffs[] = $dfriday;
          $dayoffs[] = $dsaturday;
          $dayoffs[] = $dsunday;

          foreach ($people as $p) {
            if ($p->DayOff1 != 0) {
              $dayoffs[$p->DayOff1 - 1]->people[] = $p;
            }
            if ($p->DayOff2 != 0) {
              $dayoffs[$p->DayOff2 - 1]->people[] = $p;
            }
            if ($p->DayOff3 != 0) {
              $dayoffs[$p->DayOff3 - 1]->people[] = $p;
            }
          }

          for($i = 0; $i < 10; $i++) {
            $has = false;
            foreach ($dayoffs as $d) {
              if (array_key_exists($i, $d->people)) {
                $has = true;
              }
            }
            if (!$has) {
              break;
            }
            print "<tr>";
            for ($j = 0; $j < 7; $j++) {
              if (array_key_exists($i, $dayoffs[$j]->people)) {
                print "<td align='center'>".$dayoffs[$j]->people[$i]->name."</td>";
              }
              else {
                print "<td></td>";
              }
            }
            print "</tr>";
          }

        ?>
        </table>
        <br>
        <br>
        <button onclick="window.location.href = 'generate.php'">Generate</button>

        <script>
          function myFunction(id) {
            var r=confirm("Are you sure you want to delete this record?");
            if (r==true) {
              window.location.assign("delete.php?id=" + id);
            }
          }

          function validateForm() {
            var df = document.forms['addform']['dayoff'].value;
            var od1 = document.forms['addform']['onduty1'].value;
            var od2 = document.forms['addform']['onduty2'].value;
            if (df == od1 || df == od2 || od1 == od2) {
              alert("Data not correct, please reinput the data");
              return false;
            }
          }
        </script>
    </body>
  </html>