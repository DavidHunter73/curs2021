<?php
    $servername = "localhost";
    $database = "dhernandez_unity";
    $username = "dhernandez";
    $password = "dhernandez";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
    }
     
    echo "Connected successfully";
     
    $sql = "INSERT INTO Users (email, nombre, contrasena, puntos, personaje, nivelMax) VALUES ('".$_POST['email']."','".$_POST['nombre']."','".$_POST['contrasena']."',0,1,0);";
    if (mysqli_query($conn, $sql)) {
          echo "New record created successfully";
    } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
?>