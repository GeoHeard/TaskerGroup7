<?php
$memberLastName = trim($_GET['memberLastName']);
$memberFirstName = trim($_GET['memberFirstName']);
$memberEmail = trim($_GET['memberEmail']);
$error = false;

if(empty($memberLastName)) {
    $memberLastNameError = "Please enter a last name.";
    $error = true;
}else if (preg_match('/[^a-zA-Z0-9]/', $memberLastName)){
    $memberLastNameError = "Last name is not valid.";
    $error = true;
}

if(empty($memberFirstName)) {
    $memberFirstNameError = "Please enter a first name.";
    $error = true;
}else if (preg_match('/[^a-zA-Z0-9]/', $memberFirstName)){
    $memberFirstNameError = "First name is not valid.";
    $error = true;
}

    try {
        $sql = "SELECT * FROM TeamMember WHERE email='" . $memberEmail . "';";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    } catch(PDOException $e) {
        echo $e->getMessage();
    }


if(empty($memberEmail)) {
    $memberEmailError = "Please enter an email";
    $error=true;
} else if ($memberEmail != filter_var($memberEmail, FILTER_VALIDATE_EMAIL)){
    $memberEmailError = "Email is not valid";
    $error = true;
}
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