<?php

        ini_set('display_errors', 'On');

        $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "kalashne-db", "iW7Bw2pTnV6Vu8Cg", "kalashne-db");

        if($mysqli->connect_errno){
                echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        echo 'Successfully connected!';

?>

<!DOCTYPE html>
<html>
<head>
<title>MCU DATABASE</title>
<link rel="stylesheet" type="text/css" href="dbstyle.css">
</head>

<body>

<div align="center">

<h2>CS340 Final Project</h2>
<h1>Marvel Cinematic Universe Characters Database</h1>
<h1>Author: Katrina Kalashnikova</h1>

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
        if(!($stmt = $mysqli->prepare("SELECT DISTINCT C.name, C.species, C.home, T.name, P.name, W.name, N.name FROM `character_tbl` C INNER JOIN char_team_tbl CT ON CT.char_id = C.id INNER JOIN team_tbl T ON T.id = CT.team_id INNER JOIN char_pow_tbl CP ON CP.char_id = C.id INNER JOIN power_tbl P ON P.id = CP.pow_id INNER JOIN char_nem_tbl CN ON CN.char_id = C.id INNER JOIN nemesis_tbl N ON N.id=CN.nem_id INNER JOIN char_weap_tbl CW ON CW.char_id = C.id INNER JOIN weapon_tbl W ON W.id = CW.weap_id"))){
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
<h2>Add a new character to the database</h2>
<br>
<div>
 <form method="post" action="addCharacter.php" >
  <fieldset>
  <legend>Add a new hero</legend>
   <label>Name</label>
    <input type = "text" name="name" required><br>
   <label>Species</label>
    <input type="text" name="species"><br>
   <label>Home</label>
 <input type="text" name="home"><br>
   <label>Power</label>
   <select name="char_power">

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
        echo "<option value='". $id . "', name= 'char_power'>" . $name . "</option>";

}

$stmt->close();

?>



</select>
<br>
<label>Team</label>
  <select name = "char_team">
   <?php
if(!($stmt = $mysqli->prepare("SELECT * FROM `team_tbl`"))){

        echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

}

if(!($stmt->execute())){
        echo "Execute failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

}

if(!($stmt->bind_result($id, $name))){
        echo "Bind failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

}

while ($stmt->fetch()){
        echo "<option value='". $id . "'>" . $name . "</option>";

}

$stmt->close();

?>
</select>
<br>

  <label>Nemesis</label>
  <select name = "char_nem">
   <?php
if(!($stmt = $mysqli->prepare("SELECT * FROM `nemesis_tbl`"))){

        echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

}

if(!($stmt->execute())){
        echo "Execute failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

}

if(!($stmt->bind_result($id, $name))){
        echo "Bind failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;

}

while ($stmt->fetch()){
        echo "<option value='". $id . "'>" . $name . "</option>";

}

$stmt->close();

?>
 </select>

<br>

  <label>Weapon</label>
  <select name = "char_weap">
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
        echo "<option value='". $id . "'>" . $name . "</option>";

}

$stmt->close();

?>
</select>
  </fieldset>
  <input type = "submit" name="add" value="Add"/>
</form>
</div>

<br><br>
<h2>Don't see what you're looking for?</h2>
<h2>Enter more options!</h2>

<div>
 <form method="post" action="addPower.php">
   <fieldset>
    <legend>Add a new power or ability</legend>
        <label>Name</label>
        <input type = "text" name="PName" required/>
   </fieldset>
   <input type="submit" name="add" value="Add Power"/>
 </form>
</div>

<div>
 <form method="post" action="addTeam.php">
  <fieldset>
   <legend>Add a new team</legend>
<label>Name</label>
        <input type="text" name="TName" required/>
  </fieldset>
  <input type="submit" name="add" value="Add Team"/>
 </form>
</div>
<br><br>

<div>
 <form method="post" action="addNemesis.php">
  <fieldset>
   <legend>Add a new nemesis</legend>
        <label>Name</label>
        <input type="text" name="NName" required/>
  </fieldset>
  <input type="submit" name="add" value="Add Baddie"/>
 </form>
</div>

<br><br>

<div>
 <form method="post" action="addWeapon.php">
  <fieldset>
   <legend>Add a new weapon</legend>
        <label>Name</label>
        <input type="text" name="WName" required/>
  </fieldset>
  <input type="submit" name="add" value="Add Weapon"/>
 </form>
</div>


<br><br>

<h2>All entered characters so far</h2>
<table>
<tr>
<th>Entry ID</th>
<th>Name</th>
<th>Species</th>
<th>Home</th>
<th>Team</th>
</tr>

<?php
        if(!($stmt = $mysqli->prepare("SELECT  C.id, C.name, C.species, C.home, T.name  FROM `character_tbl` C INNER JOIN char_team_tbl CT ON CT.char_id = C.id INNER JOIN team_tbl T ON T.id = CT.team_id"))){
                echo "Prepare failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        if(!($stmt->execute())){
                echo "Execute failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
if(!($stmt->execute())){
                echo "Execute failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        if(!($stmt->bind_result($id, $name, $species, $home,  $team))){
                echo "Bind failed" . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }

        while ($stmt->fetch()){
                echo "<tr>\n<td>" . $id . "\n</td>\n<td>" . $name . "</td>\n<td>" . $species . "</td><td>" . $home . "</td><td>" . $team . "</td></tr>";
        }

        $stmt->close();

?>

</table>

<br><br>
<h2>Edit an entry</h2>
<form method='post' action='edit.php'>
<fieldset>
<legend>Edit</legend>
<label>Name of character to edit:</label>
<input type = 'text' name='name' required/><br>
<label>Enter updated name</label>
<input type = 'text' name='new_name' required/><br>
<label>Enter updated species</label>
<input type = 'text' name='species' required/><br>
<label>Enter updated home</label>
<input type = 'text' name='home' required/><br>
</fieldset>
<input type='submit' name = "edit" value="Edit"/>
</form>
<br><br>

<h2>Messed up? Delete stuff!</h2>
<form method='post' action='delete.php'>
<legend><h3>Enter ID of the entry you want to delete</h3></legend>
<input type = 'text' name='id' required/><br>
<input type = 'submit' name='delete' value='Delete'/>
</form>
<br><br>

</div>
</body>
</html>
