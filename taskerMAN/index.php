<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN</title>
</head>
<body>
<header>
    <h1>taskerMAN</h1>
    <a href="taskindex.php"><h3>Manage tasks</h3></a>
    <a href="memberindex.php"><h3>Manage members</h3></a>
    <hr />
</header>
<main>
    <h2>
        Welcome
    </h2>
    <form id="loginForm" action="tasksindex.php" method="POST">
        <fieldset>
            <legend>Please log in</legend>
            <label>Username</label>
            <input type="text" id="loginFormUsername" />
            <br />
            <label>Password</label>
            <input type="text" id="loginFormPassword" />
            <br />
            <input type="submit" id="loginFormSubmit" value="Login" />
        </fieldset>
    </form>
</main>
</body>
</html>