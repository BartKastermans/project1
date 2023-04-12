<?
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1login";

$id = $_GET["id"];
$delete = $_GET["delete"];
$teller = 1;
$kleur = "ffffff";
$sure = $_GET["sure"];
$add = $_GET["add"];
$benchpress = $_GET["bench_press"];
$gebruikersnaam = $_GET["gebruikersnaam"];
$email = $_GET["email"];
$telefoonnummer = $_GET["telefoonnummer"];
$edit = $_GET["edit"];
$adres = $_GET["adres"];
$postcode = $_GET["postcode"];
$woonplaats = $_GET["woonplaats"];
$land = $_GET["land"];
$pasaan = $_GET["pasaan"];
$submit = $_GET["submit"];

include 'test_input.php';
include 'navigatie.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($add == 1) {
    ?>
    <b>Voeg een gast toe.</b>
    <form action="?" method="get">
        <input type="hidden" name="add" value="1">
        Voornaam: <input type="text" name="bench_press" value="<?php echo "$benchpress"; ?>"> <br>
        <input type="submit" style="color:Green" name="submit" value="Toevoegen">
    </form>
    <?php
    if ($submit == "Toevoegen"){
        if ($benchpress != "") {
            $sqladd = "INSERT INTO gebruikers (benchpress) VALUES ('$benchpress')";
            $result = $conn->query($sqladd);

            echo "De gast is toegevoegd in de database. <br><br>";
        } else
        {
            echo "Alle velden moeten ingevuld zijn. <br><br>";
        }
    }
}

if ($edit == 1) {

    if ($pasaan == 1) {
        $sqledit = "UPDATE gebruikers SET bench_press = '$benchpress' WHERE id = $id";
        $result = $conn->query($sqledit);
        echo "Het record is aangepast in de database. <br><br>";
    }

    $sql = "SELECT * FROM gebruikers WHERE id = $id";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        ?>
        <b>Pas de gast met id <?php echo "$id"; ?> aan.</b>
        <form action="?" method="get">
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="pasaan" value="1">
            <input type="hidden" name="id" value="<?php echo "$id"; ?>">
            bench_press: <input type="text" name="bench_press" value="<?php echo $row["bench_press"]; ?>"> <br>
            <input type="submit" style="color:Green" value="Pas aan">
        </form> <br>
        <?php
    }
}

$sqldelete = "DELETE FROM gebruikers WHERE id = $id";
if ($delete == 1) {
    if ($sure == 1) {
        $result = $conn->query($sqldelete);
        echo "Het record met id $id is succesvol verwijderd uit de database. <br><br>";
    } else {
        echo 'Weet je het zeker domme os? <table> <tr> <td><form action="?" method="get"><input type="hidden" name="sure" value="1"><input type="hidden" name="delete" value="1"><input type="hidden" name="id" value="' . $id . '"><input type="submit" style="color:Green" value="Ja"></form></td> <td><form action="?" method="get"><input type="submit" style="color:Red" value="Nee"></form></td></tr></table><br><br>';
    }
}

$sql = "SELECT * FROM gebruikers ORDER BY id";
$result = $conn->query($sql);

echo('<b>Deze info komt uit de database:<br></b>');

if ($result->num_rows > 0) {
?>
<table>
    <tr style="background-color:#cccccc;">
        <th>ID</th>
        <th>GebruikersNaam</th>
        <th>Bench Press</th>
        <th>&nbsp;</th>
    </tr>
    <?php
    while($row = $result->fetch_assoc()) {
        // echo "id: " . $row["id"]. " - Name: " . $row["bench_press"]. " " . $row["lastname"]. "<br><br>";

        if ($teller == 2) {
            $kleur = "cccccc";
            $teller = $teller - 1;
        } else {
            $kleur = "ffffff";
            $teller = $teller + 1;
        }

        echo('<tr style="background-color:#' . $kleur . ';"> <td>' . $row["id"] . '</td> 
<td><a href="index.php?edit=1&id=' . $row["id"] . '">' . $row["gebruikersnaam"] . '</a></td> 
<td><a href="index.php?edit=1&id=' . $row["id"] . '">' . $row["bench_press"] . '</a></td> 
<td><form action="?" method="get"><input type="hidden" name="delete" value="1"><input type="hidden" name="id" value="' . $row["id"] . '"><input type="submit" style="color:red" value="Delete"></form></td> </tr>');
    }
    echo "</table>";
    } else {
        echo "0 results";
    }

    echo '<a href="index.php?add=1">Record toevoegen</a>';

    $conn->close();


    ?>
