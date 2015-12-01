<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - New task</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">

    </script>
</head>
<body>

<?php
require("../components/init.php");
loadInit("task");
?>

<main>
    <div id="mainTop">
        <h2>New task</h2>
    </div>
    <div id="mainBody">
        <form id="newTaskForm" name="newTaskForm" action="../components/processnew.php" method="POST">
            <fieldset>
                <label for="taskTitle">Task title</label>
                <input type="text" id="taskTitle" name="taskTitle" />
                <br />
                <label for="teamMember">Allocated team member</label>
                <select id="teamMember" name="teamMember">
                    <!-- populate drop down with DB query content -->
                </select>
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
    <div id="mainRight">

    </div>
</main>

</body>
</html>