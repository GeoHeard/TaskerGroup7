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
    $currTask["taskElements"] = implode(PHP_EOL, $sth->fetchAll(PDO::FETCH_COLUMN, 0)); // all comments are put into currTask
// else if we've just updated the user details, fill the fields with what was previously in them
} else if (isset($_POST["confirmTaskChanges"])) {
    $sth = $conn->prepare("SELECT taskID, title, memberEmail, startDate, ecd, status FROM Task WHERE taskID=" . $_POST['taskID'] . ";");
    $sth->execute();
    $currTask = $sth->fetch(PDO::FETCH_ASSOC);

    $sth = $conn->prepare("SELECT description FROM TaskElement WHERE taskID=" . $currTask['taskID']);
    $sth->execute();
    $currTask["taskElements"] = implode(PHP_EOL, $sth->fetchAll(PDO::FETCH_COLUMN, 0)); // all comments are put into currTask
    $currTask["teamMember"] = $_POST["teamMember"];
    $currTask["status"] = $_POST["abandonTask"] == "on" ? "abandoned" : "allocated";
    try {
        if ($_POST["teamMemberDefault"] != $_POST["teamMember"]) {
            $sql = "UPDATE Task SET memberEmail='" . $_POST["teamMember"] . "' WHERE memberEmail='" . $_POST["teamMemberDefault"] . "';";
            $sth = $conn->exec($sql);
        }

        $sql = "UPDATE Task SET status='" . $currTask["status"] . "' WHERE taskID='" . $currTask["taskID"] . "';";
        echo $sql;
        $sth = $conn->exec($sql);

    } catch (PDOException $e) {
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
        function checkDropdown() {

            var defaultTeamMemberSelected = document.getElementById('teamMember').options[document.getElementById('teamMember').selectedIndex].defaultSelected;
            var abandonTaskChanged = (document.getElementById('abandonTask').checked) && (!(document.getElementById('abandonTask').disabled));

            if (defaultTeamMemberSelected && abandonTaskChanged == false) {
                document.getElementById("toggledButton").disabled = true;
            } else {
                document.getElementById("toggledButton").disabled = false;
            }
        }
    </script>
</head>
<body>

<?php
require_once("../components/init.php");
loadInit("task", $conn);
?>

<main>
    <div id="mainTop">
        <h2><?php echo $currTask['title']; ?></h2>
    </div>
    <div id="mainBody">
        <form id="viewTaskForm" name="viewTaskForm" onsubmit="return checkDrodown()" action="?" method="POST">
            <fieldset>
                <input type="hidden" id="taskID" name="taskID" value="<?php echo $currTask['taskID']; ?>"/>
                <label for="taskTitle">Task title</label>
                <input type="hidden" id="taskTitleDefault" name="taskTitleDefault"
                       value='<?php echo $currTask["title"]; ?>'/>
                <input type='text' id='taskTitle' name='taskTitle' value='<?php echo $currTask["title"]; ?>' disabled/>
                <br/>
                <label for="teamMember">Allocated team member</label>
                <input type="hidden" id="teamMemberDefault" name="teamMemberDefault"
                       value='<?php echo $currTask["memberEmail"]; ?>'/>
                <select id='teamMember' name='teamMember' onchange='checkDropdown()'>
                    <?php
                    $query = "SELECT * FROM TeamMember";
                    $optionPrint = "";
                    foreach ($conn->query($query) as $row) {
                        $optionPrint = "<option value='" . $row['email'] . "'";
                        if (isset($_POST["taskSelect"])) {
                            if ($row['email'] == $currTask['memberEmail']) {
                                $optionPrint .= " selected";
                            }
                        } else if (isset($_POST["confirmTaskChanges"])) {
                            if ($row['email'] == $_POST['teamMember']) {
                                $optionPrint .= " selected";
                            }
                        }
                        $optionPrint .= ">" . $row['lastName'] . ", " . $row['firstName'] . " (" . $row['email'] . ")</option>";
                        echo $optionPrint;
                    }
                    ?>
                </select>
                <br/>
                <label for="startDate">Start date</label>
                <input type="hidden" id="startDateDefault" name="startDateDefault"
                       value='<?php echo $currTask["startDate"]; ?>'/>
                <input type='date' id='startDate' name='startDate' value='<?php echo $currTask['startDate']; ?>'
                       disabled/>
                <br/>
                <label for="expectedCompletionDate">Expected completion date</label>
                <input type="hidden" id="expectedCompletionDate" name="expectedCompletionDate"
                       value='<?php echo $currTask["ecd"]; ?>'/>
                <input type='date' id='expectedCompletionDate' name='expectedCompletionDate'
                       value='<?php echo $currTask['ecd']; ?>' disabled/>
                <br/>
                <label for="abandonTask">Abandon task?</label>
                <input type="hidden" id="abandonTaskDefault" name="abandonTaskDefault"
                       value="<?php if ($currTask["status"] == "abandoned") {
                           echo "checked disabled";
                       } ?>"/>
                <input type="checkbox" id="abandonTask" name="abandonTask"
                       onchange="checkDropdown();" <?php if ($currTask["status"] == "abandoned") {
                    echo "checked disabled";
                } ?> />
                <br/>
                <hr/>
                <input type="submit" id="toggledButton" name="confirmTaskChanges" value="Confirm changes" disabled/>
                <input type="submit" name="confirmTaskChanges" value="Cancel"/>
            </fieldset>
        </form>
    </div>
    <div id="mainRight">
        <input type="hidden" form="viewTaskElements" name="taskID" value="<?php echo $currTask['taskID']; ?>" />
        <input type="submit" form="viewTaskElements" name="viewTaskElements" value="View task elements and comments" />
        <label for="taskElements">Task elements - Please enter each element on a new line</label>
        <input type="hidden" id="taskElementsDefault" name="taskElementsDefault"
               value='<?php echo $currTask["taskElements"]; ?>'/>
        <textarea name="taskElements" id="taskElements" form="viewTaskForm" rows="6" cols="30"
                  onchange="checkDropdown()" disabled><?php echo $currTask["taskElements"] ?></textarea>
    </div>
    <form id="viewTaskElements" action="viewtaskelements.php" method="GET"></form>
</main>
</body>
</html>