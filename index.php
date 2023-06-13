<style>
    .displayprs {
        position: relative;
        padding-left: 10px;
        left: 0px;
        bottom: -35px;
    }
    .displayprsside .displayprs{
        left: 135px;
    }
    body{
        background-color: #303339;
    }
    .ingelogdals{
        background-color: #3368EF;
        height: 65px;
        width: 150px;
        border: 1px solid;
        text-align: center;
        font-family: Didot;
        position: fixed;
        top: 5px;
        right: 20px;
    }
    .button-container {
        text-align: center;
    }

    .round-button {
        border: none;
        border-radius: 50%;
        background-color: yellow;
        color: black;
        padding: 15px 15px;
        font-size: 25px;
        cursor: pointer;
    }
</style>
<div class="button-container" style="height: 0px">
    <button class="round-button" onclick="navigateToPage('index.php')">📖</button>
    <button class="round-button" onclick="navigateToPage('oefeningen.php')">💪</button>
    <button class="round-button" onclick="navigateToPage('page3.php')">3</button>
</div>
<br><br>
<?
if (!isset($_COOKIE['logincookie'])) {
    header("Location: login.php");
    exit();
}
include 'databaseconn.php';
include "sidemenu.php";

echo $_COOKIE["logincookie"];
echo "<br>";
echo $_COOKIE["id"];

$id = $_GET["id"];
$delete = $_GET["delete"];
$teller = 1;
$kleur = "ffffff";
$sure = $_GET["sure"];
$add = $_GET["add"];
$benchpress = $_GET["bench_press"];
$deadlift = $_GET["dead_lift"];
$gebruikersnaam = $_GET["gebruikersnaam"];
$edit = $_GET["edit"];
$land = $_GET["land"];
$pasaan = $_GET["pasaan"];
$submit = $_GET["submit"];
$nieuweoefening = $_GET["nieuweoefening"];
$keuze = $_GET["keuze"];
$onderdeel = $_GET["onderdeel"];
$gebied = $_GET["gebied"];

/*
if ($add == 1) {

    ?>
    <b>Voeg een gast toe.</b>
    <form action="?" method="get">
        <input type="hidden" name="add" value="1">
        Oefening Naam: <input type="text" name="oefening_naam" value="<?php echo "$benchpress"; ?>"> <br>
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
*/
?>

<head>
    <center><b><h1 style="color: white; position: sticky; height: 0px">Trainingen</h1></b></center>
</head>
<br>
<b><p style="color: #ffffff;">Datum: <?php echo date("Y-m-d"); ?> </p></b>
<?php

if ($edit == 1) {

    if ($pasaan == 1) {
        $sqledit = "UPDATE gebruikers SET bench_press= '$benchpress', dead_lift = '$deadlift' WHERE id = $id";
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
            Bench Press: <input type="text" name="bench_press" value="<?php echo $row["bench_press"]; ?>"> <br>
            Dead Lift: <input type="text" name="dead_lift" value="<?php echo $row["dead_lift"]; ?>"> <br>
            <input type="submit" style="color:Green" value="Pas aan">
        </form> <br>
        <?php
    }
}
/*
?>

<form method="get" action="?">
    <select name="onderdeel" id="onderdeel">
        <?php
        $sql = "SELECT gebied FROM gebieden";
        $result = mysqli_query($conn,$sql);
        foreach ($result as $option) {?>
            <option selected><?php echo $option['gebied']; ?></option><?php } ?>
    </select><br>
    <input type="submit" value="Kies">
</form>
<?php
*/
if ($onderdeel != "") { ?>
<form method="get" action="?">
    <select name="keuze" id="keuze">
        <?php
        $sql = "SELECT $onderdeel FROM oefeningen";
        $result = mysqli_query($conn,$sql);
        foreach ($result as $option) {?>
        <option selected><?php echo $option[$onderdeel]; ?></option><?php } ?>
                    </select><br>
                    <input type="submit" value="Kies">
                </form>
                <?php } ?>
<?php
echo "<b><a href='?add=1' style='color: white;'>voeg een oefening toe:</a></b>";
if ($add == 1) {

    ?>
    <form action="?" method="get">
        <input type="hidden" name="add" value="1">
        Oefening Naam: <input type="text" name="nieuweoefening" value="<?php echo "$nieuweoefening"; ?>"> <br>
        <input type="submit" style="color:Green" name="submit" value="Toevoegen">
    </form>
    <?php
    if ($submit == "Toevoegen"){
        if ($nieuweoefening != "") {
            $sqladd = "ALTER TABLE trainingen
                        ADD $nieuweoefening varchar(25);";
            $result = $conn->query($sqladd);

            echo "De oefening is toegevoegd in de database. <br><br>";
        } else
        {
            echo "Alle velden moeten ingevuld zijn. <br><br>";
        }
    }
}
$sql = "SELECT * 
        FROM gebruikers 
        WHERE gebruikersnaam = '$_COOKIE[logincookie]'
        ORDER BY id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
?>

<div class="displayprs" >
    <table style="width: 450px; height: 120px;" >
        <tr style="background-color:#cccccc;">
            <th>ID</th>
            <th>GebruikersNaam</th>
            <th>Bench Press</th>
            <th>Dead Lift</th>
            <th>Dag Totaal</th>
        </tr>
        <?php
        while($row = $result->fetch_assoc()) {

            if ($teller == 2) {
                $kleur = "cccccc";
                $teller = $teller - 1;
            } else {
                $kleur = "ffffff";
                $teller = $teller + 1;
            }

            echo('<tr style="background-color:#' . $kleur . ';"> <td>' . $row["id"] . '</td> 
    <td><a href="index.php?edit=1&id=' . $row["id"] . '">' . $row["gebruikersnaam"] . '</a></td> 
    <td><a href="index.php?edit=1&id=' . $row["id"] . '">' . $row["bench_press"] . '</a> Kg</td> 
    <td><a href="index.php?edit=1&id=' . $row["id"] . '">' . $row["dead_lift"] . '</a> Kg</td> 
    <td><a href="index.php?edit=1&id=' . $row["id"] . '">' . $row["totaal"] . '</a> Kg</td> 
    <td><form action="?" method="get"><input type="hidden" name="delete" value="1"><input type="hidden" name="id" value="' . $row["id"] . '"></form></td> </tr>');
        }
        echo "</table>";
        //echo '<a href="index.php?add=1">Record toevoegen</a>';
        echo "</div>";
    } else {
        echo "0 results";
    }


    $conn->close();
    ?>
</table>
</div>

<div class="ingelogdals">
    <p>Ingelogd als:<br> <?php echo $_COOKIE["logincookie"] ?></p>
</div>

<script>
    function navigateToPage(pageUrl) {
        window.location.href = pageUrl;
    }
</script>