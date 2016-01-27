<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - Filter tasks</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
</head>
<body>

<?php
require_once("../components/init.php");
if (isset($_GET["filterTaskSubmit"])){
    if ($_GET["filterTaskSubmit"] == "Submit"){
        loadInit("task", $conn, [$_GET["taskStatusFilter"], $_GET["taskTeamMemberFilter"]]);
    }
}else{
    loadInit("task", $conn);
}

?>

<main>
    <div id="mainTop">
        <h2>Filter tasks</h2>
    </div>
    <div id="mainBody">
        <form id="filterTasksForm" name="filterTasksForm" action="" method="GET">
            <fieldset>
                <legend>Filter by</legend>
                <label for="taskStatusFilter">Task status</label>
                <label for="taskTeamMemberFilter">Allocated team member</label>
                <br />
                <select name="taskStatusFilter" id="taskStatusFilter" onchange="checkDropdown()">
                    <option value="allocated">allocated</option>
                    <option value="abandoned">abandoned</option>
                    <option value="completed">completed</option>
                </select>
                <select name="taskTeamMemberFilter" id="taskTeamMemberFilter">
                    <?php require_once("../components/populateDropDown.php"); ?>
                </select>
                <br />
                <hr />
                <input type="submit" name="filterTaskSubmit" value="Submit" />
                <input type="submit" name="filterTaskSubmit" value="Cancel" />
            </fieldset>
        </form>
    </div>
</main>

</body>
</html>