<?php
//database variables
$username="dbo250840345";
$password="NerBpU9t";
$database="db250840345";

$logtable="logTable";

$link = mysql_connect("db1567.perfora.net",$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$logs = mysql_query("SELECT * FROM $logtable ORDER BY logTime DESC") or die(mysql_error());

while($row = mysql_fetch_array( $logs )) {
		echo "logTableID:";
		echo $row['logTableID'];
		echo ", logTime:";
		echo $row['logTime'];
		echo ", ipAddress:";
		echo $row['ipaddress'];
		echo ", logText:";
		echo $row['logtext'];
		echo "<BR>";
	} 
	
?>