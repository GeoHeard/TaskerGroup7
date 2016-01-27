<?php

$lastNameError = "";
$firstNameError = "";

if(!empty($_POST['newMemberSubmit']))
{//if submitted, then validate

    if(isset($_POST['newMemberSubmit']) == "Cancel"){
        header("Location: ../index.php");
    }

    $memberLastName = trim($_POST['memberLastName']);
    $memberFirstName = trim($_POST['memberFirstName']);
    $error = false;

    if(empty($memberLastName)) {
        $memberLastNameError = "Last name is empty. Please enter your last name.";
        $error=true;
    }else if ($memberLastName != filter_var($memberLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)){
        $memberLastNameError = "Last name is not a valid name.";
        $error = true;
    }

    if(empty($_POST['memberFirstName'])) {
        $memberFirstNameError = "First name is empty. Please enter your first name.";
        $error=true;
    }else if ($memberFirstName != filter_var($memberFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)){
        $memberFirstNameError = "Last name is not a valid name.";
        $error = true;
    }

    if(empty($_POST['memberEmail'])) {
        $flavor_error ="Please enter an email";
        $error=true;
    } else if ($_POST[;member]){
        $flavor = $_POST['flavor'];
    }

    if(empty($_POST['Filling']) || count($_POST['Filling']) < 2)
    {
        $filling_error = "Please select at least 2 items for filling";
        $error=true;
    }

    $filling = $_POST['Filling'];

    if(empty($_POST['agree']))
    {
        $terms_error = "If you agree to the terms, please check the box below";
        $error=true;
    }
    else
    {
        $agree = $_POST['agree'];
    }

    if(false === $error)
    {
        //Validation Success!
        //Do form processing like email, database etc here

        header('Location: thank-you.html');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - New member</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
    <script src="../components/validators/validateNewMember.js"></script>
</head>
<body>

<?php
require_once("../components/init.php");
loadInit("member", $conn);
header("refresh:300;url=../timeout.php");
?>

<main>
    <div id="mainTop">
        <h2>New member</h2>
    </div>
    <div id="mainBody">
        <form id="newMemberForm" name="newMemberForm" action="?" method="POST">
            <fieldset>
                <label for="memberLastName">Last name</label>
                <input type="text" id="memberLastName" name="memberLastName" />
                <span class='error'><?php echo $name_error ?></span>
                <br />
                <label for="memberFirstName">First name</label>
                <input type="text" id="memberFirstName" name="memberFirstName" />
                <br />
                <label for="memberEmail">E-mail address</label>
                <input type="text" id="memberEmail" name="memberEmail" />
                <hr />
                <input type="submit" name="newMemberSubmit" value="Create" />
                <input type="submit" name="newMemberSubmit" value="Cancel" />
            </fieldset>
        </form>
    </div>
</main>

</body>
</html>