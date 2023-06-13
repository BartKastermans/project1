<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1login";

$add = $_GET["add"];
$gebruikersnaam = $_GET["gebruikersnaam"];
$wachtwoord = $_GET["wachtwoord"];
$gehashedwachtwoord = sha1($wachtwoord);
$submit = $_GET["submit"];


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registreren</title>
    <style>
        body{
            background-image: url("https://cdn.dribbble.com/users/1638984/screenshots/3571431/media/caf6bd6916be9c1195c3fe4c0f748d72.jpg");
            background-repeat: no-repeat;
            background-size: 100%;
            background-position-y: -90px;
        }
        .login{
            background-color: #3368EF;
            height: 230px;
            width: 230px;
            border: 1px solid;
            text-align: center;
            font-family: Didot;
            margin: auto;

        }
    </style>
</head>
<body>
<?php
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = $_POST["gebruikersnaam"];
    $wachtwoord = $_POST["wachtwoord"];

    $sql = "SELECT gebruikersnaam, wachtwoord
            FROM gebruikers
            WHERE gebruikersnaam='$gebruikersnaam' AND wachtwoord='$wachtwoord'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION["gebruikersnaam"] = $gebruikersnaam;
        header("Location: index.php");
        exit();
    } else {
        // If no matching user is found, display error message
        $error_message = "Invalid username or password.";
    }
}


    ?>
    <b>Voeg een gebruiker toe.</b>
    <form action="?" method="get">
        <input type="hidden" name="add" value="1">
        Gebruikersnaam: <input type="text" name="gebruikersnaam" value="<?php echo "$gebruikersnaam"; ?>"> <br>
        Wachtwoord: <input type="password" name="wachtwoord" value="<?php echo "$wachtwoord"; ?>"> <br>
        <input type="submit" style="color:Green" name="submit" value="Registreer">
    </form>
*/
?>
    <?php
    if ($submit == "Registreer"){
        if ($gebruikersnaam != "" and $wachtwoord != "") {
            $sqladd = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord, rol) VALUES ('$gebruikersnaam', '$gehashedwachtwoord', 'gebruiker')";
            $result = $conn->query($sqladd);
        }
    }
?>


<div class="login">
    <?php
    if ($submit == "Registreer") {
        if ($gebruikersnaam != "" and $wachtwoord != "") {
            echo "success! <br>";
        }
    }
    ?>
    <h1>Registreer</h1>
        <form action="?" method="get">
            <input type="hidden" name="add" value="1">
            Gebruikersnaam: <input type="text" name="gebruikersnaam" value="<?php echo "$gebruikersnaam"; ?>" required> <br>
            Wachtwoord: <input type="password" name="wachtwoord" value="<?php echo "$wachtwoord"; ?>" required> <br>
            <input type="submit" name="submit" value="Registreer"><br>
            <b><a href="login.php" style="color: black">Ga terug naar de login pagina</a></b>

        </form>
</div>
</body>
</html>
