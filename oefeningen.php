<html>
    <style>
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
    <?php
    if (!isset($_COOKIE['logincookie'])) {
        header("Location: login.php");
        exit();
    }
    include "databaseconn.php";
    include "sidemenu.php";

    ?>
    <div class="ingelogdals">
        <p>Ingelogd als:<br> <?php echo $_COOKIE["logincookie"] ?></p>
    </div>
</html>