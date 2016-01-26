<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - New member</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
    <script src="../components/validators/validateNewMember.js"></script>
</head>
<body>

<?php
require_once("../components/init.php");
loadInit("member", $conn);
header("refresh:300;url=../timeout.php");
?>

<main>
    <div id="mainTop">
        <h2>New member</h2>
    </div>
    <div id="mainBody">
        <form id="newMemberForm" name="newMemberForm" onsubmit='return validateNewMember()' action="../components/processnew.php" method="GET">
            <fieldset>
                <label for="memberLastName">Last name</label>
                <input type="text" id="memberLastName" name="memberLastName" />
                <br />
                <label for="memberFirstName">First name</label>
                <input type="text" id="memberFirstName" name="memberFirstName" />
                <br />
                <label for="memberEmail">E-mail address</label>
                <input type="text" id="memberEmail" name="memberEmail" />
                <hr />
                <input type="submit" name="newMemberSubmit" value="Create" />
                <input type="submit" name="newMemberSubmit" value="Cancel" />
            </fieldset>
        </form>
    </div>
</main>

</body>
</html>