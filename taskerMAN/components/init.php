<?php
function loadInit($contentToLoad){
    $uniqueValue = "";

    if($contentToLoad == "default"){

    }else if ($contentToLoad == "tasks"){

    }else if ($contentToLoad == "members"){

    }else{
        echo "<script>alert('Error init.php')</script>";
    }

echo "<header>";
echo "<h1>taskerMAN</h1>";
echo "<a href='../tasks/main.php'><h3>Manage tasks</h3></a>";
echo "<a href='../members/main.php'><h3>Manage members</h3></a>";
echo "<hr />";
echo "</header>";

    if($contentToLoad != "default"){

    }else{
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

echo "<nav>";
echo "<div id='navTop'>";
echo "<form id='navTopNewButton' action='../members/newmember.php' method='POST'>";
echo "<input type='submit' value='New member'/>";
echo "</form>";
    if ($contentToLoad == "tasks"){
        echo "<form id='navTopFilterButton' action='filtertask.php' method='POST'>";
        echo "<input type='submit' value='Filter tasks'/>";
        echo "</form>";
    }
echo "</div>";
echo "<div id='navBody'>";

//require("../components/dbextract.php");

echo "</div>";
echo "</nav>";
echo "<main>";
echo "<div id='mainTop'>";
echo "<h2>Manage members</h2>";
echo "</div>";
echo "<div id='mainBody'>";
echo "</div>";
echo "</main>";
}
?>