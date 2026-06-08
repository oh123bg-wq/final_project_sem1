<?php
require('header.php');

$current_username = $_SESSION['user']['username'];

$query = "SELECT cards.*, rarities.rarity_name FROM final_project_sem1.cards LEFT JOIN rarities ON cards.rarity_id = rarities.id ORDER BY id DESC";

$stmt = $db->prepare($query);
$stmt->execute([]);
$cards = $stmt->fetchAll();
// echo json_encode($cards)
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

    <div class="container">
        <h2 class="text-center mb-5">Browse Card</h2>

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
                                <span class="fw-bold"><?= $card['market_value'] ?></span>
                            </div>

                            <button type="button" class="btn btn-secondary btn-link text-primary p-0 border-0 text-center w-100">
                                <i class="bi bi-plus-circle-fill"></i> Add to Your Collection
                            </button>

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