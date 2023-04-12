<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1login";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>

<?php
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



<h1>Login</h1>

<?php if (isset($error_message)): ?>
    <p><?php echo $error_message; ?></p>
<?php endif; ?>

<form method="post">
    <label for="gebruikersnaam">Gebruikersnaam:</label>
    <input type="text" name="gebruikersnaam" required>

    <br>

    <label for="wachtwoord">Wachtwoord:</label>
    <input type="password" name="wachtwoord" required>

    <br>

    <input type="submit" value="Login">
</form>

</body>
</html>
