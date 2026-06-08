<?php
require('header.php');

$current_username = $_SESSION['user']['username'];
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
                <a href="collection.php" class="btn btn-sm btn-primary px-3 rounded-pill fw-semibold shadow-sm"><i class="bi bi-box2-heart-fill"></i></a>
                <a href="collection.php" class="btn btn-sm btn-primary px-3 rounded-pill fw-semibold shadow-sm d-none d-sm-inline"><i class="bi bi-box2-heart-fill"></i> Your collection</a>
                <a href="browse-card.php" class="btn btn-sm btn-primary px-3 rounded-pill fw-semibold shadow-sm"><i class="bi bi-search-heart-fill"></i></a>
                <a href="browse-card.php" class="btn btn-sm btn-primary px-3 rounded-pill fw-semibold shadow-sm d-none d-sm-inline"><i class="bi bi-search-heart-fill"></i> Browse card</a>
                <a href="logout.php" class="btn btn-sm btn-outline-danger rounded-circle" title="Log Out">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- <div class="container-fluid bg-secondary navbar-dark fixed-top">
        <nav class="navbar navbar-expand-lg p-2">
            <div class="container navbar-dark">
                <div>
                    <img src="../final_project_sem1/asset/masterballs-removebg-preview.png" alt="Pokémon TCG Tracker Logo" style="width: 60px; height: 60px; object-fit: cover;" />
                    <a href="#" class="navbar-brand fw-bold fs-1">Pokémon TCG Tracker</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item active">
                            <a href="#home" class="nav-link">My collection</a>
                        </li>
                        <li class="nav-item">
                            <a href="#about" class="nav-link">Browse catalog</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tv-series" class="nav-link">Name</a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn nav-link">
                                <i class="bi bi-box-arrow-right me-1 "></i> Log Out
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div> -->

    <div class="container hero">
        <div class="d-flex ">
            <div class="container justify-content-between align-items-center flex-wrap">
                <h2>👋 Welcome, <span class="text-primary">Collector</span>!</h2>
                <p>Here is your binder value overview and card inventory.</p>
            </div>
            <div class="container total-value d-flex">
                <div><i class="bi bi-cash"></i></div>
                <div>
                    <p>Total Binder Value</p>
                    <p>$999</p>
                    <p>2 card stacks in binder</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-4">

            <div>
                <h2 class="fw-bold mb-2">👋 Welcome, <span class="text-primary">Collector!</span></h2>
                <p class="text-muted mb-0">Here is your binder value overview and card inventory.</p>
            </div>

            <div class="total-value-card d-flex align-items-center text-white p-3 shadow">
                <div class="usd-icon-box d-flex align-items-center justify-content-center me-3">
                    <span class="fs-4 fw-bold">$</span>
                </div>
                <div>
                    <p class="text-uppercase small mb-0 opacity-75 fw-semibold" style="letter-spacing: 0.5px; font-size: 0.75rem;">Total Binder Value</p>
                    <h2 class="fw-bold mb-0" style="font-size: 2.2rem; line-height: 1.1;">$585.50</h2>
                    <p class="small mb-0 opacity-75" style="font-size: 0.8rem;">3 card stacks in binder</p>
                </div>
            </div>

        </div>
    </div>
    <div class="container">
        <h2 class="text-center mb-5">Your Collection</h2>
        <div class="d-flex flex-wrap">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card m-3 border-0 shadow-sm">
                    <img src="../assets/cat 1.jpg" class="card-img-top" alt="Charmander" />
                    <div class="card-body">
                        <!-- 1. Rarity: 放在最上方，使用小字号和颜色 -->
                        <p class="text-primary fw-bold mb-1" style="font-size: 0.8rem; text-transform: uppercase;">Rare</p>

                        <!-- 卡片名称 -->
                        <h5 class="fw-bold mb-3">Charmander</h5>

                        <!-- 2. Value: 使用浅灰色背景包裹 -->
                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded mb-3">
                            <span class="text-muted small">Value/Card:</span>
                            <span class="fw-bold">$100.00</span>
                        </div>

                        <hr>

                        <!-- 3. Quantity: 左右对齐的布局 -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Quantity:</span>
                            <!-- input-group is veli gud it make the shape become nice -->
                            <div class="input-group input-group-sm" style="width: 80px;">
                                <button class="btn btn-outline-secondary px-2" type="button">-</button>
                                <input type="text" class="form-control text-center p-0 border-secondary" value="1" readonly>
                                <button class="btn btn-outline-secondary px-2" type="button">+</button>
                            </div>
                        </div>

                        <!-- 4. Stack Value -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-muted small">Stack Value:</span>
                            <span class="fw-bold text-dark">$100.00</span>
                        </div>

                        <!-- 删除按钮 -->
                        <!-- i add the btn-primary is to make my hover effect work because 
                          i use btn-link already and make the button look exactly like a clean text hyperlink 
                          and at the same time make the hover effect cannot work-->
                        <button type="button" class="btn btn-primary btn-link text-danger p-0 border-0 text-center w-100 remove-btn">
                            <i class="bi bi-trash"></i> Remove from Binder
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card m-3 border-0 shadow-sm">
                    <img src="../assets/cat 1.jpg" class="card-img-top" alt="Charmander" />
                    <div class="card-body">
                        <!-- 1. Rarity: 放在最上方，使用小字号和颜色 -->
                        <p class="text-primary fw-bold mb-1" style="font-size: 0.8rem; text-transform: uppercase;">Rare</p>

                        <!-- 卡片名称 -->
                        <h5 class="fw-bold mb-3">Charmander</h5>

                        <!-- 2. Value: 使用浅灰色背景包裹 -->
                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded mb-3">
                            <span class="text-muted small">Value/Card:</span>
                            <span class="fw-bold">$100.00</span>
                        </div>

                        <hr>

                        <!-- 3. Quantity: 左右对齐的布局 -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Quantity:</span>
                            <div class="input-group input-group-sm" style="width: 80px;">
                                <button class="btn btn-outline-secondary px-2" type="button">-</button>
                                <input type="text" class="form-control text-center p-0 border-secondary" value="1" readonly>
                                <button class="btn btn-outline-secondary px-2" type="button">+</button>
                            </div>
                        </div>

                        <!-- 4. Stack Value -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-muted small">Stack Value:</span>
                            <span class="fw-bold text-dark">$100.00</span>
                        </div>

                        <!-- 删除按钮 -->
                        <button type="button" class="btn btn-primary btn-link text-danger p-0 border-0 text-center w-100 remove-btn">
                            <i class="bi bi-trash"></i> Remove from Binder
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card m-3 border-0 shadow-sm">
                    <img src="../assets/cat 1.jpg" class="card-img-top" alt="Charmander" />
                    <div class="card-body">
                        <!-- 1. Rarity: 放在最上方，使用小字号和颜色 -->
                        <p class="text-primary fw-bold mb-1" style="font-size: 0.8rem; text-transform: uppercase;">Rare</p>

                        <!-- 卡片名称 -->
                        <h5 class="fw-bold mb-3">Charmander</h5>

                        <!-- 2. Value: 使用浅灰色背景包裹 -->
                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded mb-3">
                            <span class="text-muted small">Value/Card:</span>
                            <span class="fw-bold">$100.00</span>
                        </div>

                        <hr>

                        <!-- 3. Quantity: 左右对齐的布局 -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Quantity:</span>
                            <div class="input-group input-group-sm" style="width: 80px;">
                                <button class="btn btn-outline-secondary px-2" type="button">-</button>
                                <input type="text" class="form-control text-center p-0 border-secondary" value="1" readonly>
                                <button class="btn btn-outline-secondary px-2" type="button">+</button>
                            </div>
                        </div>

                        <!-- 4. Stack Value -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-muted small">Stack Value:</span>
                            <span class="fw-bold text-dark">$100.00</span>
                        </div>

                        <!-- 删除按钮 -->
                        <button type="button" class="btn btn-primary btn-link text-danger p-0 border-0 text-center w-100 remove-btn">
                            <i class="bi bi-trash"></i> Remove from Binder
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card m-3 border-0 shadow-sm">
                    <img src="../assets/cat 1.jpg" class="card-img-top" alt="Charmander" />
                    <div class="card-body">
                        <!-- 1. Rarity: 放在最上方，使用小字号和颜色 -->
                        <p class="text-primary fw-bold mb-1" style="font-size: 0.8rem; text-transform: uppercase;">Rare</p>

                        <!-- 卡片名称 -->
                        <h5 class="fw-bold mb-3">Charmander</h5>

                        <!-- 2. Value: 使用浅灰色背景包裹 -->
                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded mb-3">
                            <span class="text-muted small">Value/Card:</span>
                            <span class="fw-bold">$100.00</span>
                        </div>

                        <hr>

                        <!-- 3. Quantity: 左右对齐的布局 -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Quantity:</span>
                            <div class="input-group input-group-sm" style="width: 80px;">
                                <button class="btn btn-outline-secondary px-2" type="button">-</button>
                                <input type="text" class="form-control text-center p-0 border-secondary" value="1" readonly>
                                <button class="btn btn-outline-secondary px-2" type="button">+</button>
                            </div>
                        </div>

                        <!-- 4. Stack Value -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-muted small">Stack Value:</span>
                            <span class="fw-bold text-dark">$100.00</span>
                        </div>

                        <!-- 删除按钮 -->
                        <button type="button" class="btn btn-primary btn-link text-danger p-0 border-0 text-center w-100 remove-btn">
                            <i class="bi bi-trash"></i> Remove from Binder
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card m-3 border-0 shadow-sm">
                    <img src="../assets/cat 1.jpg" class="card-img-top" alt="Charmander" />
                    <div class="card-body">
                        <!-- 1. Rarity: 放在最上方，使用小字号和颜色 -->
                        <p class="text-primary fw-bold mb-1" style="font-size: 0.8rem; text-transform: uppercase;">Rare</p>

                        <!-- 卡片名称 -->
                        <h5 class="fw-bold mb-3">Charmander</h5>

                        <!-- 2. Value: 使用浅灰色背景包裹 -->
                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded mb-3">
                            <span class="text-muted small">Value/Card:</span>
                            <span class="fw-bold">$100.00</span>
                        </div>

                        <hr>

                        <!-- 3. Quantity: 左右对齐的布局 -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Quantity:</span>
                            <div class="input-group input-group-sm" style="width: 80px;">
                                <button class="btn btn-outline-secondary px-2" type="button">-</button>
                                <input type="text" class="form-control text-center p-0 border-secondary" value="1" readonly>
                                <button class="btn btn-outline-secondary px-2" type="button">+</button>
                            </div>
                        </div>

                        <!-- 4. Stack Value -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-muted small">Stack Value:</span>
                            <span class="fw-bold text-dark">$100.00</span>
                        </div>

                        <!-- 删除按钮 -->
                        <!-- i add the btn-primary is to make my hover effect work because 
                          i use btn-link already andmake the button look exactly like a clean text hyperlink 
                          and at the smae time make the hover effect cannot work-->
                        <button type="button" class="btn btn-primary btn-link text-danger p-0 border-0 text-center w-100 remove-btn">
                            <i class="bi bi-trash"></i> Remove from Binder
                        </button>
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

</body>

</html>