<?php
$add = $_GET["add"];
$submit = $_GET["submit"];
$nieuweoefening = $_GET["nieuweoefening"];
$nieuwetraining = $_GET["nieuwetraining"];
$datum = date("Y-m-d");
$datum_tijd = date("Y-m-d-s");
$gebruikersid = $_COOKIE['id'];
$edit = $_GET["edit"];
$pasaan = $_GET["pasaan"];
$training_naam = $_GET["training_naam"];
$id = $_GET["id"];
$teller = 1;
$gebieden = array("schouders", "rug", "chest", "armen", "core", "benen");
$oefening = $_GET["oefening"];

?>

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
    .dropdown{
        position: center;
    }
    .dropdown-btn {
        background-color: #303339;
        color: black;
        padding: 10px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 12px 16px;
    }

    .dropdown-content a {
        color: black;
        padding: 6px 0;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>
<br>
<br>
<?php
if (!isset($_COOKIE['logincookie'])) {
    header("Location: login.php");
    exit();
}
include 'databaseconn.php';
include "sidemenu.php";


echo "<b><a href='?add=1' style='color: white;'>voeg een training toe:</a></b>";
if ($add == 1) {

    ?>
    <form action="?" method="get">
        <input type="hidden" name="add" value="1">
        <p style="color: white">Training Naam: <input type="text" name="nieuwetraining" value="<?php echo "$nieuwetraining"; ?>"></p>
        <p style="color: white">Datum: <?php echo "$datum"; ?></p>
        <input type="submit" style="color:Green" name="submit" value="Toevoegen">
    </form>
    <?php
    if ($submit == "Toevoegen"){
        if ($nieuwetraining != "") {
            $sqladd = "INSERT INTO trainingen (gebruikers_id, naam, datum) VALUES ($gebruikersid, '$nieuwetraining', '$datum')";
            header("Location: trainingen.php");
            $result = $conn->query($sqladd);

            echo "<p style='color: white'>De gast is toegevoegd in de database.</p> <br><br>";

            $sqlid = "SELECT id FROM trainingen ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sqlid);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = $row['id'];
            }
            $sql = "INSERT INTO trainingen_oefeningen (trainingen_id, oefeningen_id, gewicht, reps)
                    SELECT '$lastId', gebruikers_id, 52, 10
                    FROM trainingen
                    ORDER BY id DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<p style='color: white'>De gast is toegevoegd in de tabel: trainingen_oefeningen</p> <br><br>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }


        } else
        {
            echo "<p style='color: white'>Alle velden moeten ingevuld zijn.</p> <br><br>";
        }
    }
}
$sql = "SELECT *
        FROM trainingen
        WHERE gebruikers_id = '$_COOKIE[id]'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
?>



<script>
    document.querySelector('.menu-toggle').addEventListener('click', function() {
        document.body.classList.toggle('menu-open');
        document.body.classList.toggle('displayprsside');
        document.body.classList.toggle('menu-toggleleft');
    });

</script>
<?php

if ($edit == 1) {
    if ($pasaan == 1) {
        $sqledit = "UPDATE trainingen SET naam= '$training_naam' WHERE id = $id";
        $result = $conn->query($sqledit);
        echo "Het record is aangepast in de database. <br><br>";
        //header("Location: trainingen.php");

    }
    $sql = "SELECT * FROM trainingen WHERE id = $id";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        ?>
        <b style="color: white">Pas de training met id <?php echo "$id"; ?> aan.</b>
        <form action="?" method="get">
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="pasaan" value="1">
            <input type="hidden" name="id" value="<?php echo "$id"; ?>">
            <p style="color: white;">Workout Naam:</p> <input type="text" name="training_naam" value="<?php echo $row["naam"]; ?>"> <br>
            <p style="color: white;">oefening toevoegen:</p> <?php

            foreach ($gebieden as $gebied) {
                echo '<br>';
                echo '<div class="dropdown">';
                echo '<button style="color: white" class="dropdown-btn">' . ucfirst($gebied) . '</button>';
                echo '<div class="dropdown-content">';

                $sql = "SELECT id, oefening FROM oefeningen WHERE gebied = '$gebied'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $oefeningNaam = $row['oefening'];

                        echo '<a href=#oefening=' . $oefeningNaam . '>' . $oefeningNaam . '</a>';
                    }
                }
                echo '</div>';
                echo '</div>';
            }
                ?>
            <br>
            <input type="submit" style="color:Green" value="Pas aan">
        </form> <br>
        <?php
    }
}
?>

<div class="displayprs" >
    <table style="width: 450px; height: 120px;" >
        <tr style="background-color:#cccccc;">
            <th>Gebruikers ID</th>
            <th>Naam</th>
            <th>Datum</th>
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

            echo('<tr style="background-color:#' . $kleur . ';"> <td>' . $row["gebruikers_id"] . '</td>
    <td><a href="trainingen.php?edit=1&id=' . $row["id"] . '">' . $row["naam"] . '</a></td> 
    <td><a href="trainingen.php?edit=1&id=' . $row["id"] . '">' . $row["datum"] . '</a></td> 
    <td><form action="?" method="get"><input type="hidden" name="delete" value="1"><input type="hidden" name="id" value="' . $row["id"] . '"></form></td> </tr>');
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p style='color: white'>0 resultaten</p>";
    }
        $conn->close();
    ?>
<div class="ingelogdals">
    <p>Ingelogd als:<br> <?php echo $_COOKIE["logincookie"] ?></p>
</div>

<?php
