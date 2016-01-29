<?php
$taskTitle = trim($_POST['taskTitle']);
$taskStartDate = trim($_POST['taskStartDate']);
$taskCompletionDate = trim($_POST['taskCompletionDate']);
$taskElementsRaw = $_POST['taskElements'];
$error = false;

if(empty($taskTitle)) {
    $taskTitleError = "Please enter a task title.";
    $error = true;
}else if (preg_match('/[^a-zA-Z0-9 -]/', $taskTitle)){
    $taskTitleError = "Task title is not valid. No symbols are allowed.";
    $error = true;
}

$taskStartDateTest = date($taskStartDate);
$taskCompletionDateTest = date($taskCompletionDate);

if(empty($taskStartDate)) {
    $taskStartDateError = "Please enter a task start date.";
    $error = true;
}else if (!(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $taskStartDate))) {
    $taskStartDateError = "Start date is not valid. It must be in format YYYY-MM-DD.";
    $error = true;
}else if ($taskStartDateTest < date("Y-m-d")) {
    $taskStartDateError = "Please enter a start date that is today or in the future.";
    $error = true;
}

if(empty($taskCompletionDate)) {
    $taskCompletionDateError = "Please enter a task completion date.";
    $error = true;
}else if (!$taskCompletionDateTest) {
    $taskCompletionDateError = "Completion date is not valid. It must be in format YYYY-MM-DD.";
    $error = true;
}else if ($taskCompletionDateTest < $taskStartDateTest) {
    $taskCompletionDateError = "Please enter a completion date that is on the same day as the start date or later.";
    $error = true;
}

if (strlen($taskElementsRaw) == 0){
    $taskElementsError = "Please enter at least 1 task element.";
    $error = true;
}

//if(empty($taskCompletionDate)) {
//    $memberEmailError = "Please enter an email";
//    $error=true;
//} else if ($memberEmail != filter_var($memberEmail, FILTER_VALIDATE_EMAIL)){
//    $memberEmailError = "Email is not valid";
//    $error = true;
//} else if ($stmt->rowCount() != 0){
//    $memberEmailError = "An existing member with this email already exists";
//    $error = true;
//}
//if(!$error){
//    //Validation Success!
//    //Do form processing like email, database etc here
//
//    try {
//        $sql = "INSERT INTO TeamMember VALUES ('$memberLastName', '$memberFirstName', '$memberEmail');";
//        $sth = $conn->query($sql);
//    } catch(PDOException $e) {
//        echo $e->getMessage();
//    }
//}
?>