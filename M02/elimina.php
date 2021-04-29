<?php
    $servername = "localhost";
    $database = "dhernandez_unity";
    $username = "dhernandez";
    $password = "dhernandez";
    
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    //$sql = "SELECT * from Users where email = $_POST['email']";

    //$sql = "UPDATE Users SET email = '".$_POST['email']."', nombre = '".$_POST['nombre']."', contrasena = '".$_POST['contrasena']."' WHERE email = '".$_POST['exEmail']."';";
    $sql = "DELETE FROM Users WHERE email = '".$_POST['email']."';";

    $result = $conn->query($sql);

    echo $result;

    $conn->close();
?>