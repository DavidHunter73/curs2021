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

    $newPuntos = 0;
    $newLevelMax = 0;


    $sql = "SELECT * from Users where email = '".$_POST['email']."';";

    $result = $conn->query($sql);

    //echo $row["nombre"];
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $newPuntos = $row["puntos"];
            $newLevelMax = $row["nivelMax"]; //$_POST['email']
        }
    } else {
        //echo "";
    }

    if($newPuntos < $_POST['puntos']){
        $sql = "UPDATE Users SET puntos = '".$_POST['puntos']."' WHERE email = '".$_POST['email']."';";
        $result = $conn->query($sql);
    }

    if($newLevelMax < $_POST['nivelMax']){
        $sql = "UPDATE Users SET nivelMax = '".$_POST['nivelMax']."' WHERE email = '".$_POST['email']."';";
        $result = $conn->query($sql);
    }
 

    $conn->close();
?>