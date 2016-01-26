<?php
$servername = "db.dcs.aber.ac.uk";
$dbName = "csgp_7_15_16";
$username = "csgpadm_7";
$password = "Tbart8to";
$rootpath = "crb15/taskerMAN";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

function loadInit($contentToLoad, $conn){
    $tableToUse = "";
    $buttonPath = "";
    global $rootpath;

    echo "<header>";
    echo '<ul><li class="logo"><a href="../index.php"><h1>taskerMAN - Unicorn Edition</h1></a></li>';

    if ($contentToLoad == "default") {
        echo "
        <li><a href='tasks/main.php'><h1>Manage tasks</h1></a></li>";
        echo "
        <li><a href='members/main.php'><h1>Manage members</h1></a><li>
        </ul>";
    } else if ($contentToLoad == "task") {
        $buttonPath = "newtask.php";
        echo "
        <ul>
        <li><a href='main.php'><h3>Manage tasks</h3></a></li>";
        echo "
        <li><a href='../members/main.php'><h3>Manage members</h3></a></li>
        </ul>";
        $tableToUse = "Task";
    } else if ($contentToLoad == "member") {
        $buttonPath = "newmember.php";
        echo "
        <ul>
        <li><a href='../tasks/main.php'><h3>Manage tasks</h3></a></li>";
        echo "
        <li><a href='main.php'><h3>Manage members</h3></a></li>
        </ul>";
        $tableToUse = "TeamMember";
    }

    echo "</header>";

    if ($contentToLoad != "default") {
        echo "<nav>";
        echo "<div id='navTop'>";
        echo "<form id='navTopNewButton' action='" . $buttonPath . "' method='POST'>";
        echo "<input type='submit' value='New " . $contentToLoad . "'/>";
        echo "</form>";
        if ($contentToLoad == "task") {
            echo "<form id='navTopFilterButton' action='../tasks/filtertasks.php' method='POST'>";
            echo "<input type='submit' value='Filter tasks'/>";
            echo "</form>";
        }
        echo "</div>";
        echo "<div id='navBody'>";

        $query = "";

        if($contentToLoad == "task"){
            $query = "SELECT taskID, title FROM Task ORDER BY ecd";
            echo "<form action='../tasks/viewtask.php' method='GET'>";
            echo "<input type='hidden' name='taskSelect' value='1' />";
            foreach($conn->query($query) as $row){
                echo "<input type='submit' name='" . $row['taskID'] . "' value='" . $row['title'] . "' />";
            }
            echo "</form>";
        }else if ($contentToLoad == "member"){
            $query = "SELECT lastName, firstName, email FROM TeamMember";
            foreach($conn->query($query) as $row){
                echo "<input type='submit' name='" . $row['email'] . "' value='" . $row['lastName'] . ", " . $row['firstName'] . "' />";
                //echo "<p>" . $row['lastName'] . ", " . $row['firstName'] . "</p>";
            }
        }
        echo "</div>";
        echo "</nav>";
    }
}

?>