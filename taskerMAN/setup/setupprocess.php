<?php
$servername = $_POST["setupFormHostname"];
$username = $_POST["setupFormUsername"];
$password = $_POST["setupFormPassword"];
$dbName = $_POST["setupFormDBName"];

//$servername = "db.dcs.aber.ac.uk";
//$dbName = "csgp_7_15_16";
//$username = "csgpadm_7";
//$password = "Tbart8to";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE TeamMember(firstName VARCHAR(64) NOT NULL, lastName VARCHAR(64) NOT NULL, email VARCHAR(64) PRIMARY KEY);";
    $conn->exec($sql);
    $sql = "CREATE TABLE Task(taskID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, title VARCHAR(64) NOT NULL,startDate DATE NOT NULL, ecd DATE NOT NULL,status ENUM('allocated', 'abandoned', 'completed') NOT NULL DEFAULT 'allocated', memberEmail VARCHAR(64) NOT NULL REFERENCES TeamMember(email));";
    $conn->exec($sql);
    $sql = "ALTER TABLE Task ADD FOREIGN KEY (memberEmail) REFERENCES TeamMember(email);";
    $conn->exec($sql);
    $sql = "CREATE TABLE TaskElement(elementID INT AUTO_INCREMENT PRIMARY KEY, taskID INT REFERENCES Task(taskID), description TEXT NOT NULL);";
    $conn->exec($sql);
    $sql = "ALTER TABLE TaskElement ADD FOREIGN KEY (taskID) REFERENCES Task(taskID);";
    $conn->exec($sql);
    $sql = "CREATE TABLE ElementComment(commentID INT AUTO_INCREMENT PRIMARY KEY, taskElementID INT REFERENCES TaskElement(elementID), content TEXT);";
    $conn->exec($sql);
    $sql = "ALTER TABLE ElementComment ADD FOREIGN KEY (taskElementID) REFERENCES TaskElement(elementID);";
    $conn->exec($sql);
    echo "Database created successfully. You will be redirected in 5 seconds.<br>";
    header("refresh:5;url=../index.php");
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>