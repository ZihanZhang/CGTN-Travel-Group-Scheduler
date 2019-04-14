<!DOCTYPE html>
<html>
<head>
  <div>
    <?php 
      require_once("WorkDay.php");
      require_once("Person.php");

      $con = mysqli_connect("localhost", "root","") or die(mysql_error()); //Connect to server
      mysqli_select_db($con, "first_db") or die("Cannot connect to database"); //connect to database

      $datesq = mysqli_query($con, "Select Distinct DTime from history");
      $dates = array();
      while ($row = mysqli_fetch_array($datesq)) {
        $dates[] = $row['DTime'];
      }

      foreach ($dates as $d) {
        Print $d;
        Print '
          <table border="1px" width="100%">
            <tr>
              <th>Name</th>
              <th>Total</th>
              <th>Day Off1</th>
              <th>Day Off2</th>
              <th>Day Off3</th>
            </tr>
        ';
            $monday = new WorkDay("Monday");
            $tuesday = new WorkDay("Tuesday");
            $wednesday = new WorkDay("Wednesday");
            $thursday = new WorkDay("Thursday");
            $friday = new WorkDay("Friday");
            $saturday = new WorkDay("Saturday");
            $sunday = new WorkDay("Sunday");

            $days = array();
            
            $days[] = $monday;
            $days[] = $tuesday;
            $days[] = $wednesday;
            $days[] = $thursday;
            $days[] = $friday;
            $days[] = $saturday;
            $days[] = $sunday;

            $people = array();
            $query = mysqli_query($con, "Select * from history where DTime = '".$d."'"); // SQL Query
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
                $od1 = $row['DayOff2'];
                switch ($od1) {
                  case 0:
                    $date1 = "";
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
                $od2 = $row['DayOff3'];
                switch ($od2) {
                  case 0:
                    $date2 = "";
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
              Print "</tr>";
              for ($i = 1; $i <= 7; $i++) {
                if ($i != $do && $i != $od1 && $i != $od2) {
                  $days[$i - 1]->people[] = $person;
                }
              }
            }

            Print '</table>
                  <br>
                  <br>
            ';

            Print '
              <table border="1px" width="100%">
                <tr>
                  <th>Sunday</th>
                  <th>Monday</th>
                  <th>Tuesday</th>
                  <th>Wednesday</th>
                  <th>Thursday</th>
                  <th>Friday</th>
                  <th>Saturday</th>
                </tr>
            ';

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
            for ($k = 6; $k < 13; $k++) {
              $j = $k % 7;
              if (array_key_exists($i, $days[$j]->people)) {
                print "<td align='center'>".$days[$j]->people[$i]->name."</td>";
              }
              else {
                print "<td></td>";
              }
            }
            print "</tr>";
          }

          Print '</table>
                <br>
                <br>';
      }

    ?>




    </div>

</head>
<body>

</body>
</html>