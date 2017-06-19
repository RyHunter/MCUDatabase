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
<title>EDIT</title>
<link rel="stylesheet" type="text/css" href="dbstyle">
</head>
<body>

<?php

        $name = $_POST['name'];
        $new_name = $_POST['new_name'];
        $species=$_POST['species'];
        $home = $_POST['home'];

        if(!($stmt = $mysqli->prepare("UPDATE character_tbl  SET `name` = ?, `species` = ?, `home` = ? WHERE `name` = '$name'"))){
                echo "Prepare failed" . $mysqli->errno . " " . $mysqli->error;

        }

        if(!($stmt->bind_param("sss",$new_name, $species, $home))){
                echo "Bind failed: " .$stmt->errno . " " . $stmt->error;
        }


        if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
        } else {
                echo " and changed " .$stmt->affected_rows . " rows in char__tbl";
        }

        $stmt->close();
?>

<br><br>

<?php
        echo "<a href='http://web.engr.oregonstate.edu/~kalashne/MCUDatabase.php'>RETURN</a>";
?>


</body>
</html>
