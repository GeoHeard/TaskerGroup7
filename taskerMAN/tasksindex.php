<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN</title>
</head>
<body>
<header>
    <h1>taskerMAN</h1>
    <a href="taskindex.php"><h3>Manage tasks</h3></a>
    <a href="memberindex.php"><h3>Manage members</h3></a>
    <hr />
</header>
<nav>
    <div id="navTop">
        <form id="navTopNewButton" action="newtask.php" method="POST">
            <input type="submit" value="New task"/>
        </form>
        <form id="navTopFilterButton" action="filtertask.php" method="POST">
            <input type="submit" value="Filter tasks"/>
        </form>
    </div>
    <div id="navBody">
        <?php
        $toExtract="Tasks";
        include "components/dbextract.php";
        ?>
    </div>
</nav>
<main>
    <div id="mainTop">
        <h2>Manage tasks</h2>
    </div>
    <div id="mainBody">

    </div>
</main>
</body>
</html>