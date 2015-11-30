<?php
function loadInit($contentToLoad)
{
    $buttonPath = "";

    echo "<script>alert(" . getcwd() . ")</script>";

    echo "<header>";
    echo "<h1>taskerMAN</h1>";

    if ($contentToLoad == "default") {
        echo "<a href='tasks/main.php'><h3>Manage tasks</h3></a>";
        echo "<a href='members/main.php'><h3>Manage members</h3></a>";
    } else if ($contentToLoad == "task") {
        $buttonPath = "newtask.php";
        echo "<a href='main.php'><h3>Manage tasks</h3></a>";
        echo "<a href='../members/main.php'><h3>Manage members</h3></a>";
    } else if ($contentToLoad == "member") {
        $buttonPath = "newmember.php";
        echo "<a href='../tasks/main.php'><h3>Manage tasks</h3></a>";
        echo "<a href='main.php'><h3>Manage members</h3></a>";
    }

    echo "<hr />";
    echo "</header>";

    if ($contentToLoad != "default") {
        echo "<nav>";
        echo "<div id='navTop'>";
        echo "<form id='navTopNewButton' action='" . $buttonPath . "' method='POST'>";
        echo "<input type='submit' value='New" . $contentToLoad . "'/>";
        echo "</form>";
        if ($contentToLoad == "task") {
            echo "<form id='navTopFilterButton' action='../tasks/filtertask.php' method='POST'>";
            echo "<input type='submit' value='Filter tasks'/>";
            echo "</form>";
        }
        echo "</div>";
        echo "<div id='navBody'>";

//require("../components/dbextract.php");

        echo "</div>";
        echo "</nav>";
    } else {
        echo "<h2>Welcome</h2>";
        echo "<form id='loginForm' action='tasks/main.php' method='POST'>";
        echo "<fieldset>";
        echo "<legend>Please log in</legend>";
        echo "<label>Username</label>";
        echo "<input type='text' id='loginFormUsername' />";
        echo "<br />";
        echo "<label>Password</label>";
        echo "<input type='text' id='loginFormPassword' />";
        echo "<br />";
        echo "<input type='submit' id='loginFormSubmit' value='Login' />";
        echo "</fieldset>";
        echo "</form>";
    }


}

?>