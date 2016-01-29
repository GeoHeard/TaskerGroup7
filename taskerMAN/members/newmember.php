<?php
require_once("../components/dbconnect.php");
$lastNameError = "";
$firstNameError = "";
$memberEmailError = "";

if(!empty($_POST['newMemberSubmit'])) {//if submitted, then validate

    if ($_POST['newMemberSubmit'] == "Cancel"){
        header("Location: ../index.php");
    }

    require_once("../components/validators/validateMemberDetails.php");

    if ($stmt->rowCount() != 0){
        $memberEmailError = "An existing member with this email already exists";
        $error = true;
    }

    if(!$error){
        //Validation Success!
        //Do form processing like email, database etc here

        try {
            $sql = "INSERT INTO TeamMember VALUES ('$memberFirstName', '$memberLastName', '$memberEmail');";
            $sth = $conn->query($sql);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
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
                <input type="text" id="memberLastName" name="memberLastName" max="64" value="<?php echo htmlentities($memberLastName); ?>" />
                <span class='error'><?php echo $memberLastNameError ?></span>
                <br />
                <label for="memberFirstName">First name</label>
                <input type="text" id="memberFirstName" name="memberFirstName" max="64" value="<?php echo htmlentities($memberFirstName); ?>" />
                <span class='error'><?php echo $memberFirstNameError ?></span>
                <br />
                <label for="memberEmail">E-mail address</label>
                <input type="text" id="memberEmail" name="memberEmail" max="64" value="<?php echo htmlentities($memberEmail); ?>"/>
                <span class='error'><?php echo $memberEmailError ?></span>
                <hr />
                <input type="submit" name="newMemberSubmit" value="Create" />
                <input type="submit" name="newMemberSubmit" value="Cancel" />
            </fieldset>
        </form>
    </div>
</main>
</body>
</html>