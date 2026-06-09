<?php
require('header.php');

$current_username = $_SESSION['user']['username'];

$query = "SELECT * FROM rarities";

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

    <style>
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

        .manager-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* 顶部标题栏 */
        .brand-icon {
            background-color: #9333ea;
            color: white;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.1rem;
        }

        /* 左侧与右侧通用的卡片容器样式 */
        .custom-card {
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.01);
        }

        /* 表单元素微调 */
        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.05em;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            background-color: #fafafa;
        }

        .form-control:focus {
            border-color: #a855f7;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.12);
            background-color: white;
        }

        /* 紫色按钮 */
        .btn-purple {
            background-color: #9333ea;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .btn-purple:hover {
            background-color: #7e22ce;
            color: white;
            box-shadow: 0 4px 12px rgba(147, 51, 234, 0.2);
        }

        /* 右侧列表表格样式 */
        .card-header-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            padding: 24px;
            border-bottom: 1px solid #f1f5f9;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.05em;
            padding: 16px 24px;
            border-bottom: 1px solid #f1f5f9;
            background-color: #ffffff;
        }

        .table td {
            padding: 20px 24px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .id-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: #94a3b8;
        }

        .rarity-name-text {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.05rem;
        }

        /* 删除垃圾桶按钮 */
        .btn-delete-link {
            background: none;
            border: none;
            color: #ef4444;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .btn-delete-link:hover {
            color: #b91c1c;
            background-color: #fef2f2;
            transform: scale(1.02);
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

            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small d-none d-sm-inline">👋 Welcome, <strong class="text-dark"><?php echo htmlspecialchars($current_username); ?></strong></span>
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

                    <form method="POST" action="manage-rarity.php">
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
                                            <button class="btn-delete-link"><i class="bi bi-trash3-fill"></i> Delete</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>