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
            <input type='text' id='loginFormUsername' onchange="verifyEmail(this.value)" placeholder='email@website.com'/>
            <br />
            <label>Password</label>
            <input type='text' id='loginFormPassword' />
            <br />
            <input type='submit' id='loginFormSubmit' value='Login' />
            </fieldset>
    </form>
    <script>
            //each function verifies if its field validates. Button cannot be pushed until all valid.
            function verifyEmail(email)
        {   email.toLowerCase();
            email.trim();
            if(email.match([a-z0-9]*[]))
                }
</main>

</body>
</html>
