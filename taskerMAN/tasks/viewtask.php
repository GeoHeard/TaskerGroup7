<?php
// if we are here not by the user selecting a task, then go back to main
if(!((isset($_GET['taskSelect'])) || isset($_GET['editMode']) )){
    header("Location: main.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - View task</title>
    <script>
        function checkDropdown(){

            alert(document.getElementsByTagName("option")[document.getElementById("teamMember").selectedIndex].defaultSelected);
            alert(document.getElementsByTagName("option")[document.getElementById("taskStatus").selectedIndex].defaultSelected);

            if(document.getElementsByTagName("option")[document.getElementById("teamMember").selectedIndex].defaultSelected && document.getElementsByTagName("option")[document.getElementById("taskStatus").selectedIndex].defaultSelected){
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
loadInit("task", false, null, $conn);
$sth = $conn->prepare("SELECT title, memberEmail, startDate, ecd, status FROM Task WHERE taskID=" . array_keys($_GET)[1]);
$sth->execute();
$currTask = $sth->fetch(PDO::FETCH_ASSOC);

$statusValues = ["allocated", "abandoned", "completed"];
?>

<main>
    <div id="mainTop">
        <h2><?php echo $currTask['title']; ?></h2>
    </div>
    <div id="mainBody">
        <form id="newTaskForm" name="newTaskForm" onsubmit="return checkDrodown()" action="../components/processnew.php" method="GET">
            <fieldset>
                <label for="taskTitle">Task title</label>
                <?php
                echo "<input type='text' id='taskTitle' name='taskTitle' value='" . $_GET[array_keys($_GET)[1]] . "' />";
                ?>
                <br />
                <label for="teamMember">Allocated team member</label>
                <?php
                echo "<select name='teamMember' id='teamMember' onchange='checkDropdown()'>";
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
                echo "</select>";
                ?>
                <br />
                <label for="startDate">Start date</label>
                <?php
                echo "<input type='date' id='startDate' name='startDate' value='" . $currTask['startDate'] . "'/>";
                ?>
                <br />
                <label for="expectedCompletionDate">Expected completion date</label>
                <?php
                echo "<input type='date' id='expectedCompletionDate' name='expectedCompletionDate' value='" . $currTask['ecd'] . "'/>";
                ?>
                <br />
                <label for="taskStatus">Status</label>
                <?php
                echo "<select name='taskStatus' id='taskStatus' onchange='checkDropdown()'>";
                $optionPrint = "";
                foreach($statusValues as $value){
                    $optionPrint = "<option value='" . $value . "'";
                    if($value == $currTask['status']){
                        $optionPrint .= " selected";
                    }
                    $optionPrint .= ">" . $value . "</option>";
                    echo $optionPrint;
                }
                echo "</select>";
                ?>
                <br />
                <hr />
                <input type="submit" id="toggledButton" name="confirmTaskChanges" value="Confirm changes" disabled />
                <input type="submit" name="confirmTaskChanges" value="Cancel" />
            </fieldset>
        </form>
    </div>
    <div id="mainRight">

    </div>
</main>

</body>
</html>