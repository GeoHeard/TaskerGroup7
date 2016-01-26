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
loadInit("default", $conn);
?>

<main>
    <h2>Welcome</h2>
    <form id='loginForm' action='tasks/main.php' method='POST'>
        <fieldset>
            <legend>Please log in</legend>
            <label>Username</label>
            <input type='text' id='loginFormUsername' />
            <br />
            <label>Password</label>
            <input type='text' id='loginFormPassword' />
            <br />
            <input type='submit' id='loginFormSubmit' value='Login' />
            </fieldset>
    </form>
</main>

</body>
</html>