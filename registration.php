<?php

$username = isset($_POST['username']) ? $_POST['username'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

$db = new PDO("mysql:host=localhost;dbname=final_project_sem1", "root");

$query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";

// act as placeholders to store the message
$error_msg = '';
$success_msg = '';

// make sure the user is 通过 post method not get method
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $username && $email && $password) {

    // have same email cannot register
    // go db check is it have the same email that the user register if have let me see the id
    $check_query = "SELECT id FROM users WHERE email = :email";
    // prevent sql kena hacker attack(SQL Injection attacks)
    $check_stmt = $db->prepare($check_query);
    $check_stmt->execute(array(':email' => $email));

    // if rowCount > 0 mean there is at least 1 same email in db mean cannot register and print the word below
    if ($check_stmt->rowCount() > 0) {

        // print the word below
        $error_msg = "Error: The same email address is already registered! Please try another email address!";
    } else {

        // successfully registered
        $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $db->prepare($query);

        // stmt means statement in shortform
        $stmt->execute(array(
            ':username' => $username,
            ':email'    => $email,
            ':password' => password_hash($password, PASSWORD_BCRYPT),
            ':role'=>2
        ));

        $success_msg = "User has been successfully registered!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Status - Pokémon TCG Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana,0000000000 sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .status-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            text-align: center;
            border-top: 6px solid #2a75d3; 
        }
        .status-card.card-error {
            border-top-color: #dc3545; 
        }
        .icon-box {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }
        .btn-pokemon {
            background-color: #2a75d3;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 24px;
            transition: all 0.2s;
        }
        .btn-pokemon:hover {
            background-color: #1a5bb8;
            color: white;
            transform: translateY(-2px);
        }
        .btn-failed {
            transition: all 0.2s;
        }
        .btn-failed:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="status-card <?= $error_msg ? 'card-error' : ''; ?>">
        
        <?php if ($success_msg): ?>
            <div class="icon-box text-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h2 class="fw-bold text-dark mb-3">Registration Success!</h2>
            <p class="text-secondary mb-4"><?= $success_msg; ?></p>
            
            <a href="login-form.php" class="btn btn-pokemon w-100 text-decoration-none">
                Go to Login <i class="bi bi-arrow-right-short"></i>
            </a>
        <?php endif; ?>

        <?php if ($error_msg): ?>
            <div class="icon-box text-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <h2 class="fw-bold text-dark mb-3">Registration Failed</h2>
            <p class="text-secondary mb-4"><?= $error_msg; ?></p>
            
            <a href="register-form.php" class="btn btn-outline-secondary w-100 text-decoration-none mb-2 btn-failed">
                <i class="bi bi-arrow-left-short"></i> Try Again
            </a>
            <div class="mt-3">
                <a href="login-form.php" class="text-decoration-none small text-muted">Already have an account? Login here</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>