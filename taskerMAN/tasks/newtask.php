<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - New task</title>
    <script src="../components/validators/validateNewTask.js"></script>
    <script>
        document.getElementById("myRange").min;
    </script>
</head>
<body>

<?php
require_once("../components/init.php");
loadInit("task", $conn);
header("refresh:300;url=../timeout.php");
?>

<main>
    <div id="mainTop">
        <h2>New task</h2>
    </div>
    <div id="mainBody">
        <form id="newTaskForm" name="newTaskForm" onsubmit='return validateNewTask()' action="../components/processnew.php" method="GET">
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
    <div id="mainRight">

    </div>
</main>

</body>
</html>