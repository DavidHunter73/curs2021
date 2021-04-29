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

    $sql = "SELECT * from Users ORDER BY puntos DESC";

    $result = $conn->query($sql);

    $ranking = "";
    $position = 1;

    //echo $row["nombre"];
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {       
          if($position <= 5) $ranking .= strval($position) . "-" . $row["nombre"] . "\nPuntos:" . strval($row["puntos"]) . "\n\n";
          $position++;
      }
      echo $ranking;
    } else {
      echo "";
    }
    $conn->close();
?>