<?php
        ini_set('display_errors', 'On');

        $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kalashne-db", "iW7Bw2pTnV6Vu8Cg", "kalashne-db");

        if($mysqli->connect_errno){
                echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        echo 'Successfully connected to database ';

?>



<!DOCTYPE html>
<html>
<head>
<title>WEAPON</title>
<link rel="stylesheet" type="text/css" href="dbstyle">
</head>
<body>

<?php

        if(!($stmt = $mysqli->prepare("INSERT INTO weapon_tbl (name) VALUES (?)"))){
                echo "Prepare failed" . $stmt->errno . " " . $stmt->error;

        }

        if(!($stmt->bind_param("s",$_POST['WName']))){
                echo "Bind failed: " .$stmt->errno . " " . $stmt->error;
        }


        if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
        } else {
                echo " and added " .$stmt->affected_rows . " row to weapon_tbl";
        }

        $stmt->close();

?>

<br><br>
<ul>

<?php
if(!($stmt = $mysqli->prepare("SELECT * FROM `weapon_tbl`"))){
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
