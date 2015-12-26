<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - Manage members</title>
</head>
<body>

<?php
require_once("../components/init.php");
if(isset($_GET['refineSubmit'])){
    loadInit("member", $conn);
}else{
    loadInit("member", $conn);
}

?>

<main>
    <div id="mainTop">
        <h2>Filter tasks</h2>
    </div>
    <div id="mainBody">
        <form>
            <fieldset>
                <legend>Filter by</legend>
                <input type="checkbox" name="taskStatusFilter" id="taskStatusFilter" value="1" />
                <label for="taskStatusFilter">Task status</label>

            </fieldset>
        </form>
    </div>
</main>

</body>
</html>