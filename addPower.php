<?php
        ini_set('display_errors', 'On');

        $mysqli = new mysqli("test", "test", "test", "test");

        if($mysqli->connect_errno){
                echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        echo 'Successfully connected to database ';

?>



<!DOCTYPE html>
<html>
<head>
<title>POWER</title>
<link rel="stylesheet" type="text/css" href="dbstyle">
</head>
<body>

<?php

        if(!($stmt = $mysqli->prepare("INSERT INTO power_tbl (name) VALUES (?)"))){
                echo "Prepare failed" . $stmt->errno . " " . $stmt->error;

        }

        if(!($stmt->bind_param("s",$_POST['PName']))){
                echo "Bind failed: " .$stmt->errno . " " . $stmt->error;
        }


        if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
        } else {
                echo " and added " .$stmt->affected_rows . " row to power_tbl";
        }

        $stmt->close();
?>

<br><br>
<ul>
<?php

        if(!($stmt = $mysqli->prepare("SELECT * FROM `power_tbl`"))){
        echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        if(!($stmt->execute())){
        echo "Execute failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        if(!($stmt->bind_result($id, $name))){
        echo "Bind failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;
 }

        while ($stmt->fetch()){
        echo "<li>" . $name . "</li>";
        }

        $stmt->close();

?>

</ul>
<br><br>

<?php
        echo "<a href='http://web.engr.oregonstate.edu/~kalashne/MCUDatabase.php'>RETURN</a>";
?>

</body>
</html>
