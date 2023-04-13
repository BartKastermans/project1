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
    .side-menu {
        position: fixed;
        top: 0;
        left: -200px;
        width: 150px;
        height: 100%;
        background-color: #eeeff1;
        transition: left 0.2s ease-in-out;
    }

    .menu-open .side-menu {
        left: 0;
    }

    .menu-toggle {
        position: fixed;
        padding: 10px;
        left: 20px;
        top: 5px;
        background-color: #f2f2f2;
        border: none;
        cursor: pointer;
    }
    .menu-toggleleft .menu-toggle{
        left: 155px;
    }
    body{
        background-color: #303339;
    }
</style>

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
$edit = $_GET["edit"];
$land = $_GET["land"];
$pasaan = $_GET["pasaan"];
$submit = $_GET["submit"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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


$sql = "SELECT * FROM gebruikers ORDER BY id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
?>
<div class="menu-toggle">
    <button class="menu-toggle" >Open Menu</button>
</div>

<div class="side-menu">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="prs.php">PRs</a></li>
        <li><a href="kalender.php">Kalender</a></li>
    </ul>
</div>

<div class="displayprs" >
    <table style="width: 350px; height: 120px;" >
        <tr style="background-color:#cccccc;">
            <th>ID</th>
            <th>GebruikersNaam</th>
            <th>Bench Press</th>
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
    <td><a href="index.php?edit=1&id=' . $row["id"] . '">' . $row["bench_press"] . ' Kg</a></td> 
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

        <script>
            document.querySelector('.menu-toggle').addEventListener('click', function() {
                document.body.classList.toggle('menu-open');
                document.body.classList.toggle('displayprsside');
                document.body.classList.toggle('menu-toggleleft');
            });

        </script>
