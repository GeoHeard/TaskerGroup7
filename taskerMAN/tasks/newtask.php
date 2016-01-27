<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - New task</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
    <script src="../components/validators/validateNewTask.js"></script>
    <script>
        function setMin(){
            document.getElementById("completionDate").disabled = false;
            document.getElementById("completionDate").value = document.getElementById("startDate").value;
            document.getElementById("completionDate").min = document.getElementById("startDate").value;
        }
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
        <form id="newTaskForm" name="newTaskForm" onsubmit='return validateNewTask()' action="../components/processnew.php" method="POST">
            <fieldset>
                <label for="taskTitle">Task title</label>
                <input type="text" id="taskTitle" name="taskTitle" />
                <br />
                <label for="teamMember">Allocated team member</label>
                <select name="taskTeamMember">
                    <?php require("../components/populateDropDown.php"); ?>
                </select>
                <br />
                <label for="startDate">Start date</label>
                <input type="date" id="startDate" name="startDate" min="<?php echo date("Y-m-d") ?>" onchange="setMin()" />
                <br />
                <label for="completionDate">Expected completion date</label>
                <input type="date" id="completionDate" name="completionDate" disabled/>
                <hr />
                <input type="submit" name="newTaskSubmit" value="Create" />
                <input type="submit" name="newTaskSubmit" value="Cancel" />
            </fieldset>
        </form>
    </div>
</main>

</body>
</html>