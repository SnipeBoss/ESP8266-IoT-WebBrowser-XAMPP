<?php

// Enable CORS (Optional)
// Comment this line out if CORS is not required for your application
header("Access-Control-Allow-Origin: *");

// Database Credentials
$servername = "localhost";
$username = "arduino_user";
$password = "admin";
$dbname = "mysql";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}

// Define the SQL query to retrieve data
$sql = "SELECT * FROM temp_humid_table";
$result = $conn->query($sql);

// Prepare an empty array to store results
$resultArray = array();

// Process results if there are rows returned by the query
if ($result->num_rows > 0) 
{
  // Loop through each row of data
  while($row = $result->fetch_assoc()) 
  {
    // Convert each row (associative array) to JSON format and add it to the results array
    array_push($resultArray, $row);
  }
  // Encode the entire results array as a JSON string and echo it (likely as a response)
  echo json_encode($resultArray ); 
} 
else 
{
  // If no results found, echo a message indicating "0 results"
  echo "0 results";
}

// Close the connection to the database
$conn->close();
?>
