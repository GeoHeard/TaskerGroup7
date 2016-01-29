<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - View task elements</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
</head>
<body>
<?php
require_once("../components/dbconnect.php");
require_once("../components/init.php");
loadInit("task", $conn);
?>

<main>
    <div id="mainTop">
        <h2>Task elements</h2>
    </div>
    <div id="mainBody">
        <table>
            <tr>
                <th>Task element</th>
                <th>Task element comment</th>
            </tr>
            <tr>
                <?php
                $sth = $conn->prepare("SELECT * FROM TaskElement WHERE taskID=" . $_GET['taskID']);
                $sth->execute();
                $taskElements = $sth->fetchAll();
                $counter = 0;

                foreach($taskElements as $taskElement){

                    echo "<tr>";
                    echo "<td>";
                    echo $taskElement["description"];
                    echo "</td>";
                    $sth = $conn->prepare("SELECT content FROM ElementComment WHERE taskElementID='" . $taskElements[$counter]['elementID'] . "'");

                    $sth->execute();
                    $taskElementComment = $sth->fetchAll();

                    echo "<td>";
                    echo $taskElementComment[0]["content"];

                    $counter += 1;
                    echo "</td>";
                }
                ?>
            </tr>
        </table>
    </div>
</main>

</body>
</html>