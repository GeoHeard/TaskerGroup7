<?php
echo "<select name='teamMember'>";
$query = "SELECT lastName, firstName, email FROM TeamMember";
foreach($conn->query($query) as $row){
    echo "<option value='" . $row['email'] . "'>" . $row['lastName'] . ", " . $row['firstName'] . " (" . $row['email'] . ")</option>";
}
echo "</select>";
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
?>