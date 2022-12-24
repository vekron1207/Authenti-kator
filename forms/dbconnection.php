<?php

// Connect to the database
$host        = "host = localhost";
$port        = "port = 5432";
$dbname      = "dbname = Auth_Db";
$credentials = "user = postgres password=0000";

$db = pg_connect( "$host $port $dbname $credentials"  );
if(!$db) {
   die("Error : Unable to open database\n");
}

// Get the serial number from the form submission
$serial_number = $_POST['serial_number'];

// Check if the serial number exists in the database
$query = "SELECT * FROM Nike_DB WHERE Serial_No='$serial_number'";
$result = pg_query($db, $query);

if (pg_num_rows($result) > 0) {
   // Serial number found in the database
   echo "Authentic Product! Congrats";
} else {
   // Serial number not found in the database
   echo "Invalid serial number";
}

pg_close($db);

?>
