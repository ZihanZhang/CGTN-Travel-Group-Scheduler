<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php 
		$time = $_POST['time'];
		echo $time;
		$con = mysqli_connect("localhost", "root","") or die(mysql_error()); //Connect to server
    	mysqli_select_db($con, "first_db") or die("Cannot connect to database"); //connect to database
		$datesq = mysqli_query($con, "Select Distinct DTime from history");    	
		$dates = array();
	  	while ($row = mysqli_fetch_array($datesq)) {
	    	$dates[] = $row['DTime'];
	    	echo $row['DTime'];
	  	}
	  	if (in_array($time, $dates)) {
	  		echo '<script type="text/javascript">var ovr = confirm("Date Exist, Override?");
	  			if (!ovr) {
	  				window.location.href="home.php";
	  			}
	  			else {
	  				window.location.href="generate.php?time='.$time.'";
	  			}
	  		</script>';
	  	}
	  	else {
	  		header("Location:generate.php?time=".$time);
	  	}
	?>
</body>
</html>