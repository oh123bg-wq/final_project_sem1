<?php
require('header.php');

$current_username = $_SESSION['user']['username'];

// SQL LEFT JOIN 联表查询语句，通过两张表共有的 ID，把 cards 表的所有卡牌数据和 rarities 表对应的稀有度名称（如 SR/UR）安全地拼接在一起。
$query = "SELECT cards.*, rarities.rarity_name FROM final_project_sem1.cards LEFT JOIN rarities ON cards.rarity_id = rarities.id ORDER BY id DESC";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $deleteQuery = "DELETE FROM cards WHERE id=:id";

    $stmt = $db->prepare($deleteQuery);
    $stmt->execute([":id" => $id]);
}

$stmt = $db->prepare($query);
$stmt->execute([]);
$cards = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Card Catalog Manager</title>
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

        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* 顶部标题栏样式 */
        .brand-icon {
            background-color: #a855f7;
            color: white;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.25rem;
        }

        .btn-add-card {
            background-color: #9333ea;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .btn-add-card:hover {
            background-color: #7e22ce;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(147, 51, 234, 0.25);
        }

        /* 主数据卡片与表格  */
        .catalog-card {
            background-color: white;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
            overflow: hidden;
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
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            background-color: #ffffff;
        }

        .table td {
            padding: 18px 24px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 0.95rem;
        }

        /* 卡牌图片微缩图 */
        .card-thumb {
            width: 44px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            background-color: #f1f5f9;
        }

        .card-name-text {
            font-weight: 700;
            color: #0f172a;
        }

        /* 属性小标签 (Type Badges) */
        .badge-type {
            background-color: #f1f5f9;
            color: #64748b;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
        }

        /* 稀有度文字颜色 */
        .rarity-text {
            color: #64748b;
            font-weight: 500;
        }

        /* 市场价格加粗 */
        .market-value-text {
            font-weight: 800;
            color: #0f172a;
            font-size: 1.05rem;
        }

        /* 操作按钮样式 */
        .action-btn {
            background: none;
            border: none;
            padding: 6px;
            font-size: 1.15rem;
            transition: transform 0.2s;
            margin: 0 4px;
        }

        .action-btn:hover {
            transform: scale(1.15);
        }

        .btn-edit {
            color: #f59e0b;
        }

        .btn-delete {
            color: #ef4444;
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


    <div class="dashboard-container">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="brand-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h1 class="h3 fw-bold m-0" style="letter-spacing: -0.02em;">Master Card Catalog Manager</h1>
                </div>
                <p class="text-muted m-0 small">Admin Dashboard to add, update, and upload card images to system.</p>
            </div>
            <div>
                <a href="add-card.php" class="btn btn-add-card shadow-sm">
                    <i class="bi bi-plus-circle-fill me-2"></i>Add New Card
                </a>
            </div>
        </div>

        <div class="card catalog-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Image</th>
                            <th style="width: 30%;">Card Name</th>
                            <th style="width: 15%;">Type</th>
                            <th style="width: 20%;">Rarity</th>
                            <th style="width: 15%;">Market Value</th>
                            <th style="width: 10%;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cards as $card): ?>
                            <tr>
                                <td>
                                    <img src="<?= $card['card_image'] ?>" class="card-thumb" alt="<?= $card['card_name'] ?>" />
                                </td>
                                <td><span class="card-name-text"><?= $card['card_name'] ?></span></td>
                                <td><span class="badge-type"><?= $card['pokemon_type'] ?></span></td>
                                <td><span class="rarity-text"><?= $card['rarity_name'] ?></span></td>
                                <td><span class="market-value-text">RM <?= $card['market_value'] ?></span></td>
                                <td class="text-center">
                                    <a
                                        href="edit-card.php?id=<?= $card['id'] ?>"
                                        class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                                    <form method="post" class="d-inline">
                                        <button class="btn btn-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                                        <input type="hidden" name="id" value="<?= $card['id'] ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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