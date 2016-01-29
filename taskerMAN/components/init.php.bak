<?php
$servername = "db.dcs.aber.ac.uk";
$dbName = "csgp_7_15_16";
$username = "csgpadm_7";
$password = "Tbart8to";
$rootpath = "crb15/taskerMAN";

// TURNS OFF ERROR REPORTING!
error_reporting(0);

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{

}

function loadInit($contentToLoad, $conn, $filter = null){
    $tableToUse = "";
    $buttonPath = "";
    global $rootpath;

//    if($conn == null) {
//        if($contentToLoad == "dberror") {
//            echo "<ul>";
//            echo "<li class='logo'><a href='index.php'><h1>taskerMAN</h1></a></li>";
//            echo "<li><a href='tasks/main.php'><h1>Manage tasks</h1></a></li>";
//            echo "<li><a href='members/main.php'><h1>Manage members</h1></a><li>";
//            echo "</ul>";
//            return;
//        }else{
//            header("Location: http://users.aber.ac.uk/crb15/taskerMAN/dberror.php");
//        }
//    }

    if($contentToLoad == "dberror") {
        if ($conn == null) {
            echo "<ul>";
            echo "<li class='logo'><a href='index.php'><h1>taskerMAN</h1></a></li>";
            echo "<li><a href='tasks/main.php'><h1>Manage tasks</h1></a></li>";
            echo "<li><a href='members/main.php'><h1>Manage members</h1></a><li>";
            echo "</ul>";
            return;
        }else{
            header("Location: http://users.aber.ac.uk/crb15/taskerMAN/index.php");
        }
    }else if ($conn == null){
        header("Location: http://users.aber.ac.uk/crb15/taskerMAN/dberror.php");
    }

    echo "<header>";

    if ($contentToLoad == "default") {
        echo "<ul>";
        echo "<li class='logo'><a href='index.php'><h1>taskerMAN</h1></a></li>";
        echo "<li><a href='tasks/main.php'><h1>Manage tasks</h1></a></li>";
        echo "<li><a href='members/main.php'><h1>Manage members</h1></a><li>";
        echo "</ul>";
    } else if ($contentToLoad == "task") {
        $buttonPath = "newtask.php";
        echo "<ul>";
        echo "<li class='logo'><a href='../index.php'><h1>taskerMAN</h1></a></li>";
        echo "<li><a href='main.php'><h3>Manage tasks</h3></a></li>";
        echo "<li><a href='../members/main.php'><h3>Manage members</h3></a></li>";
        echo "</ul>";
        $tableToUse = "Task";
    } else if ($contentToLoad == "member") {
        $buttonPath = "newmember.php";
        echo "<ul>";
        echo "<li class='logo'><a href='../index.php'><h1>taskerMAN</h1></a></li>";
        echo "<li><a href='../tasks/main.php'><h3>Manage tasks</h3></a></li>";
        echo "<li><a href='main.php'><h3>Manage members</h3></a></li>";
        echo "</ul>";
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
                $query = "SELECT taskID, title, status FROM Task";
                if ($filter != null){
                    if($filter[0] != "any" || $filter[1] != "any"){
                        if($filter[0] != "any" && $filter[1] != "any"){
                            $query .= " WHERE status='" . $filter[0] . "'";
                            $query .= " AND memberEmail='" . $filter[1] . "'";
                        }else if ($filter[0] == "any"){
                            $query .= " WHERE memberEmail='" . $filter[1] . "'";
                        }else if ($filter[1] == "any"){
                            $query .= " WHERE status='" . $filter[0] . "'";
                        }
                    }
                }
                $query .= " ORDER BY ecd";
                echo "<form action='viewtask.php' method='POST'>";
                echo "<input type='hidden' name='taskSelect' value='1' />";
                foreach($conn->query($query) as $row){
                    echo "<input type='submit' class='submitButton' name='" . $row['taskID'] . "' value='" . $row['title'] . "' />";
                }
                echo "</form>";
            }else if ($contentToLoad == "member"){
                $query = "SELECT lastName, firstName, email FROM TeamMember";
                echo "<form action='viewmember.php' method='POST'>";
                echo "<input type='hidden' name='memberSelect' value='1' />";
                foreach($conn->query($query) as $row){
                    echo "<input type='submit' class='submitButton' name='" . $row['email'] . "' value='" . $row['lastName'] . ", " . $row['firstName'] . "' />";
                }
                echo "</form>";
            }

        echo "</div>";
        echo "</nav>";
    }
}

?>