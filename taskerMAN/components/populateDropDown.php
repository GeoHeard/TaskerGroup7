<?php
$query = "SELECT lastName, firstName, email FROM TeamMember";
foreach($conn->query($query) as $row){
    echo "<option value='" . $row['email'] . "'>" . $row['lastName'] . ", " . $row['firstName'] . " (" . $row['email'] . ")</option>";
}
?>