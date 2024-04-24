<?php
header("Access-Control-Allow-Origin: *");

if($_GET["name"])
{
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

    $sql = "SELECT * FROM temp_humid_table 
        WHERE sensor_name =" .$_GET["name"]. 
        " ORDER BY t_stamp DESC LIMIT 50";

    $result = $conn->query($sql);
    $resultArray = array();

    if ($result->num_rows > 0) 
    {
        // output data of each row
        while($row = $result->fetch_assoc()) 
        {
            array_push($resultArray,$row);
        }
        echo json_encode($resultArray );	
    } 
    else 
    {
        echo "0 results";
    }
    $conn->close();
}

?>