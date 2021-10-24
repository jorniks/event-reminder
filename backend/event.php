

<?php
	session_start();
    include "connection.php";
    $username = $_SESSION['username'];

	if (isset($_POST['newTitle'])) {
		$title = $_POST['newTitle'];
		$unprocessedDate = $_POST['newDate'];
		$time = $_POST['newTime'];
		$note = $_POST['newNote'];
        $status = "pending";
        $recurring = $_POST['newCheck'];

		$noCommaDate = str_replace(',', '', $unprocessedDate); //Removes comma sign from the date value
		$arrayDate = explode(" ", $noCommaDate); //Converts date into an array

		//Change the name value of the month to a number representation of that month
		$month = date("m", strtotime($arrayDate[1] . "-" . $arrayDate[2]));
		$year = $arrayDate[2];
		$day = $arrayDate[0];

		//Gather the date back to one piece (YEAR-MONTH-DAY)
		$date = $year . "-" . $month . "-" . $day;
		
		$alert = strtotime($date ." " . $time);
		$subtractedTime = $alert - (15 * 60);
		$alertTime = date($subtractedTime);


		//SCRIPT TO SEND TO DATABASE
		$check_sql = mysqli_query($con, "SELECT * FROM `event` WHERE `username` = '$username' AND (`time` = '$time' AND `date` = '$date')");

		
		if($alert < time()) {
			echo("Selected time for event has passed. Use a future time.");
		} else {
			if(mysqli_num_rows($check_sql) > 0) {
				echo("1");
			} else {
				$sql = "INSERT INTO `event`(`username`, `title`, `date`, `time`, `alertTime`, `note`, `recurring`, `status`) VALUES ('$username','$title','$date','$time','$alertTime','$note','$recurring','$status')";
				if (mysqli_query($con, $sql)) {
					echo("2");
				} else {
					echo("3");
				}
			}
		}
	}
  
?>

