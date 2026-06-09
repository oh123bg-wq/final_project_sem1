<?php
session_start();

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == "true") {
        unset($_SESSION['user']);
    }
}

session_destroy();

header("Location: index.php");

exit();
?>
