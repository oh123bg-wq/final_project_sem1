<?php
session_start();

$db = new PDO("mysql:host=localhost;dbname=final_project_sem1", "root");

// $is_logged_in = user 
$is_logged_in = isset($_SESSION['user']);

$current_username = $is_logged_in ? $_SESSION['user']['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon TCG Tracker | Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8fafc;
        }

        .hero-banner {
            background: linear-gradient(90deg, rgba(30, 58, 138, 1) 5%, rgba(59, 130, 246, 1) 100%);
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.15);
        }

        .logo {
            width: 50px;
            height: 50px;
        }

        .pic-logo {
            width: 100%;
            max-width: 350px;
            height: auto;
        }

        .pic-cover {
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 12px;
        }

        .latest-card-box {
            background: linear-gradient(90deg, rgba(0, 63, 158, 1) 5%, rgba(9, 128, 219, 1) 47%, rgba(0, 212, 255, 1) 98%);
            border-radius: 24px;
        }
    </style>
</head>

<body>

    <div class="navbar navbar-expand-lg navbar-white bg-white border-bottom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-4 text-dark" href="index.php">
                <img src="../final_project_sem1/asset/masterballs-removebg-preview.png" alt="Logo" class="logo rounded-circle" style="object-fit: cover;">
                <span>Pokémon TCG Tracker</span>
            </a>

            <div class="d-flex align-items-center gap-3">
                <?php if ($is_logged_in): ?>
                    <span class="text-muted small d-none d-sm-inline">👋 Welcome, <strong class="text-dark"><?= htmlspecialchars($current_username); ?></strong></span>
                    <a href="collection.php" class="btn btn-sm btn-primary px-3 rounded-pill fw-semibold shadow-sm">My Binder</a>
                    <a href="logout.php?logout=true" class="btn btn-sm btn-outline-danger rounded-circle" title="Log Out">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                <?php else: ?>
                    <a href="login-form.php" class="btn btn-sm btn-outline-secondary px-3 rounded-pill fw-semibold">Login</a>
                    <a href="register-form.php" class="btn btn-sm btn-primary px-3 rounded-pill fw-semibold shadow-sm">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container my-5">

        <div class="hero-banner p-4 p-md-5 text-white mb-5 d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
            <div style="max-width: 600px;">
                <span class="badge bg-white text-primary fw-bold px-3 py-2 rounded-pill text-uppercase mb-3 tracking-wider small">Version 1.0 Live</span>
                <h1 class="display-5 fw-bold mb-3" style="line-height: 1.2;">The Ultimate Pokémon TCG Tracker</h1>
                <p class="lead opacity-75 mb-4">Manage your personal card binders, view market analytics, and keep an eye on your absolute total collection value in real-time.</p>

                <?php if (!$is_logged_in): ?>
                    <a href="register-form.php" class="btn btn-light btn-lg px-4 rounded-3 fw-bold text-primary shadow">Start Collection</a>
                <?php else: ?>
                    <a href="collection.php" class="btn btn-light btn-lg px-4 rounded-3 fw-bold text-primary shadow"><i class="bi bi-journal-bookmark-fill me-2"></i>Open Your Binder</a>
                <?php endif; ?>
            </div>
            <div class="text-center bg-white bg-opacity-10 p-4 rounded-4 backdrop-blur" style="border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 280px;">
                <i class="bi bi-lightning-charge text-warning display-2 mb-2 d-block"></i>
                <h5 class="fw-bold mb-1">Real-time Prices</h5>
                <p class="small opacity-75 mb-0">Powered by live TCG market valuation analysis.😎</p>
            </div>
        </div>

        <h4 class="fw-bold mb-4 d-flex align-items-center gap-2">
            🔥Pokémon TCG Latest Set🔥
        </h4>

        <div class="latest-card-box p-4 p-md-5 text-white mb-5 d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
            <div class="d-flex flex-column align-items-center w-100 text-center text-md-start align-items-md-start" style="max-width: 500px;">
                <img src="../final_project_sem1/asset/Chaos_Rising_Logo.png" class="pic-logo mb-2 img-fluid" alt="Chaos Rising Logo Picture" style="object-fit: contain;">
                <p class="lead mb-4 w-100 text-center text-md-start">Released on May 22, 2026!</p>
                <div class="w-100 text-center text-md-start">
                    <?php if (!$is_logged_in): ?>
                        <a href="register-form.php" class="btn btn-light btn-lg px-4 rounded-3 fw-bold text-primary shadow">Explore Card</a>
                    <?php else: ?>
                        <a href="collection.php" class="btn btn-light btn-lg px-4 rounded-3 fw-bold text-primary shadow">Explore Your Card</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center bg-white bg-opacity-10 p-3 rounded-4 backdrop-blur w-100" style="border: 1px solid rgba(255,255,255,0.2); max-width: 450px;">
                <img src="../final_project_sem1/asset/chaos_rising_pic.jpg" class="pic-cover img-fluid shadow-sm" alt="Chaos Rising Picture" style="object-fit: cover;">
            </div>
        </div>

    </div>

    <footer>
        <div class="container-fluid bg-white border-top pt-4 pb-2">
            <div class="container text-center">
                <div class="d-flex justify-content-center pb-2 text-muted fs-5">
                    <i class="bi bi-facebook px-2"></i>
                    <i class="bi bi-twitter px-2"></i>
                    <i class="bi bi-instagram px-2"></i>
                    <i class="bi bi-linkedin px-2"></i>
                </div>
                <p class="text-center text-muted small">All rights reserved &copy; Pokémon TCG Tracker 2026.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>