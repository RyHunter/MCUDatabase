<?php
        ini_set('display_errors', 'On');

        $mysqli = new mysqli("test", "test", "test", "test");

        if($mysqli->connect_errno){
                echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        echo 'Successfully connected to the database ';

?>



<!DOCTYPE html>
<html>
<head>
<title>DELETE</title>
<link rel="stylesheet" type="text/css" href="dbstyle">
</head>
<body>

<?php
        $delete = $_POST['id'];

        if(!($stmt = $mysqli->prepare("DELETE FROM character_tbl WHERE id = ?"))){
                echo "Prepare failed" . $stmt->errno . " " . $stmt->error;

        }

        if(!($stmt->bind_param("i", $delete))){
                echo "Bind failed: " .$stmt->errno . " " . $stmt->error;
        }


        if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
        } else {
                echo " and deleted " .$stmt->affected_rows . " row from character_tbl";
        }

        $stmt->close();
?>

<br><br>

<?php
        echo "<a href='http://web.engr.oregonstate.edu/~kalashne/MCUDatabase.php'>RETURN</a>";
?>


</body>
</html>
