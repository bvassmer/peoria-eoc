<?php
$action = $_GET['action'];
$spottersid = $_GET['spottersid'];
$name = $_GET['name'];
$lat = $_GET['lat'];
$long = $_GET['long'];

//ip address of commander
$ipaddress=@$REMOTE_ADDR; 

//database variables
$username="dbo250840345";
$password="NerBpU9t";
$database="db250840345";

//table name varibales
$table="spotters";
$logtable="logTable";

$link = mysql_connect("db1567.perfora.net",$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


if ($action == 0) {
	$spotters = mysql_query("SELECT * FROM $table ORDER BY spottersid ASC") or die(mysql_error());

	//get all persons for grlevelx placefile
	echo "RefreshSeconds: 5\n";
	echo "Threshold: 150\n";
	echo "Color: 200 200 255\n";
	echo "IconFile: 1, 19, 17, 15, 15, \"http://www.w5dge.com/images/car.png\"\n";
	echo "Font: 1, 11, 1, \"Courier New\"\n";
	echo "Title: Peoria EOC Spotter Locations\n\n";
	
	while($row = mysql_fetch_array( $spotters )) {
		echo "Icon: ";
		echo $row['lat'];
		echo ",";
		echo $row['long'];
		echo ",000,1,1,\"";
		echo $row['name'];
		echo "\"\n";
	} 
	
	//echo "Icon: 40.88,-89.59,000,1,1,\"test\"\n";
	
} elseif ($action == 1) {
	//get all persons for google maps interface
	
} elseif ($action == 2) {
	//add new person
	
	$addQuery = "INSERT INTO $table VALUES ($spottersid,'$name','$lat','$long')";
	//(spottersid,name,lat,long)
	//echo $addQuery;
	mysql_query($addQuery);

	$log = "2_ADD - " . mysql_errno($link) . ": " . mysql_error($link);
	$logQuery = "INSERT INTO $logtable (ipaddress, logtext) VALUES ('$ipaddress', '$log')";
	mysql_query($logQuery, $link);
} elseif ($action == 3) {
	//move person
	$moveQuery = "UPDATE $table SET $table.lat='$lat' WHERE spottersid=$spottersid";
	mysql_query($moveQuery, $link);
	//echo $moveQuery . " -- ";

	$moveQuery = "UPDATE $table SET $table.long='$long' WHERE spottersid=$spottersid";
	mysql_query($moveQuery, $link);

	//echo $moveQuery . " -- ";
	
	$log = "3_MOV - " . mysql_errno($link) . ": " . mysql_error($link);
	$logQuery = "INSERT INTO $logtable (ipaddress, logtext) VALUES ('$ipaddress', '$log')";
	mysql_query($logQuery, $link);
	
} elseif ($action == 4) {
	//delete person
	$deleteQuery = "DELETE FROM $table WHERE spottersid=$spottersid";
	//echo $deleteQuery;
	mysql_query($deleteQuery, $link);

	$log = "4_DEL - " . mysql_errno($link) . ": " . mysql_error($link);
	$logQuery = "INSERT INTO $logtable (ipaddress, logtext) VALUES ('$ipaddress', '$log')";
	mysql_query($logQuery, $link);
} elseif ($action == 1969) {
	$deleteAllQuery = "DELETE FROM $table";
	//echo $deleteAllQuery;
	mysql_query($deleteAllQuery, $link);

	$log = "1969_DELALL - " . mysql_errno($link) . ": " . mysql_error($link);
	$logQuery = "INSERT INTO $logtable (ipaddress, logtext) VALUES ('$ipaddress', '$log')";
	mysql_query($logQuery, $link);
} 
?>
