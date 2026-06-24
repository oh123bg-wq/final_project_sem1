<?php
require("header.php");


$id = $_GET['id'];
$message = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['confirm_password'], $_POST['id'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $id = $_POST['id'];

    if ($password === $confirm_password) {
        $updateQuery = "UPDATE users SET password=:password WHERE id=:id";
        $stmt = $db->prepare($updateQuery);
        $stmt->execute([
            ":password" => password_hash($password, PASSWORD_BCRYPT),
            ":id"       => $id
        ]);

        header("Location: manage-user.php");
        exit;
    } else {
        $message = "❌ Password and Confirm Password do not match!";
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage User Change Psd</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Noto+Serif:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <style type="text/css">
        * {
            font-family: "DynaPuff", system-ui;
            font-optical-sizing: auto;
            font-weight: 100px;
            font-style: normal;
            font-variation-settings: "wdth" 100;
        }

        .dynapuff-a {
            font-family: "DynaPuff", system-ui;
            font-optical-sizing: auto;
            font-weight: 100px;
            font-style: normal;
            font-variation-settings: "wdth" 100;
        }
    </style>
</head>

<body>
    <div class="container mx-auto my-5" style="max-width: 700px;">
        <div class="mb-4 text-center">
            <a href="manage-user.php" class="btn btn-sm btn-outline-secondary px-3 rounded-pill">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <div class="text-center mb-3">
            <h1 class="h1"><i class="bi bi-key"></i> Change Password</h1>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="card mb-2 p-4">
            <form method="POST" id="changePwdForm">
                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required />
                        </div>

                        <input type="hidden" name="id" value="<?= $id ?>">

                        <div class="col">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="confirm_password"
                                name="confirm_password"
                                required />
                        </div>
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Change Password
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

</body>

</html>