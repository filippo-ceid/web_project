<?php

require "db_config.php";

################ Continue generating Map XML #################
// Select all the rows in the markers table

$results = array();

$query = "SELECT COUNT(*) FROM reports;";
$result = mysqli_query($dbhandle,$query);
$row = mysqli_fetch_assoc($result);
$results[0] = $row['COUNT(*)'];

$query = "SELECT COUNT(*) FROM status WHERE status='unsolved';";
$result = mysqli_query($dbhandle,$query);
$row = mysqli_fetch_assoc($result);
$results[1] = $row['COUNT(*)'];

$query = "SELECT COUNT(*) FROM status WHERE status='solved';";
$result = mysqli_query($dbhandle,$query);
$row = mysqli_fetch_assoc($result);
$results[2] = $row['COUNT(*)'];

$query = "SELECT AVG(TIMEDIFF(update_datetime, datetime)) avg_datetime FROM status INNER JOIN reports on reports.report_id = status.report_id WHERE status='solved';";
$result = mysqli_query($dbhandle,$query);
$row = mysqli_fetch_assoc($result);
$inputSeconds = $row['avg_datetime'];
$secondsInAMinute = 60;
$secondsInAnHour  = 60 * $secondsInAMinute;
$secondsInADay    = 24 * $secondsInAnHour;
// extract days
$days = floor($inputSeconds / $secondsInADay);
// extract hours
$hourSeconds = $inputSeconds % $secondsInADay;
$hours = floor($hourSeconds / $secondsInAnHour);
// extract minutes
$minuteSeconds = $hourSeconds % $secondsInAnHour;
$minutes = floor($minuteSeconds / $secondsInAMinute);
// extract the remaining seconds
$remainingSeconds = $minuteSeconds % $secondsInAMinute;
$seconds = ceil($remainingSeconds);
$results[3] = $days." μέρες ".$hours." ώρες ".$minutes." λεπτά και ".$seconds." δευτερόλεπτα.";


for ($i=0; $i<count($results); $i++){
	echo $results[$i];
	echo '|';
}

mysqli_free_result($result);
mysqli_close($dbhandle);

?>
