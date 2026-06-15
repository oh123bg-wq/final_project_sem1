<?php
require('header.php');

// delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $deleteQuery = "DELETE FROM users WHERE id = :id";
    $stmt = $db->prepare($deleteQuery);
    $stmt->execute([
        ':id' => $_POST['id']
    ]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$query = "SELECT * FROM users";
$stmt = $db->prepare($query);
$stmt->execute([]);
$users = $stmt->fetchAll();

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

        .logo {
            width: 50px;
            height: 50px;
        }

    </style>
</head>

<body>
    <div class="navbar navbar-expand-lg navbar-white bg-white border-bottom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-4 text-dark" href="collection.php">
                <img src="../final_project_sem1/asset/masterballs-removebg-preview.png" alt="Logo" class="logo rounded-circle" style="object-fit: cover;">
                <span>Pokémon TCG Tracker</span>
            </a>

            <div class="d-flex align-items-center gap-2">
                <a href="collection.php" class="btn btn-sm btn-primary px-3 rounded-pill fw-semibold shadow-sm d-inline d-md-none"><i class="bi bi-box2-heart-fill"></i></a>
                <a href="collection.php" class="btn btn-sm btn-primary px-3 rounded-pill fw-semibold shadow-sm d-none d-md-inline"><i class="bi bi-box2-heart-fill"></i> Your collection</a>
                <a href="browse-card.php" class="btn btn-sm btn-primary px-3 rounded-pill fw-semibold shadow-sm d-inline d-md-none"><i class="bi bi-search-heart-fill"></i></a>
                <a href="browse-card.php" class="btn btn-sm btn-primary px-3 rounded-pill fw-semibold shadow-sm d-none d-md-inline"><i class="bi bi-search-heart-fill"></i> Browse cards</a>
                <?php if ($_SESSION['user']['role'] == "admin"): ?>
                    <span class="d-none d-md-inline">Admin panel</span>
                    <a href="manage-card.php" class="btn btn-sm btn-info px-3 rounded-pill fw-semibold shadow-sm text-white d-inline d-md-none"><i class="bi bi-card-list"></i></a>
                    <a href="manage-card.php" class="btn btn-sm btn-info px-3 rounded-pill fw-semibold shadow-sm text-white d-none d-md-inline"><i class="bi bi-card-list"></i> Manage cards</a>
                    <a href="manage-rarities.php" class="btn btn-sm btn-info px-3 rounded-pill fw-semibold shadow-sm text-white d-inline d-md-none"><i class="bi bi-gem"></i></a>
                    <a href="manage-rarities.php" class="btn btn-sm btn-info px-3 rounded-pill fw-semibold shadow-sm text-white d-none d-md-inline"><i class="bi bi-gem"></i> Manage tiers</a>
                    <a href="manage-user.php" class="btn btn-sm btn-info px-3 rounded-pill fw-semibold shadow-sm text-white d-inline d-md-none"><i class="bi bi-people"></i></a>
                    <a href="manage-user.php" class="btn btn-sm btn-info px-3 rounded-pill fw-semibold shadow-sm text-white d-none d-md-inline"><i class="bi bi-people"></i> Manage users</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-sm btn-outline-danger rounded-circle" title="Log Out">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto my-5" style="max-width: 700px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-1"><i class="bi bi-people-fill text-primary me-2"></i>Manage Users</h1>
                <p class="text-muted small mb-0">Total active users registered in system: <span class="badge bg-secondary text-white rounded-pill"><?= count($users); ?></span></p>
            </div>
        </div>
        <div class="card mb-2 p-4">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <?php
                        $role_badge = "";
                        // 运用 switch 分支结构来优雅地映射角色对应的 Bootstrap CSS 颜色标签
                        switch ($user['role']) {
                            case 'member':
                                $role_badge = "bg-success";
                                break;
                            case 'admin':
                                $role_badge = "bg-primary";
                                break;
                        }
                        ?>
                        <tr>
                            <th scope="row"><?= $user['username'] ?></th>
                            <td><?= $user['email'] ?></td>
                            <td><span class="badge <?= $role_badge ?>"><?= ucwords($user['role']) ?></span></td>
                            <td class="text-end">
                                <div class="buttons">
                                    <a
                                        href="manage-user-edit.php?id=<?= $user['id'] ?>"
                                        class="btn btn-success btn-sm me-2"><i class="bi bi-pencil"></i></a>
                                    <a
                                        href="manage-user-changepwd.php?id=<?= $user['id'] ?>"
                                        class="btn btn-warning btn-sm me-2"><i class="bi bi-key"></i></a>

                                    <form method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to permanently delete this user?');">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button class="btn btn-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>