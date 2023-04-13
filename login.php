<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1login";

session_start();

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = $_POST["gebruikersnaam"];
    $wachtwoord = $_POST["wachtwoord"];
    $gehashedwachtwoord = sha1($wachtwoord);

    $sql = "SELECT gebruikersnaam, wachtwoord
            FROM gebruikers
            WHERE gebruikersnaam='$gebruikersnaam' AND wachtwoord='$gehashedwachtwoord'";
    $result = $conn->query($sql);
/*
    if ($result->num_rows == 1) {
        $_SESSION["gebruikersnaam"] = $gebruikersnaam;
        header("Location: index.php");
        exit();
*/
if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: index.php');
    exit;

    } else {
        // If no matching user is found, display error message
        $error_message = "Invalid username or password.";
    }
}

?>


<div class="login">
    <h1>Login</h1>

    <?php if (isset($error_message)): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="gebruikersnaam"><b>Gebruikersnaam</b></label>
        <input type="text" name="gebruikersnaam" required>

        <br>

        <label for="wachtwoord"><b>Wachtwoord</b></label>
        <input type="password" name="wachtwoord" required>

        <br>

        <input type="submit" value="Login">
    </form>
    <p>Geen account? <a href="registreren.php">Registreer nu</a></p>
</div>
</body>
</html>
