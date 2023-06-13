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
</style>

<?php
include "sidemenu.php";

if (!isset($_COOKIE['logincookie'])) {
header("Location: login.php");
exit();
}
?>

<script>
    document.querySelector('.menu-toggle').addEventListener('click', function() {
        document.body.classList.toggle('menu-open');
        document.body.classList.toggle('displayprsside');
        document.body.classList.toggle('menu-toggleleft');
    });

</script>

