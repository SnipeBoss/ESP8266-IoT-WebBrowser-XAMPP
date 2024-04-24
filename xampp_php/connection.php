<?php

// Database Credentials
$servername = "localhost";  // Hostname or IP address of the MySQL server (often "localhost" for local databases)
$username = "arduino_user";  // Username for accessing the database
$password = "admin";         // Password for the database user

// Create connection -> create object mysql (dont need to include sql cause we use XAMPP)
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) 
{
    // Close connection and respond error to web brownser
    die("Connection failed: " . $conn->connect_error);
} 
else 
{
    echo "Connected successfully";
}

// **Note:** This script currently only establishes a connection and displays a success message. 
// In most cases, you'll want to perform database operations (select, insert, update, etc.) after connecting.

// Close the connection (optional, often placed at the end of your database interaction script)
// $conn->close();

?>
