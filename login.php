<?php
session_start();

$username = isset($_POST['username']) ? $_POST ['username'] : null;
$password = isset($_POST['password']) ? $_POST ['password'] : null;

// This "if" statement sets up the username for all the commands below to become required to run and fix all errors 
if(isset($_POST['username'])){

$db = new PDO("mysql:host=localhost;dbname=final_project_sem1", "root");

// Searches the database to check if the user exists 
// Use username and password that exist in database to output data into the array
// Using a username and password that does not exist inside database the array will be empty
$query = "SELECT * FROM users WHERE username=:username";

$stmt = $db->prepare($query);
$stmt->execute(array(
    ':username'=>$username
));
$user = $stmt->fetchAll();

// $user[0] defines the password as array key
// Checks if the submitted password is correct or wrong and echo the corresponding h1 
$is_password_match = password_verify($password, $user[0]['password']);
// If the correct password for the user is submitted it will show correct password, otherwise wrong password will be displayed
echo $is_password_match ? "<h1>Correct password!</h1>" : "<h1>Wrong password!</h1>";

if($is_password_match){
    $_SESSION['user'] = $user[0];
    header("Location: collection.php");
}
// This will show when the user refreshes in login-form or login
} else {
    echo "<h1>User is already logged in.</h1>";
    print_r($_SESSION['user']);
    header("Location: collection.php");
    
    // In the logout file, add a link to login-form.php to close the loop.
    }
    echo "<h2><a href='./logout.php?logout=true'>Click me to logout</a></h2>";

?>