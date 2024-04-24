<?php
if($_GET["temp"]&&$_GET["humid"])
{
  // --------------- CONNECTION ------------------- //
  $servername = "localhost";
  $username = "arduino_user";
  $password = "admin";
  $dbname = "mysql";

  // Getting values
  $name = $_GET["name"];
  $humid = $_GET["humid"];
  $temp = $_GET["temp"];

  // Create connection via to object
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}
  
  // --------------- QUERY TEMP DATABASE ---------------- //
  $sql = "INSERT INTO temp_humid_table (sensor_name, sensor_value,t_stamp)
           VALUES ('temp_".$name."', '".$temp."',CURRENT_TIMESTAMP)";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } 
  else 
  {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  // --------------- QUERY HUMID DATABASE ---------------- //
  $sql = "INSERT INTO temp_humid_table (sensor_name, sensor_value,t_stamp)
           VALUES ('humid_".$name."', '".$humid."',CURRENT_TIMESTAMP)";
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } 
  else 
  {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  // Close Connection
  $conn->close();
  echo "OK";
}

?>
