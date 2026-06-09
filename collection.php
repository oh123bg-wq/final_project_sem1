<?php
require('header.php');

$current_username = $_SESSION['user']['username'];
$user_id = $_SESSION['user']['id']; // 获取当前用户 ID

//  完美的 SQL 联表查询：只拿当前登录用户的收藏，并且关联卡牌信息和稀有度名称
$query = "SELECT cards.*, rarities.rarity_name, collections.quantity, collections.id AS collection_entry_id 
          FROM final_project_sem1.collections
          INNER JOIN final_project_sem1.cards ON collections.card_id = cards.id
          LEFT JOIN rarities ON cards.rarity_id = rarities.id
          WHERE collections.user_id = ?
          ORDER BY collections.id DESC";

//  修复后的删除逻辑
if (isset($_POST['collection_entry_id'])) {
    $collection_entry_id = $_POST['collection_entry_id'];

    //  安全策略：带上 user_id = ? 确保用户只能删除属于他自己的收藏，防止越权漏洞
    $deleteQuery = "DELETE FROM final_project_sem1.collections WHERE id = :id AND user_id = :user_id";

    $stmt = $db->prepare($deleteQuery);
    $stmt->execute([
        ":id" => $collection_entry_id,
        ":user_id" => $user_id
    ]);

    header("Location: collection.php");
    exit();
}

$stmt = $db->prepare($query);
$stmt->execute([$user_id]); 
$cards = $stmt->fetchAll();

// 初始化累加器变量 (Variables)
$total_binder_value = 0;
$total_stacks = count($cards); // 直接通过 count 获取一共有多少叠不同的卡牌

foreach ($cards as $card) {
    // 将每一叠卡牌的 Stack Value 动态累加到总资产中
    $total_binder_value += $card['market_value'] * $card['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Noto+Serif:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="collection.css" />
    <title>Pokémon TCG Tracker</title>
    <style>
        .logo {
            width: 50px;
            height: 50px;
        }

        body {
            background-color: #f8fafc;
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


    <div class="container py-5">
        <div class="row align-items-center g-4">

            <div class="col-md-8">
                <h2 class="fw-bold text-dark mb-2" style="letter-spacing: -0.02em;">
                    👋 Welcome, <span class="text-primary"><?php echo htmlspecialchars($current_username); ?></span>!
                </h2>
                <p class="text-muted mb-0 fs-6">
                    Here is your binder value overview and card inventory.
                </p>
            </div>

            <div class="col-md-4">
                <div class="bg-gradient bg-primary text-white rounded-4 p-4 shadow">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3 fs-3 "
                            style="width: 55px; height: 45px; background-color: rgba(255, 255, 255, 0.2);">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <div class="flex-grow-1 w-100">
                            <p class="text-white-75 small fw-bold text-uppercase d-block mb-1">
                                Total Binder Value
                            </p>
                            <h3 class="display-6 fw-bold m-0 lh-1 mb-2">RM <?= number_format($total_binder_value, 2) ?></h3>
                            <div class="d-flex align-items-center gap-1 text-white-75 small">
                                <i class="bi bi-layers-half me-1"></i>
                                <span><?= $total_stacks ?> card stacks in binder</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container">
        <h2 class="text-center mb-5">Your Collection</h2>
        <div class="d-flex flex-wrap">
            <?php foreach ($cards as $card): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card m-3 border-0 shadow-sm">
                        <img src="<?= $card['card_image'] ?>" class="card-img-top" alt="<?= $card['card_name'] ?>" />
                        <div class="card-body">
                            <!-- 1. Rarity: 放在最上方，使用小字号和颜色 -->
                            <p class="text-primary fw-bold mb-1" style="font-size: 0.8rem; text-transform: uppercase;"><?= $card['rarity_name'] ?></p>

                            <!-- 卡片名称 -->
                            <h5 class="fw-bold mb-3"><?= $card['card_name'] ?></h5>

                            <!-- 2. Value: 使用浅灰色背景包裹 -->
                            <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded mb-3">
                                <span class="text-muted small">Value/Card:</span>
                                <span class="fw-bold">RM <?= $card['market_value'] ?></span>
                            </div>

                            <hr>

                            <!-- 3. Quantity: 左右对齐的布局 -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">Quantity:</span>
                                <!-- input-group is veli gud it make the shape become nice -->
                                <div class="input-group input-group-sm" style="width: 80px;">
                                    <button class="btn btn-outline-secondary px-2" type="button">-</button>
                                    <input type="text" class="form-control text-center p-0 border-secondary" value="<?= $card['quantity'] ?>" readonly>
                                    <button class="btn btn-outline-secondary px-2" type="button">+</button>
                                </div>
                            </div>

                            <!-- 4. Stack Value -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="text-muted small">Stack Value:</span>
                                <!-- number format( ,2) is to make sure the price have 2 decimal number -->
                                <span class="fw-bold text-dark">RM <?= number_format($card['market_value'] * $card['quantity'], 2) ?></span>
                            </div>

                            <!-- 删除按钮 -->
                            <!-- i add the btn-primary is to make my hover effect work because 
                          i use btn-link already and make the button look exactly like a clean text hyperlink 
                          and at the same time make the hover effect cannot work-->
                            <form method="post" class="d-inline">
                                <button type="submit" class="btn btn-danger btn-link text-danger p-0 border-0 text-center w-100 remove-btn">
                                    <i class="bi bi-trash"></i> Remove from Binder
                                </button>

                                <input type="hidden" name="collection_entry_id" value="<?= $card['collection_entry_id'] ?>">
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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

</body>

</html>