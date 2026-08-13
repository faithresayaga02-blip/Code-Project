<?php
// session start
session_start();

// connection to the database
$host         = 'localhost';
$username     = 'root';
$password     = '';
$databaseName = 'bsis3a';

// connection using mysqli
$connection = new mysqli($host, $username, $password, $databaseName);

$username = $_POST['username']; 
$password = $_POST['password'];

// query from database
$query  = "SELECT * FROM students";
$result = mysqli_query($connection, $query);


// populate coming from database
while ($row = mysqli_fetch_assoc($result)) {

    if ($username == $row['username'] && $password == $row['password']) {
        $_SESSION['first_name']=$row['FirstName'];
        header('location: home.php');
    } else {
        echo "Denied";
        echo "<a href='index.php'>Go back to login page</a>";
    }

}