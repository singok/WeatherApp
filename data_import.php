<?php

// Select weather data for given parameters
$sql = "SELECT * FROM weather WHERE city = '{$_GET['city']}' AND weather_time >= DATE_SUB(NOW(), INTERVAL 30 MINUTE) ORDER BY weather_time DESC limit 1";
$result = $mysqli -> query($sql);

// If 0 record found
if ($result->num_rows == 0) {
$url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $_GET['city'] . '&appid=39e28ead88b8426b24216d50dcd1e2d5';

// Get data from openweathermap and store in JSON object
$data = file_get_contents($url);
$json = json_decode($data, true);

// Fetch required fields
$temperature = $json['main']['temp'];
$feels_like = $json['main']['feels_like'];
$temp_max = $json['main']['temp_max'];
$temp_min = $json['main']['temp_min'];
$speed = $json['wind']['speed'];
$visibility = $json['visibility'];
$pressure = $json['main']['pressure'];
$humidity = $json['main']['humidity'];
$weather_desc = $json['weather'][0]['description'];
$city = $json['name'];
$weather_time = date("Y-m-d H:i:s"); // now
$icon = $json['weather'][0]['icon'];

// Build INSERT SQL statement
$sql = "INSERT INTO weather (temperature, feels_like, temp_max, temp_min, speed, visibility, pressure, humidity, weather_desc, city, weather_time, icon) VALUES({$temperature}, {$feels_like}, {$temp_max}, {$temp_min}, {$speed}, {$visibility}, {$pressure},{$humidity}, '{$weather_desc}', '{$city}', '{$weather_time}', '{$icon}')";

// Run SQL statement and report errors
if (!$mysqli -> query($sql)) {
echo("<h4>SQL error description: " . $mysqli -> error . "</h4>");
}
}
?>