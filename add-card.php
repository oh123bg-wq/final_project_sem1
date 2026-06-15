<?php
require('header.php');

$message = "";
// the write a message "sucess" or "danger"
$message_type = "";

$rarity_query = "SELECT id, rarity_name FROM rarities ORDER BY id ASC";
$rarity_stmt = $db->prepare($rarity_query);

// 直接用 if 判断 execute() 是成功 (true) 还是失败 (false)
if ($rarity_stmt && $rarity_stmt->execute()) {
    // fetch all your rarity
    $rarities = $rarity_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $message = "❌ Failed to load rarities due to a database issue.";
    $message_type = "danger";
    // prevent error (依然给个空数组，防止下方的 HTML foreach 循环报错)
    $rarities = [];
}


//  check whether the user is submit or not
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $card_name = isset($_POST['card_name']) ? $_POST['card_name'] : null;
    $pokemon_type = isset($_POST['pokemon_type']) ? $_POST['pokemon_type'] : null;
    $market_value = isset($_POST['market_value']) ? $_POST['market_value'] : null;
    $rarity_id = isset($_POST['rarity_id']) ? $_POST['rarity_id'] : null;

    // 初始化图片数据库路径变量
    $image_db_path = null;

    // 处理图片上传核心逻辑
    if (isset($_FILES['card_image']) && $_FILES['card_image']['error'] == 0) {

        $file_name = $_FILES['card_image']['name'];
        $file_tmp  = $_FILES['card_image']['tmp_name'];

        // prevent have same image name and make the file crash so i add the time when you upload
        $unique_file_name = time() . '_' . $file_name;

        // upload to card_img
        $upload_folder = "card_img/";

        $target_file_path = $upload_folder . $unique_file_name; // 结果如: "card_img/1717500000_greninja.jpg"

        //  将临时文件移动到项目的 card_img 文件夹中
        if (move_uploaded_file($file_tmp, $target_file_path)) {
            $image_db_path = $target_file_path; // 移动成功，记录路径准备存入数据库
        } else {
            $message = "❌ Failed to move uploaded file to destination folder.";
            $message_type = "danger";
        }
    } else {
        $message = "❌ Please select a valid card image.";
        $message_type = "danger";
    }

    // 如果资料齐全且上传没报错，写入 SQL 数据库
    if ($card_name && $market_value && $rarity_id && $message_type != "danger") {

        // 这里的写入数据的 Try-Catch 也换成了 If-Else
        $query = "INSERT INTO cards (card_name, pokemon_type, market_value, card_image, rarity_id) 
                  VALUES (:card_name, :pokemon_type, :market_value, :card_image, :rarity_id)";

        $stmt = $db->prepare($query);

        // 直接在 if 里面执行并判断结果
        if ($stmt && $stmt->execute([
            ':card_name' => $card_name,
            ':pokemon_type' => $pokemon_type,
            ':market_value' => $market_value,
            ':card_image' => $image_db_path,
            ':rarity_id' => $rarity_id
        ])) {
            $message = "🎉 New card data and image uploaded successfully!";
            $message_type = "success";
        } else {
            $message = "❌ Database Error: Failed to save the card into database.";
            $message_type = "danger";
        }
    } else if (empty($rarity_id) && $message_type != "danger") {
        $message = "❌ Please select a card rarity.";
        $message_type = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Add Pokémon Card</title>
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

        body {
            background-color: #f8fafc;
        }

        .admin-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 600;
            color: #475569;
        }
    </style>
</head>

<body>

    <div class="container my-5">
        <div class="mb-4 text-center">
            <a href="manage-card.php" class="btn btn-sm btn-outline-secondary px-3 rounded-pill">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="card admin-card p-4 p-md-5 mx-auto bg-white" style="max-width: 650px;">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">Add New Card</h2>
                <p class="text-muted">Create new cards with Image and Rarity Relation</p>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?= $message_type; ?> alert-dismissible fade show" role="alert">
                    <?= $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="add-card.php" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="card_name" class="form-label">Card Name</label>
                    <input type="text" class="form-control form-control-lg fs-6" id="card_name" name="card_name" placeholder="e.g., Mega Greninja ex" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pokemon_type" class="form-label">Pokémon Type</label>
                        <select class="form-select form-select-lg fs-6" id="pokemon_type" name="pokemon_type">
                            <option value="Water">Water 💧</option>
                            <option value="Fire">Fire 🔥</option>
                            <option value="Grass">Grass 🌿</option>
                            <option value="Lightning">Lightning ⚡</option>
                            <option value="Psychic">Psychic 👁️</option>
                            <option value="Colorless">Colorless ⚪</option>
                            <option value="Darkness">Darkness 🌙</option>
                            <option value="Dragon">Dragon 🐉</option>
                            <option value="Trainer">Trainer 👩🏻‍💼</option>
                            <option value="Stadium">Trainer 🏟️</option>
                            <option value="Item">Trainer 📦</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="market_value" class="form-label">Market Value (RM)</label>
                        <input type="number" step="0.01" class="form-control form-control-lg fs-6" id="market_value" name="market_value" placeholder="e.g., 1640.88" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="rarity_id" class="form-label">Card Rarity</label>
                    <select class="form-select form-select-lg fs-6" id="rarity_id" name="rarity_id" required>
                        <option value="" disabled selected>-- Select Rarity --</option>
                        <?php foreach ($rarities as $rarity): ?>
                            <option value="<?= $rarity['id']; ?>">
                                <?= $rarity['rarity_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="card_image" class="form-label">Card Image Photo</label>
                    <input type="file" class="form-control" id="card_image" name="card_image" accept="image/*" required>
                    <div class="form-text">Saved into <code>card_img/</code> folder.</div>
                </div>

                <div class="d-grid pt-2">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill shadow-sm">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Upload & Save Card
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>