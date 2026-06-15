<?php
require('header.php');


$id = $_GET['id'];

// 处理表单提交的本地更新逻辑 (解冻原本的 UPDATE 逻辑)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['email'], $_POST['role'], $_POST['id'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $id = $_POST['id'];

    // 使用安全高效的 Prepared Statements 防护 SQL Injection 攻击
    $updateQuery = "UPDATE users SET username=:username, email=:email, role=:role WHERE id=:id";
    $stmt = $db->prepare($updateQuery);
    $stmt->execute([
        ":username" => $username,
        ":email"    => $email,
        ":role"     => $role,
        ":id"       => $id
    ]);

    header("Location: manage-user.php");
    exit();
}

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->execute([
    ':id' => $id
]);
$user = $stmt->fetch();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Simple CMS</title>
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
            <h1 class="h1">⚙️ Edit User</h1>
        </div>
        <div class="card mb-2 p-4">

            <form method="POST">
                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required />
                        </div>
                        <div class="col">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required />
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="" disabled>Select an option</option>
                        <option value="member" <?= $user['role'] == "member" ? "selected" : "" ?>>Member</option>
                        <option value="admin" <?= $user['role'] == "admin" ? "selected" : "" ?>>Admin</option>
                    </select>
                </div>

                <input type="hidden" name="id" value="<?= $id ?>">

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

        </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

</body>

</html>