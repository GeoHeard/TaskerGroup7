<?php
// if we are here not by the user selecting a task, then go back to main
if(!((isset($_POST['memberSelect'])))){
    header("Location: main.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - View task</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
    <script>
        function checkValues(){

            var lastNameChanged = document.getElementById('memberLastNameDefault').value != document.getElementById('memberLastName').value;
            var firstNameChanged = document.getElementById('memberFirstNameDefault').value != document.getElementById('memberFirstName').value;
            var emailChanged = document.getElementById('memberEmailDefault').value != document.getElementById('memberEmail').value;

            alert(lastNameChanged);
            alert(firstNameChanged);
            alert(emailChanged);

            if(lastNameChanged || firstNameChanged || emailChanged){
                document.getElementById("toggledButton").disabled = false;
            }else{
                document.getElementById("toggledButton").disabled = true;
            }
        }
    </script>
</head>
<body>

<?php
require_once("../components/init.php");
loadInit("member", $conn);
$sth = $conn->prepare("SELECT firstName, lastName, email FROM TeamMember WHERE email='" . str_replace('_', '.', array_keys($_POST)[1]) . "'");
$sth->execute();
$currMember = $sth->fetch(PDO::FETCH_ASSOC);
?>

<main>
    <div id="mainTop">
        <h2><?php echo $currMember['lastName'] . ", " . $currMember['firstName']; ?></h2>
    </div>
    <div id="mainBody">
        <form id="viewMemberForm" name="viewMemberForm" action="../components/processnew.php" method="POST">
            <fieldset>
                <label for="memberLastName">Last name</label>
                <input type="hidden" id="memberLastNameDefault" name="memberLastNameDefault" value='<?php echo $currMember["lastName"] ?>' />
                <input type="text" id="memberLastName" name="memberLastName" value="<?php echo $currMember['lastName'] ?>" onchange="checkValues()" />
                <br />
                <label for="memberFirstName">First name</label>
                <input type="hidden" id="memberFirstNameDefault" name="memberFirstNameDefault" value="<?php echo $currMember['firstName'] ?>" />
                <input type="text" id="memberFirstName" name="memberFirstName" value="<?php echo $currMember['firstName'] ?>" onchange="checkValues()" />
                <br />
                <label for="memberEmail">Email</label>
                <input type="hidden" id="memberEmailDefault" name="memberEmailDefault" value="<?php echo $currMember['email'] ?>" />
                <input type="text" id="memberEmail" name="memberEmail" value="<?php echo $currMember['email'] ?>" onchange="checkValues()" />
                <br />
                <hr />
                <input type="submit" id="toggledButton" name="confirmTaskChanges" value="Confirm changes" disabled />
                <input type="submit" name="confirmTaskChanges" value="Cancel" />
            </fieldset>
        </form>
    </div>
    <div id="mainRight">

    </div>
</main>

</body>
</html>