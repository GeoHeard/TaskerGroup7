<?php
$memberLastName = trim($_POST['memberLastName']);
$memberFirstName = trim($_POST['memberFirstName']);
$memberEmail = trim($_POST['memberEmail']);
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
?>