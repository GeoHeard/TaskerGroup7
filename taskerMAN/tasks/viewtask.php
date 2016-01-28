<?php
// if we are here not by the user selecting a task, then go back to main
//if(!((isset($_POST['taskSelect'])))){
//    header("Location: main.php");
//}

require_once("../components/dbconnect.php");

// if we've just clicked on a member to view them, then populate fields with DB query
if (isset($_POST["taskSelect"])) {
    $sth = $conn->prepare("SELECT taskID, title, memberEmail, startDate, ecd, status FROM Task WHERE taskID=" . array_keys($_POST)[1] . ";");
    $sth->execute();
    $currTask = $sth->fetch(PDO::FETCH_ASSOC);

    $sth = $conn->prepare("SELECT description FROM TaskElement WHERE taskID=" . $currTask['taskID']);
    $sth->execute();
    $currTask["taskElements"] = $sth->fetchAll(PDO::FETCH_COLUMN, 0); // all comments are put into currTask
// else if we've just updated the user details, fill the fields with what was previously in them
}else if (isset($_POST["confirmTaskChanges"])) {
    //require_once("../components/validators/validateTaskDetails.php");
    $currTask = ["title"=>$_POST["taskTitleDefault"], "startDate"=>$_POST["startDateDefault"], "ecd"=>$_POST["expectedCompletionDateDefault"], "status"=>$_POST["taskStatusDefault"]];
    $currTask["taskElements"] = explode("%0D%0A", $_POST["taskElements"]);
    print_r($currTask);
        try {
            if($_POST["teamMemberDefault"] != $_POST["teamMember"]) {
                $sql = "UPDATE Task SET memberEmail='" . $_POST["teamMember"] . "' WHERE memberEmail='" . $_POST["teamMemberDefault"] . "';";
                $sth = $conn->exec($sql);
            }

            if($_POST["taskStatusDefault"] != $_POST["taskStatusDefault"]) {
                $sql = "UPDATE Task SET status='" . $_POST["taskStatus"] . "' WHERE status='" . $_POST["taskStatusDefault"] . "';";
                $sth = $conn->exec($sql);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - View task</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
    <script>
        function checkDropdown(){

            var defaultTeamMemberSelected = document.getElementById('teamMember').options[document.getElementById('teamMember').selectedIndex].defaultSelected;
            var defaultStatusSelected = document.getElementById('taskStatus').options[document.getElementById('taskStatus').selectedIndex].defaultSelected;

            if(defaultTeamMemberSelected && defaultStatusSelected){
                document.getElementById("toggledButton").disabled = true;
            }else{
                document.getElementById("toggledButton").disabled = false;
            }
        }
    </script>
</head>
<body>

<?php
require_once("../components/init.php");
loadInit("task", $conn);

$statusValues = ["allocated", "abandoned", "completed"];
?>

<main>
    <div id="mainTop">
        <h2><?php echo $currTask['title']; ?></h2>
    </div>
    <div id="mainBody">
        <form id="viewTaskForm" name="viewTaskForm" onsubmit="return checkDrodown()" action="?" method="POST">
            <fieldset>
                <label for="taskTitle">Task title</label>
                <input type="hidden" id="taskTitleDefault" name="taskTitleDefault" value='<?php echo $currTask["title"]; ?>' />
                <input type='text' id='taskTitle' name='taskTitle' value='<?php echo $currTask["title"]; ?>' disabled/>
                <br />
                <label for="teamMember">Allocated team member</label>
                <select id='teamMember' name='teamMember' onchange='checkDropdown()'>
                    <?php
                    $query = "SELECT * FROM TeamMember";
                    $optionPrint = "";
                    foreach($conn->query($query) as $row){
                        $optionPrint = "<option value='" . $row['email'] . "'";
                        if($row['email'] == $currTask['memberEmail']){
                            $optionPrint .= " selected";
                        }
                        $optionPrint .= ">" . $row['lastName'] . ", " . $row['firstName'] . " (" . $row['email'] . ")</option>";
                        echo $optionPrint;
                    }
                    ?>
                </select>
                <br />
                <label for="startDate">Start date</label>
                <input type="hidden" id="startDateDefault" name="startDateDefault" value='<?php echo $currTask["startDate"]; ?>' />
                <input type='date' id='startDate' name='startDate' value='<?php echo $currTask['startDate']; ?>' disabled/>
                <br />
                <label for="expectedCompletionDate">Expected completion date</label>
                <input type="hidden" id="expectedCompletionDateDefault" name="expectedCompletionDateDefault" value='<?php echo $currTask["ecd"]; ?>' />
                <input type='date' id='expectedCompletionDate' name='expectedCompletionDate' value='<?php echo $currTask['ecd']; ?>' disabled/>
                <br />
                <label for="taskStatus">Status</label>
                <input type="hidden" id="taskStatusDefault" name="taskStatusDefault" value='<?php echo $currTask["status"]; ?>' />
                <select name='taskStatus' id='taskStatus' onchange='checkDropdown()' value='<?php echo $currTask["status"]; ?>'>
                    <?php
                    $optionPrint = "";
                    foreach($statusValues as $value){
                        $optionPrint = "<option value='" . $value . "'";
                        if($value == $currTask['status']){
                            $optionPrint .= " selected";
                        }
                        $optionPrint .= ">" . $value . "</option>";
                        echo $optionPrint;
                    }
                    ?>
                </select>
                <br />
                <hr />
                <input type="submit" id="toggledButton" name="confirmTaskChanges" value="Confirm changes" disabled />
                <input type="submit" name="confirmTaskChanges" value="Cancel" />
            </fieldset>
        </form>
    </div>
    <div id="mainRight">
        <input type="hidden" id="taskElements" name="taskElements" value='<?php echo $currTask["taskElements"]; ?>' />
        <textarea name='taskElements' form="viewTaskForm" rows="6" cols="30">
            <?php
            foreach($currTask["taskElements"] as $taskComment){
                echo $taskComment . "\n";
            }
            ?>
        </textarea>
    </div>
</main>

</body>
</html>