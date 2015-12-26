<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - New member</title>
    <script src="../components/validators/validateNewMember.js"></script>
</head>
<body>

<?php
require_once("../components/init.php");
loadInit("member", false, null, $conn);
?>

<main>
    <div id="mainTop">
        <h2>New member</h2>
    </div>
    <div id="mainBody">
        <form id="newMemberForm" name="newMemberForm" onsubmit='return validateNewMember()' action="../components/processnew.php" method="GET">
            <fieldset>
                <label for="taskTitle">Task title</label>
                <input type="text" id="taskTitle" name="taskTitle" />
                <br />
                <label for="teamMember">Allocated team member</label>
                <?php
                require("../components/populateDropDown.php");
                ?>
                <br />
                <label for="startDate">Start date</label>
                <input type="date" id="startDate" name="startDate" />
                <br />
                <label for="completionDate">Expected completion date</label>
                <input type="date" id="completionDate" name="completionDate" />
                <hr />
                <input type="submit" name="newSubmit" value="Create" />
                <input type="submit" name="newSubmit" value="Cancel" />
            </fieldset>
        </form>
    </div>
</main>

</body>
</html>