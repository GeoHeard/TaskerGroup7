<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - New member</title>
    <script>
        function validateNewTask() {
            var titleField = document.getElementById("taskTitle");
            var startDateField = document.getElementById("startDate");
            var completionDateField = document.getElementById("completionDate");

            if(titleField.value.length != 0){
                if(titleField.value.length >= 5){
                    if(startDateField.value.length != 0){
                        if(completionDateField.value.length != 0){
                            return true;
                        }else{
                            alert("Please specify the task's estimated completiton date");
                        }
                    }else{
                        alert("Please specify the task's start date")
                    }
                }else{
                    alert("Please specify a task title of length 5 or greater")
                }
            }else{
                alert("Please specify a task title");
            }
            return false;
        }
    </script>
</head>
<body>

<?php
require("../components/init.php");
loadInit("task", $conn);
?>

<main>
    <div id="mainTop">
        <h2>New member</h2>
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