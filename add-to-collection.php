<?php
require('header.php'); 

// 1. 确保用户已经登录，并且 Session 包含用户 ID
if (!isset($_SESSION['user']['id'])) {
    // 如果没有存储用户 ID，可以通过用户名去查询，或者确保登录时存了 ID。这里假设存了 ['id']
    die("Error: User session 'id' not found. Please log in again.");
}

$user_id = $_SESSION['user']['id'];

// 2. 检查是否是通过表单 POST 提交过来的
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['card_id'])) {
    $card_id = intval($_POST['card_id']);

    try {
        // 3. 检查 collections 表中是否已经存在该用户购买的这张卡
        $check_query = "SELECT id, quantity FROM final_project_sem1.collections WHERE user_id = ? AND card_id = ?";
        $stmt = $db->prepare($check_query);
        $stmt->execute([$user_id, $card_id]);
        $existing_record = $stmt->fetch();

        if ($existing_record) {
            // 4. 方案 A：如果卡牌已存在，则数量 quantity + 1
            $update_query = "UPDATE final_project_sem1.collections SET quantity = quantity + 1, updated_at = NOW() WHERE id = ?";
            $update_stmt = $db->prepare($update_query);
            $update_stmt->execute([$existing_record['id']]);
        } else {
            // 5. 方案 B：如果卡牌不存在，则新插入一条数据，数量默认为 1
            $insert_query = "INSERT INTO final_project_sem1.collections (user_id, card_id, quantity, updated_at) VALUES (?, ?, 1, NOW())";
            $insert_stmt = $db->prepare($insert_query);
            $insert_stmt->execute([$user_id, $card_id]);
        }

        // 6. 添加成功后，重定向回浏览页面，并带上成功状态参数
        header("Location: browse-card.php?success=1");
        exit();

    } catch (PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }
} else {
    // 如果不是正常提交，直接送回主页
    header("Location: browse-card.php");
    exit();
}
?>
