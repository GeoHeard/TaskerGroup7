<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
require_once("components/dbconnect.php");
require_once("components/init.php");
loadInit("default", $conn);
header("refresh:5;url=index.php");
?>

<main>
    <div id="mainTop">
        <h2>Action completed successfully.</h2>
    </div>
    <div id="mainBody">
        <p>You will be redirected in 5 seconds.</p>
    </div>
</main>

</body>
</html>