<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - Filter tasks</title>
</head>
<body>

<?php
require_once("../components/init.php");
loadInit("task", $conn);
?>

<main>
    <div id="mainTop">
        <h2>Manage tasks</h2>
    </div>
    <div id="mainBody">
        <form id="filterTasksForm" name="newTasksForm" action="../components/processfilter.php" method="POST">
            <fieldset>
                <label for="taskStatus">Task title</label>
                <input type="text" id="taskTitle" name="taskTitle" />
                <br />
                <label for="teamMember">Allocated team member</label>
                <?php
                require("../components/populateDropDown.php");
                ?>
                <br />
                <label for="startDate">Start date</label>
                <input type="date" id="startDate" name="startDate" onclick="setMin()" />
                <br />
                <label for="completionDate">Expected completion date</label>
                <input type="date" id="completionDate" name="completionDate" />
                <hr />
                <input type="submit" name="newTaskSubmit" value="Create" />
                <input type="submit" name="newTaskSubmit" value="Cancel" />
            </fieldset>
        </form>
    </div>
</main>

</body>
</html>