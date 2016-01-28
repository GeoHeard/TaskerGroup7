<?php
require_once("../components/dbconnect.php");
$lastNameError = "";
$firstNameError = "";
$memberEmailError = "";

if(!empty($_GET['newMemberSubmit'])) {//if submitted, then validate

//    if(isset($_GET['newMemberSubmit']) == "Cancel"){
//        header("Location: ../index.php");
//    }

    require_once("../components/validators/validateMemberDetails.php");

    if(!$error){
        //Validation Success!
        //Do form processing like email, database etc here

        try {
            $sql = "INSERT INTO TeamMember VALUES ('$memberLastName', '$memberFirstName', '$memberEmail');";
            $sth = $conn->query($sql);
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
            document.getElementById("completionDate").disabled = false;
            document.getElementById("completionDate").value = document.getElementById("startDate").value;
            document.getElementById("completionDate").min = document.getElementById("startDate").value;
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
        <form id="newTaskForm" name="newTaskForm" action="?" method="POST">
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
        <textarea name="taskElements" form="newTaskForm" rows="6" cols="30">
        </textarea>
    </div>
</main>

</body>
</html>