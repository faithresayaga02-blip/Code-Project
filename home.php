<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>hello world <?php echo  $_SESSION['first_name'];?> </h1>
    <a type="button" href="logout.php">Logout</a>
</body>
</html>