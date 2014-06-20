<?php

require "db_config.php";

header('Content-Type: text/xml');

echo '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
<title>FixMyCity</title>
<description>Τελευταίες 20 αναφορές</description>
<link>http://'.$PHP_HOST.'/web_project/rss.php</link>';

$query = sprintf("SELECT category, description, datetime, firstname, lastname FROM reports INNER JOIN users on users.user_id = reports.user_id ORDER BY report_id DESC LIMIT 20;");
$result = mysqli_query($dbhandle,$query);
if (!$result) {  
		header('HTTP/1.1 500 Error: Could not get reports!'); 
		exit();
}
$report_num = 0;

while ($row = mysqli_fetch_array($result)){
    echo '
       <item>
          <title>'.$row['datetime'].'</title>
          <description><![CDATA[<html><body>Κατηγορία: '.$row['category'].'<br>Περιγραφή:<br>'.$row['description'].'<br>Χρήστης: '.$row['firstname'].' '.$row['lastname'].'</body></html>]]></description>
          <link>http://'.$PHP_HOST.'/web_project/index.php?'.$report_num.'</link>
      </item>';
      $report_num = $report_num +1;
}

echo '</channel>
</rss>';
?>
