<?php
$add = $_GET["add"];
$submit = $_GET["submit"];
$nieuweoefening = $_GET["nieuweoefening"];
$nieuwetraining = $_GET["nieuwetraining"];
$datum = date("Y-m-d");
$gebruikersid = $_COOKIE['id'];
$edit = $_GET["edit"];
$pasaan = $_GET["pasaan"];
$training_naam = $_GET["training_naam"];
$id = $_GET["id"];


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
</style>
<br>
<br>
<?php
if (!isset($_COOKIE['logincookie'])) {
    header("Location: login.php");
    exit();
}
include 'databaseconn.php';
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
            $result = $conn->query($sqladd);

            echo "<p style='color: white'>De gast is toegevoegd in de database.</p> <br><br>";
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
<div class="menu-toggle">
    <button class="menu-toggle" >Open Menu</button>
</div>

<div class="side-menu">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="prs.php">PRs</a></li>
        <li><a href="trainingen.php">Trainingen</a></li>
        <li><a href="kalender.php">Kalender</a></li>
    </ul>
</div>


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
    }

    $sql = "SELECT * FROM trainingen WHERE id = $id";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        ?>
        <b>Pas de gast met id <?php echo "$id"; ?> aan.</b>
        <form action="?" method="get">
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="pasaan" value="1">
            <input type="hidden" name="id" value="<?php echo "$id"; ?>">
            Naam: <input type="text" name="training_naam" value="<?php echo $row["naam"]; ?>"> <br>
            <input type="submit" style="color:Green" value="Pas aan">
        </form> <br>
        <?php
    }
}
    $sql = "SELECT * FROM trainingen";
    $result = $conn->query($sql);
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
        //echo '<a href="index.php?add=1">Record toevoegen</a>';
        echo "</div>";
    } else {
        echo "0 results";
    }
        $conn->close();
    ?>
<div class="ingelogdals">
    <p>Ingelogd als:<br> <?php echo $_COOKIE["logincookie"] ?></p>
</div>

<?php
