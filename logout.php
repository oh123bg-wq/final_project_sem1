<?php 
session_start();

if(isset($_GET['logout'])){
    if($_GET['logout'] == "true"){
    unset($_SESSION['user']);
}
}
session_destroy()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out</title>
</head>
<body>
    <h1>You have logged out.</h1>
    <!-- <h2><a href="./login-form.php">Click me to go back to login form</a></h2> -->
    <h2><a href="./index.php">Back to main page.</a></h2>
</body>
</html>