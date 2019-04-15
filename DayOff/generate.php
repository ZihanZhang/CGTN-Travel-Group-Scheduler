<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php 
		$time = $_GET['time'];
	?>
</body>
</html>
<?php	
	require_once("Person.php");
	require_once("WorkDay.php");

    $people = array();
    $days = array();

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

    $con = mysqli_connect("localhost", "root","") or die(mysql_error()); //Connect to server
    mysqli_select_db($con, "first_db") or die("Cannot connect to database"); //connect to database

    if (mysqli_query($con, "Delete from history where DTime = '".$time."'")) {
    	echo "Deleted";
    }
    else {
    	echo "Error".mysqli_error($con);
    }

    $query = mysqli_query($con, "Select * from dayoff"); // SQL Query
    while($row = mysqli_fetch_array($query)) {
    	$person = new Person($row['id'], $row['Name'], $row['Total'], $row['DayOff1'], $row['OnDuty1'], $row['OnDuty2'], $row['OnDuty3'], $row['OnDuty4'], $row['Consecutive']);
    	// foreach ($person->ondutys as $on) {
    	// 	$days[$on - 1]->people[] = $person;
    	// }
    	// if ($person->OnDuty1 != 0) {
    	// 	$days[$person->OnDuty1 - 1]->people[] = $person;
    	// }
    	// if ($person->OnDuty2 != 0) {
    	// 	$days[$person->OnDuty2 - 1]->people[] = $person;
    	// }
    	// if ($person->OnDuty3 != 0) {
    	// 	$days[$person->OnDuty3 - 1]->people[] = $person;
    	// }
    	// if ($person->OnDuty4 != 0) {
    	// 	$days[$person->OnDuty4 - 1]->people[] = $person;
    	// }
    	$people[] = $person;
    }

    $trytime = 0;

    $success = false;

    $failcount = array();
    array_fill(0, 7, 0);

    while ($trytime++ < 1000) {
    	$peoplecopy = array();
		foreach ($people as $k => $v) {
		    $peoplecopy[$k] = clone $v;
		}
		$dayscopy = array();
		foreach ($days as $k => $v) {
		    $dayscopy[$k] = clone $v;
		}
	    foreach ($peoplecopy as $p) {
	    	$available = array();
	    	//for consecutive == 1 && total == 3 tries	    	
	    	$availablecopy = array();
	    	$finaldayoff = array();
	    	$finaldayoff[] = $p->DayOff1;

	    	for ($i = 1; $i <= 7; $i++) {
	    		if (!in_array($i, $p->ondutys) && $p->DayOff1 != $i) {
	    			$available[] = $i;
	    			$availablecopy[] = $i;
	    		}
	    	}

	    	//for consecutive == 1 && total == 3 tries
	    	$dayoff2try = 0;
	    	$dayoff3try = 0;
	    	$tries = 0;

	    	while ($p->restToArrange > 0) {
	    		if ($p->Consecutive == 1) {
	    			if ($p->Total == 2) {
	    				$dayofft1 = ($p->DayOff1 + 1) % 7 == 0?7:($p->DayOff1 + 1) % 7;
	    				$dayofft2 = ($p->DayOff1 - 1) % 7 == 0?7:($p->DayOff1 - 1) % 7;
	    				if (in_array($dayofft1, $available)) {
	    					$p->DayOff2 = $dayofft1;
	    					$finaldayoff[] = $dayofft1;
	    					$p->restToArrange -= 1;
	    				}
	    				else if (in_array($dayofft2, $available)) {
	    					$p->DayOff2 = $dayofft2;
	    					$finaldayoff[] = $dayofft2;
		    				$p->restToArrange -= 1;
	    				}
	    				else {
	    					print "Failure";
	    					break 3;
	    				}
	    			}
	    			else {
			    		$ind = rand(0,count($availablecopy) - 1);
			    		$d = $availablecopy[$ind];
			    		if ($p->DayOff2 == 0) {
				    		$p->DayOff2 = $d;    			
			    		}
			    		else {
			    			$p->DayOff3 = $d;
			    		}
			    		$p->restToArrange -= 1;
			    		unset($availablecopy[$ind]);
			    		$availablecopy = array_values($availablecopy);

			    		if ($p->restToArrange == 0) {
			    			if (hasConsecutives($p)) {
			    				$finaldayoff[] = $p->DayOff2;
			    				$finaldayoff[] = $p->DayOff3;
			    			}
			    			else {
			    				if ($tries < 500) {
				    				$p->restToArrange = 2;	
				    				$availablecopy = array();
				    				foreach ($available as $a) {
				    					$availablecopy[] = $a;
				    				}
				    				$tries++;			    					
			    				}
			    				else {
			    					print "Failure";
			    					break 3;
			    				}
			    			}
			    		}
	    			}
	    		}
	    		else {
		    		$ind = rand(0,count($available) - 1);
		    		$d = $available[$ind];
		    		$finaldayoff[] = $d;
		    		// $dayscopy[$d - 1]->people[] = $p;
		    		if ($p->DayOff2 == 0) {
			    		$p->DayOff2 = $d;    			
		    		}
		    		else {
		    			$p->DayOff3 = $d;
		    		}
		    		$p->restToArrange -= 1;
		    		unset($available[$ind]);
		    		$available = array_values($available);
	    		}
	    	}

	    	for ($i = 1; $i <= 7; $i++) {
	    		if (!in_array($i, $finaldayoff)) {
	    			$dayscopy[$i - 1]->people[] = $p;
	    		}
	    	}

	    	// print $p->name." ".$p->DayOff1." ".$p->DayOff2." ".$p->DayOff3."\n";
	    }

	    $result = isValid($dayscopy);
	    if ($result == "Valid") {
	    	writeInToDB($peoplecopy, $time);
	    	$success = true;
	    	break;
	    }
	    else {
	    	$failcount[$result] += 1;
	    }
    }

    if ($success) {
    	header("location: show.php?suc=1&time=".$time);   	
    }
    else {
    	$badday = array_search(max($failcount), $failcount);
    	header("location: show.php?suc=0&bad=".$badday);
    }






    // for ($i = 1; $i <= 7; $i++) {
    // 	if ($p->restToArrange == 0) {
    // 		break;
    // 	}
    // 	if ($p->DayOff1 == $i || in_array($i, $p->ondutys)) {
    // 		continue;
    // 	}
    // 	else {
    // 		$p->DayOff2 = $i;
    // 		$days[$i - 1]->people[] = $p;
    // 		$p->restToArrange -= 1;
    // 	}
    // }

    // print $p->name." ".$p->DayOff2;

    function writeInToDB($people, $time) {
    	$con = mysqli_connect("localhost", "root","") or die(mysql_error()); //Connect to server
	    mysqli_select_db($con, "first_db") or die("Cannot connect to database"); //Connect to database
	    // $query = mysqli_query($con, "Select * from dayoff Where DTime='$time'");
	    // $count = mysqli_num_rows($query);
	    // if ($count > 0) {
	    // 	//TODO
	    // }
	    // else {
		    foreach ($people as $p) {
		    	$id = $p->id;
		    	$name = $p->name;
		    	$total = $p->Total;
		    	$dayoff1 = $p->DayOff1;
		    	$dayoff2 = $p->DayOff2;
		    	$dayoff3 = $p->DayOff3;
		    	$ind = 0;
		    	$onduty1 = 0;
		    	$onduty2 = 0;
		    	$onduty3 = 0;
		    	$onduty4 = 0;
		    	if (array_key_exists($ind, $p->ondutys)) {
		    		$onduty1 = $p->ondutys[$ind];
		    		$ind++;
		    	}
		    	if (array_key_exists($ind, $p->ondutys)) {
		    		$onduty2 = $p->ondutys[$ind];
		    		$ind++;
		    	}
		    	if (array_key_exists($ind, $p->ondutys)) {
		    		$onduty3 = $p->ondutys[$ind];
		    		$ind++;
		    	}
		    	if (array_key_exists($ind, $p->ondutys)) {
		    		$onduty4 = $p->ondutys[$ind];
		    		$ind++;
		    	}
		    	$consecutive = $p->Consecutive;

		    	// print "<br>".$id." ".$name." ".$dayoff1." ".$dayoff2." ".$dayoff3." ".$onduty1." ".$onduty2." ".$consecutive."<br>";
		    	$stmt = $con->prepare('INSERT INTO history(Name, Total, DayOff1, DayOff2, DayOff3, OnDuty1, OnDuty2, OnDuty3, OnDuty4, Consecutive, DTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
				$stmt->bind_param("siiiiiiiiis",$name, $total, $dayoff1, $dayoff2, $dayoff3, $onduty1, $onduty2, $onduty3, $onduty4, $consecutive, $time);
				$stmt->execute();


				//Doesn't work somehow
		    	// mysqli_query($con, "UPDATE dayoff SET Name='$name', Total='$total', DayOff1='$dayoff1', DayOff2='dayoff2', DayOff3='dayoff3', OnDuty1='$onduty1', OnDuty2='$onduty2', OnDuty3 = '$onduty3', OnDuty4 = '$onduty4', Consecutive = '$consecutive' WHERE id='$id'") ;
		    }
	    // }
    }

    function isValid($days) {
   		foreach ($days as $d) {
   			// print $d->name." ".count($d->people);
    		if (count($d->people) < $d->limit) {
    			// print "<br>".$d->name."is Wrong"."<br>";
    			return $d->name;
    		}
    	}
    	return "Valid";
    }

    function hasConsecutives(&$person) {
    	$do1 = $person->DayOff1;
    	$do2 = $person->DayOff2;
    	$do3 = $person->DayOff3;

    	if (abs($do1 - $do2) == 1 || abs($do1 - $do3) == 1 || abs($do2 - $do3) == 1) {
    		return true;
    	}
    	else {
    		$person->DayOff2 = 0;
    		$person->DayOff3 = 0;
    		return false;
    	}
    }
?>