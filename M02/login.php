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

    $sql = "SELECT * from Users";

    $result = $conn->query($sql);

    //echo $row["nombre"];
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        if($row["email"] == $_POST['email'] && $row["contrasena"] == $_POST['contrasena']){
          echo $row["email"];
        }
      }
    } else {
      echo "";
    }
    $conn->close();
?>