<?php
require('header.php');

$current_username = $_SESSION['user']['username'];

// 处理表单提交（POST 请求）的后端逻辑
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rarity_name'])) {
    $rarity_name = trim($_POST['rarity_name']);

    // make sure the rarity you want add is not blank 确保输入的名称不是空的
    if (!empty($rarity_name)) {
        // Use PDO Prepared Statement insert data，prevent SQL Injection
        $insertQuery = "INSERT INTO final_project_sem1.rarities (rarity_name) VALUES (:rarity_name)";
        $insertStmt = $db->prepare($insertQuery);
        $insertStmt->execute([':rarity_name' => $rarity_name]);

        header("Location: manage-rarities.php");
        exit();
    }
}

$query = "SELECT * FROM rarities";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $deleteQuery = "DELETE FROM rarities WHERE id=:id";

    $stmt = $db->prepare($deleteQuery);
    $stmt->execute([":id" => $id]);

    header("Location: manage-rarities.php");
    exit();
}

$stmt = $db->prepare($query);
$stmt->execute([]);
$rarities = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rarity Tiers Customizer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Noto+Serif:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="manage-rarities.css" />
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

    <div class="manager-container">

        <div class="mb-5">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="brand-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h1 class="h3 fw-bold m-0" style="letter-spacing: -0.02em;">Rarity Tiers Customizer</h1>
            </div>
            <p class="text-muted m-0 small">Manage database classifications for different Pokémon card grades.</p>
        </div>

        <div class="row g-4">

            <div class="col-lg-4">
                <div class="card custom-card p-4">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <span class="text-white bg-purple rounded px-1" style="background-color: #9333ea; font-size: 0.8rem; padding: 2px 6px !important; border-radius: 4px;">
                            <i class="bi bi-plus-lg"></i>
                        </span>
                        <h2 class="h6 fw-bold m-0" style="color: #0f172a; font-size: 1rem;">Add New Rarity</h2>
                    </div>


                    <form method="POST" action="manage-rarities.php">
                        <div class="mb-4">
                            <label for="rarity_name" class="form-label mb-2">Rarity Name</label>
                            <input type="text" class="form-control" id="rarity_name" name="rarity_name" placeholder="e.g. Ultra Rare, Secret Rare" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-purple">
                                Save Rarity Tier
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header-title">
                        Current Rarity Tiers
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">ID</th>
                                    <th style="width: 65%;">Rarity Name</th>
                                    <th style="width: 20%;" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rarities as $rarity): ?>
                                    <tr>
                                        <td><span class="id-text"><?= $rarity['id'] ?></span></td>
                                        <td><span class="rarity-name-text"><?= $rarity['rarity_name'] ?></span></td>
                                        <td class="text-end">
                                            <form method="post">
                                                <button class="btn-delete-link" type="submit"><i class="bi bi-trash3-fill"></i> Delete</button>
                                                <input type="hidden" name="id" value="<?= $rarity['id'] ?>">
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Footer Section -->
    <footer>
        <div class="container-fluid bg-white pt-4 pb-2">
            <div class="container text-center">
                <div class="d-flex justify-content-center pb-2">
                    <i class="bi bi-facebook px-2"></i>
                    <i class="bi bi-twitter px-2"></i>
                    <i class="bi bi-instagram px-2"></i>
                    <i class="bi bi-linkedin px-2"></i>
                </div>
                <p class="text-center">All rights reserved &copy; Pokémon TCG Tracker 2026.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>