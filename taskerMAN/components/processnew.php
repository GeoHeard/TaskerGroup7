<?php

//if(isset($_GET['taskTitle']) || isset($_GET['memberFirstName'])){
if ($_GET['newSubmit'] == "Cancel") {
    // go back to where we've come from
}

// if we've come from the new task page
if (isset($_GET['taskTitle'])) {

    $sDate = implode("", explode("-", $_GET['startDate']));
    $ecdDate = implode("", explode("-", $_GET['completionDate']));

    //echo $_GET['taskTitle'] . $sDate . $ecdDate . $_GET['teamMember'];
    //header("Location: ../tasks/main.php");
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $sql = "INSERT INTO Task (title, startDate, ecd, memberEmail) VALUES ($taskTitle, $sDate, $ecdDate, " . $_GET['teamMember'] . ")";

        echo $sql;

        // Prepare statement
        //$stmt = $conn->prepare($sql);

        // execute the query
        //$stmt->execute();

        // echo a message to say the UPDATE succeeded
        //echo $stmt->rowCount() . " records UPDATED successfully";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
    //header("Location: ../index.php");
}

if (isset($_GET['newMemberForm'])) {

}
?>