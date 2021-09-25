<?php
// Connect to database
$mysqli = new mysqli("localhost","root","","db2060375");
if ($mysqli -> connect_errno) {
echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
exit();
}

// First, check requested data is present and fresh
include('data_import.php');

// Execute SQL query
$sql = "SELECT * FROM weather ORDER BY weather_time DESC limit 1";
$result = $mysqli -> query($sql);

// Get data, convert to JSON and print
$row = $result -> fetch_assoc();

$sql = "SELECT * FROM weather WHERE city = '{$_GET['city']}' AND weather_time >= DATE_SUB(NOW(), INTERVAL 30 MINUTE) ORDER BY weather_time DESC limit 1";
$result = $mysqli -> query($sql);
print json_encode($row);

// Free result set and close connection
$result -> free_result();
$mysqli -> close();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
?>