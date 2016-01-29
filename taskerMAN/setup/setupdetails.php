<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - Setup</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
</head>
<body>
<?php
require_once("../components/dbconnect.php");
require_once("../components/init.php");
loadInit("task", $conn);
?>

<main>
    <div id="mainTop">
        <h2>Welcome</h2>
    </div>
    <div id="mainBody">
        <form id='loginForm' action='setupprocess.php' method='POST'>
            <fieldset>
                <legend>Enter your database details</legend>
                <label for="setupFormHostname">Hostname</label>
                <input type='text' id='setupFormHostname' name="setupFormHostname" />
                <br />
                <label for="setupFormUsername">Username</label>
                <input type='text' id='setupFormUsername' name="setupFormUsername"/>
                <br />
                <label for="setupFormPassword">Password</label>
                <input type='text' id='setupFormPassword' name="setupFormPassword"/>
                <br />
                <label for="setupFormDBName">New or existing DB name</label>
                <input type='text' id='setupFormDBName' name="setupFormDBName"/>
                <br />
                <input type='submit' id='setupFormSubmit' value='Setup' />
            </fieldset>
        </form>
    </div>
</main>

</body>
</html>