<style>
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
</style>
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