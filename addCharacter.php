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
<head><title>HERO</title></head>
<link rel="stylesheet" type="text/css" href="dbstyle">
<body>

<?php

        //Add new character
        if(!($stmt = $mysqli->prepare("INSERT INTO character_tbl (name, species, home) VALUES (?,?,?)"))){
                echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

        }

        if(!($stmt->bind_param("sss",$_POST['name'], $_POST['species'], $_POST['home']))){
                echo "Bind failed: " .$stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
        }



        //Add power to character
        $var = $_POST['name'];

        if(!($stmt = $mysqli->prepare("SELECT `id` FROM `character_tbl` WHERE `name` = '$var'"))){

        echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

        }

        if(!($stmt->execute())){
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;

        }

        if(!($stmt->bind_result($c_id))){
        echo "Bind failed: " .$stmt->errno . " " . $stmt->error;
        }
         while($stmt->fetch()){
                echo " and added a new character with id  " . $c_id;
        }

        $p_id = $_POST['char_power'];

        if(!($stmt = $mysqli->prepare("INSERT INTO `char_pow_tbl` (char_id, pow_id) VALUES (?,?)"))){
                echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

        }

        if(!($stmt->bind_param("ii",$c_id, $p_id))){
                echo "Bind failed: " .$stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
        }


        //Add character to a team
        $t_id = $_POST['char_team'];

        if(!($stmt = $mysqli->prepare("INSERT INTO `char_team_tbl` (char_id, team_id) VALUES (?,?)"))){
                echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

        }

        if(!($stmt->bind_param("ii",$c_id, $t_id))){
                echo "Bind failed: " .$stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
        }

        //Add nemesis to character
        $n_id = $_POST['char_nem'];

        if(!($stmt = $mysqli->prepare("INSERT INTO `char_nem_tbl` (char_id, nem_id) VALUES (?,?)"))){
                echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

        }

        if(!($stmt->bind_param("ii",$c_id, $n_id))){
                echo "Bind failed: " .$stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
        }


        //Add weapon to character
        $w_id = $_POST['char_weap'];
          if(!($stmt = $mysqli->prepare("INSERT INTO `char_weap_tbl` (char_id, weap_id) VALUES (?,?)"))){
                echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

        }

        if(!($stmt->bind_param("ii",$c_id, $w_id))){
                echo "Bind failed: " .$stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
        }

?>

<br><br>
<table>
<tr>
<th>Name</th>
<th>Species</th>
<th>Home</th>
<th>Team</th>
<th>Power</th>
<th>Weapon</th>
<th>Nemesis</th>
</tr>

<?php
        //View characters
        if(!($stmt = $mysqli->prepare("SELECT C.name, C.species, C.home, T.name, P.name, W.name, N.name FROM `character_tbl` C INNER JOIN char_team_tbl CT ON CT.char_id = C.id INNER JOIN team_tbl T ON T.id = CT.team_id INNER JOIN char_pow_tbl CP ON CP.char_id = C.id INNER JOIN power_tbl P ON P.id = CP.pow_id INNER JOIN char_nem_tbl CN ON CN.char_id = C.id INNER JOIN nemesis_tbl N ON N.id=CN.nem_id INNER JOIN char_weap_tbl CW ON CW.char_id = C.id INNER JOIN weapon_tbl W ON W.id = CW.weap_id"))){

        echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

}

if(!($stmt->execute())){
        echo "Execute failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

}

if(!($stmt->bind_result($name, $species, $home,  $team, $power, $weapon, $nemesis ))){

        echo "Bind failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

}

while ($stmt->fetch()){
        echo "<tr>\n<td>" . $name . "\n</td>\n<td>" . $species . "</td>\n<td>" . $home . "</td><td>" . $team . "</td><td>" . $power . "</td><td>" . $weapon . "\n</td>\n<td>" . $nemesis . "</td></tr>";
}


        $stmt->close();
?>

</table>
<br><br>

<?php
        echo "<a href='http://web.engr.oregonstate.edu/~kalashne/MCUDatabase.php'>RETURN</a>";
?>

</body>
</html>
