<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
</head>
<body>

<?php
require_once("components/init.php");
loadInit("dberror", $conn);
?>

<main>
    <div id="mainTop">
        <h2>Database connection problem</h2>
    </div>
    <div id="mainBody">
        <p>Oops! A problem was encountered when connecting to the database!</p>
    </div>
</main>

</body>
</html>