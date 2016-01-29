<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
</head>
<body>
<?php
require_once("components/dbconnect.php");
require_once("components/init.php");
loadInit("default", $conn);
?>

<main>
    <div id="mainTop">
        <h2>Welcome</h2>
    </div>
    <div id="mainBody">
        <p>TaskerMAN is part of a distributed software system for task management.</p>
        <p>It is available for download on <a id="github" href="https://github.com/GeorgePeorge/TaskerGroup7">GitHub</a></p>
        <p>For the full experience, you should also download the TaskerCLI Java Application.</p>
        <img src="unicorn.png" />
    </div>
</main>

</body>
</html>