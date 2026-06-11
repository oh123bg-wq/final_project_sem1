<?php
require('header.php');

// 1. 页面加载时，去数据库抓取所有的 rarities 列表
try {
  $rarity_query = "SELECT id, rarity_name FROM rarities ORDER BY id ASC";
  $rarity_stmt = $db->prepare($rarity_query);
  $rarity_stmt->execute();
  $rarities = $rarity_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $rarities = [];
}

$card = null;
$id = null;

// 2. 当通过 URL (GET 请求) 访问页面时，抓取这张卡牌的原本数据
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "SELECT cards.*, rarities.rarity_name FROM final_project_sem1.cards LEFT JOIN rarities ON cards.rarity_id = rarities.id WHERE cards.id = :id";
  $stmt = $db->prepare($query);
  $stmt->execute([
    ':id' => $id
  ]);
  $card = $stmt->fetch();

  // 如果找不到这张卡牌，安全退回到管理页面
  if (!$card) {
    header("Location: manage-card.php");
    exit();
  }
} else {
  header("Location: manage-card.php");
  exit();
}

// 3. 处理表单提交 (POST 请求)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $card_name = $_POST['card_name'];
  $pokemon_type = $_POST['pokemon_type'];
  $market_value = $_POST['market_value'];
  $rarity_id = $_POST['rarity_id'];

  // 默认方案：如果用户没有选新图，继续使用数据库里原本的老图片路径
  $image_db_path = $card['card_image'];

  // 4. 检查用户是否有上传新文件
  if (isset($_FILES['card_image']) && $_FILES['card_image']['error'] == 0) {
    $target_dir = "card_img/";

    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $file_name = time() . '_' . basename($_FILES["card_image"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["card_image"]["tmp_name"], $target_file)) {
      $image_db_path = $target_file; // 如果新图片上传成功，更新路径
    }
  }

  // 5. 执行数据库 UPDATE 更新语句
  $updateQuery = "UPDATE cards SET 
                    card_name = :card_name, 
                    pokemon_type = :pokemon_type, 
                    market_value = :market_value, 
                    card_image = :card_image, 
                    rarity_id = :rarity_id 
                    WHERE id = :id";

  $stmt = $db->prepare($updateQuery);
  $stmt->execute([
    ":card_name" => $card_name,
    ":pokemon_type" => $pokemon_type,
    ":market_value" => $market_value,
    ":card_image" => $image_db_path,
    ":rarity_id" => $rarity_id,
    ":id" => $id
  ]);

  // 修改成功后跳转回管理列表
  header("Location: manage-card.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel | Edit Pokémon Card</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet" />
  <style>
    * {
      font-family: "DynaPuff", system-ui;
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
        <h2 class="fw-bold text-primary">⚙️ Edit Card</h2>
        <p class="text-muted">Modify card details safely</p>
      </div>

      <form method="POST" action="" enctype="multipart/form-data">

        <div class="mb-3">
          <label for="card_name" class="form-label">Card Name</label>
          <input type="text" class="form-control form-control-lg fs-6" id="card_name" name="card_name"
            value="<?= htmlspecialchars($card['card_name']); ?>" required>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="pokemon_type" class="form-label">Pokémon Type</label>
            <select class="form-select form-select-lg fs-6" id="pokemon_type" name="pokemon_type">
              <?php
              $types = [
                "Water" => "Water 💧",
                "Fire" => "Fire 🔥",
                "Grass" => "Grass 🌿",
                "Lightning" => "Lightning ⚡",
                "Psychic" => "Psychic 👁️",
                "Colorless" => "Colorless ⚪",
                "Darkness" => "Darkness 🌙",
                "Dragon" => "Dragon 🐉",
                "Trainer" => "Trainer 👩🏻‍💼",
                "Stadium" => "Trainer 🏟️",
                "Item" => "Trainer 📦"
              ];
              foreach ($types as $val => $label):
              ?>
                <option value="<?= $val ?>" <?= $card['pokemon_type'] == $val ? 'selected' : '' ?>><?= $label ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6 mb-3">
            <label for="market_value" class="form-label">Market Value (RM)</label>
            <input type="number" step="0.01" class="form-control form-control-lg fs-6" id="market_value" name="market_value"
              value="<?= htmlspecialchars($card['market_value']); ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="rarity_id" class="form-label">Card Rarity</label>
          <select class="form-select form-select-lg fs-6" id="rarity_id" name="rarity_id" required>
            <?php foreach ($rarities as $rarity): ?>
              <option value="<?= $rarity['id']; ?>" <?= $card['rarity_id'] == $rarity['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($rarity['rarity_name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-4">
          <label for="card_image" class="form-label">Card Image Photo</label>
          <input type="file" class="form-control" id="card_image" name="card_image" accept="image/*">
          <div class="form-text">Leave empty if you don't want to change the image.</div>
        </div>

        <div class="d-grid pt-2">
          <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>