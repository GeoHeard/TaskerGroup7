<?php
require_once("../components/dbconnect.php");
$taskTitleError = "";
$taskStartDateError = "";
$taskCompletionDateError = "";
$taskElementsError = "";

$taskElements = preg_split('/\r\n|[\r\n]/', $_GET['taskElements']);

if(!empty($_GET['newTaskSubmit'])) {//if submitted, then validate

    if($_GET['newTaskSubmit'] == "Cancel"){
        header("Location: ../index.php");
    }

    require_once("../components/validators/validateTaskDetails.php");

    if(!$error){
        //Validation Success!
        //Do form processing like email, database etc here

        try {
            $sql = "INSERT INTO Task (title, memberEmail, startDate, ecd) VALUES ('$taskTitle', '". $_GET['taskTeamMember'] . "', '$taskStartDate', '$taskCompletionDate');";
            $conn->exec($sql);
            $last_id = $conn->lastInsertId();
            foreach($taskElements as $taskElement){
                if ($taskElement != ""){
                    $sql = "INSERT INTO TaskElement (taskID, description) VALUES ('$last_id', '$taskElement');";
                    $conn->exec($sql);
                }
            }
            //header("Location: ../actionsuccess.php");

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - New task</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
    <script src="../components/validators/validateNewTask.js"></script>
    <script>
        function setMin(){
            document.getElementById("taskCompletionDate").value = document.getElementById("taskStartDate").value;
            document.getElementById("taskCompletionDate").min = document.getElementById("taskStartDate").value;
        }
    </script>
</head>
<body>

<?php
require_once("../components/dbconnect.php");
require_once("../components/init.php");
loadInit("task", $conn);
header("refresh:300;url=../timeout.php");
?>

<main>
    <div id="mainTop">
        <h2>New task</h2>
    </div>
    <div id="mainBody">
        <form id="newTaskForm" name="newTaskForm" action="?" method="GET">
            <fieldset>
                <label for="taskTitle">Task title</label>
                <input type="text" id="taskTitle" name="taskTitle" max="64" value="<?php echo htmlentities($taskTitle); ?>" />
                <span class='error'><?php echo $taskTitleError ?></span>
                <br />
                <label for="taskTeamMember">Allocated team member</label>
                <select name="taskTeamMember">
                    <?php require("../components/populateDropDown.php"); ?>
                </select>
                <br />
                <label for="taskStartDate">Start date</label>
                <input type="date" id="taskStartDate" name="taskStartDate" min="<?php echo date("Y-m-d") ?>" onchange="setMin()" max="64" value="<?php echo htmlentities($taskStartDate); ?>"  />
                <span class='error'><?php echo $taskStartDateError ?></span>
                <br />
                <label for="taskCompletionDate">Expected completion date</label>
                <input type="date" id="taskCompletionDate" name="taskCompletionDate" max="64" value="<?php echo htmlentities($taskCompletionDate); ?>" />
                <span class='error'><?php echo $taskCompletionDateError ?></span>
                <br />
                <hr />
                <input type="submit" name="newTaskSubmit" value="Create" />
                <input type="submit" name="newTaskSubmit" value="Cancel" />
            </fieldset>
        </form>
    </div>
    <div id="mainBodyRight">
        <label for="taskElements">Task elements - Please enter each element on a new line</label>
        <br />
        <textarea name="taskElements" form="newTaskForm" rows="6" cols="30"></textarea>
        <span class='error'><?php echo $taskElementsError ?></span>
    </div>
</main>

</body>
</html>