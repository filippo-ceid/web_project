<?php

require "db_config.php";

################ Continue generating Map XML #################
// Select all the rows in the markers table

$results = array();

//Συνολικός αριθμός αναφορών
$query = "SELECT COUNT(*) FROM reports;";
$result = mysqli_query($dbhandle,$query);
$row = mysqli_fetch_assoc($result);
$results[0] = $row['COUNT(*)'];

//Συνολικός αριθμός ανοιχτών αναφορών
$query = "SELECT COUNT(*) FROM status WHERE status='Ανοιχτή';";
$result = mysqli_query($dbhandle,$query);
$row = mysqli_fetch_assoc($result);
$results[1] = $row['COUNT(*)'];

//Συνολικός αριθμός επιλυμένων αναφορών
$query = "SELECT COUNT(*) FROM status WHERE status='Κλειστή';";
$result = mysqli_query($dbhandle,$query);
$row = mysqli_fetch_assoc($result);
$results[2] = $row['COUNT(*)'];

//Μέσος χρόνος επίλυσης αναφορών
$query = "SELECT AVG(TIMEDIFF(update_datetime, datetime)) avg_datetime FROM status INNER JOIN reports on reports.report_id = status.report_id WHERE status='Κλειστή';";
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


//χωρισε τα στοιχεια του πινακα με |
for ($i=0; $i<count($results); $i++){
	echo $results[$i];
	echo '|';
}

mysqli_free_result($result);
mysqli_close($dbhandle);

?>
