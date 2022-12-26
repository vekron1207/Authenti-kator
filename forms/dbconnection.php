<?php

// Connect to the database
$host        = "host = localhost";
$port        = "port = 5432";
$dbname      = "dbname = Auth_DB";
$credentials = "user = postgres password=0000";

$db = pg_connect( "$host $port $dbname $credentials"  );

// Check the connection status
if (pg_connection_status($db) === PGSQL_CONNECTION_OK) {
  echo "Connection to the database was successful!\n";
} else {
  echo "An error occurred while trying to connect to the database:\n";
  echo pg_last_error($db) . "\n";
}

// Get the Serial_No from the form submission
$serial_number = $_GET['Serial_No'];

// Check if the Serial_No exists in the database
$query = "SELECT * FROM public.\"Nike_DB\" WHERE \"Nike_DB\".\"Serial_No\"='$serial_number'";
$result = pg_query($db, $query);

if (!$result) {
  echo "An error occurred while executing the query: " . pg_last_error($db);
  exit;
}

$row = pg_fetch_assoc($result);

if (!empty($row)) {
   // Serial_No found in the database
   if ($row['is_Authenticated'] == 'true') {
      // is_Authenticated is already set to true
      echo "Please contact seller";
   } else {
      // is_Authenticated is not set to true, update it
      echo "Authentic Product! Congrats";

      // Update the "is_Authenticated" column to "true" where the Serial_No is equal to the provided serial number
      $query = "UPDATE public.\"Nike_DB\" SET \"is_Authenticated\" = 'true' WHERE \"Nike_DB\".\"Serial_No\"='$serial_number'";

      $result = pg_query($db, $query);

      if (!$result) {
         echo "An error occurred while executing the query: " . pg_last_error($db);
         exit;
      }
   }
} else {
   // Serial_No not found in the database
   echo "Invalid Serial_No";
}

pg_close($db);

?>
