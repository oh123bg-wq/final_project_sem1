<?php
require('header.php'); 

$user_id = $_SESSION['user']['id'];

// Check if form is submitted through POST (检查是否通过 POST 提交)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['card_id'])) {
    $card_id = intval($_POST['card_id']);

    // Check if the card already exists in user's collection (检查卡牌是否存在)
    $check_query = "SELECT id, quantity FROM final_project_sem1.collections WHERE user_id = ? AND card_id = ?";
    $stmt = $db->prepare($check_query);
    $stmt->execute([$user_id, $card_id]);
    $existing_record = $stmt->fetch();

    if ($existing_record) {
        // Card exists -> Update quantity + 1 (卡牌存在，数量 + 1)
        $update_query = "UPDATE final_project_sem1.collections SET quantity = quantity + 1, updated_at = NOW() WHERE id = ?";
        $update_stmt = $db->prepare($update_query);
        $update_stmt->execute([$existing_record['id']]);
    } else {
        // Card does not exist -> Insert new record (卡牌不存在，新插入一条)
        $insert_query = "INSERT INTO final_project_sem1.collections (user_id, card_id, quantity, updated_at) VALUES (?, ?, 1, NOW())";
        $insert_stmt = $db->prepare($insert_query);
        $insert_stmt->execute([$user_id, $card_id]);
    }

    // Redirect back to browse page with success parameter (成功后重定向)
    header("Location: browse-card.php?success=1");
    exit();

} else {
    header("Location: browse-card.php");
    exit();
}
?>
