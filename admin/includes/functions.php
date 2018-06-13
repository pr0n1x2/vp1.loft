<?php

function getUsers()
{
    global $pdo;

    $sql = "SELECT u.*, COUNT(o.`user_id`) AS `ctn` FROM `users` u  
            INNER JOIN `orders` o ON o.`user_id` = u.`id`
            GROUP BY o.`user_id`
            ORDER BY `id` DESC";

    $users = $pdo->query($sql)->fetchAll();

    return count($users) > 0 ? $users : false;
}

function getOrders()
{
    global $pdo;

    $userId = $_GET['id'];

    $sql = "SELECT o.`id`, o.`street`, o.`home`, o.`is_callback`, o.`created`, u.`name`, 
            u.`phone`, d.`name` AS `payment`
            FROM `orders` o 
            INNER JOIN `users` u ON u.`id` = o.`user_id`
            INNER JOIN `deliveries` d ON d.`id` = o.`delivery_id` ";
    
    if (!empty($userId)) {
        $sql .= "WHERE o.`user_id` = ? ORDER BY 1 DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
    } else {
        $sql .= "ORDER BY 1 DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    $orders = $stmt->fetchAll();

    return count($orders) > 0 ? $orders : false;
}

function getOrderDetails()
{
    global $pdo;

    $userId = $_GET['id'];

    $sql = "SELECT u.`id` AS `user_id`, u.`email`, u.`name`, u.`phone`, o.*, d.`name` AS `payment` FROM `orders` o 
            INNER JOIN `users` u ON u.`id` = o.`user_id`
            INNER JOIN `deliveries` d ON d.`id` = o.`delivery_id` 
            WHERE o.`id` = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $userId, PDO::PARAM_INT);
    $stmt->execute();

    $order = $stmt->fetch();

    if (!count($order)) {
        return false;
    }

    $order['order_count'] = getOrderCount($order['user_id']);

    return $order;
}

function getOrderCount($userId)
{
    global $pdo;

    $sql = "SELECT COUNT(*) AS `ctn` FROM `orders` WHERE `user_id` = ? GROUP BY `user_id`";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $userId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch();

    return $result['ctn'];
}
