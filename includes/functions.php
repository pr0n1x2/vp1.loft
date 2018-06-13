<?php

function makeOrder()
{
    global $pdo;

    $errors = checkErrors();

    if ($errors !== false) {
        return generateErrors($errors);
    }

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim(mb_strtolower($_POST['email']));
    $street = trim($_POST['street']);
    $home = trim($_POST['home']);
    $part = !empty($_POST['part']) ? trim($_POST['part']) : null;
    $appt = !empty($_POST['appt']) ? trim($_POST['appt']) : null;
    $floor = !empty($_POST['floor']) ? trim($_POST['floor']) : null;
    $comment = !empty($_POST['comment']) ? trim($_POST['comment']) : null;
    $payment = trim($_POST['payment']);
    $callback = $_POST['callback'] == 'on' ? 1 : 0;

    $userId = getUser($email, $name, $phone);

    $created = date("Y-m-d H:i:s");
    $sql = "INSERT INTO `orders` (`user_id`, `street`, `home`, `part`, `appt`, `floor`, `comment`, `delivery_id`, " .
              "`is_callback`, `created`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $userId);
    $stmt->bindParam(2, $street);
    $stmt->bindParam(3, $home);
    $stmt->bindParam(4, $part);
    $stmt->bindParam(5, $appt);
    $stmt->bindParam(6, $floor);
    $stmt->bindParam(7, $comment);
    $stmt->bindParam(8, $payment);
    $stmt->bindParam(9, $callback);
    $stmt->bindParam(10, $created);
    $stmt->execute();

    $orderId = $pdo->lastInsertId();

    sendMail($orderId);

    return true;
}

function checkErrors()
{
    $errors = [];

    if (empty($_POST['name'])) {
        $errors[] = "Поле 'Имя' обязательное для заполнения.";
    } elseif (mb_strlen($_POST['name']) > 100) {
        $errors[] = "В поле 'Имя' превышен лимит в 100 символов.";
    }

    if (strlen(preg_replace('~\D+~', '', $_POST['phone'])) < 11) {
        $errors[] = "Заполните корректно контактный телефон.";
    }

    if (empty($_POST['email'])) {
        $errors[] = "Поле 'Email' обязательное для заполнения.";
    } elseif (mb_strlen($_POST['name']) > 200) {
        $errors[] = "В поле 'Email' превышен лимит в 200 символов.";
    }

    if (empty($_POST['street'])) {
        $errors[] = "Поле 'Улица' обязательное для заполнения.";
    } elseif (mb_strlen($_POST['street']) > 150) {
        $errors[] = "В поле 'Улица' превышен лимит в 150 символов.";
    }

    if (empty($_POST['home'])) {
        $errors[] = "Поле 'Дом' обязательное для заполнения.";
    } elseif (mb_strlen($_POST['home']) > 50) {
        $errors[] = "В поле 'Дом' превышен лимит в 50 символов.";
    }

    if (mb_strlen($_POST['part']) > 50) {
        $errors[] = "В поле 'Корпус' превышен лимит в 50 символов.";
    }

    if (mb_strlen($_POST['appt']) > 50) {
        $errors[] = "В поле 'Квартира' превышен лимит в 50 символов.";
    }

    if (mb_strlen($_POST['floor']) > 50) {
        $errors[] = "В поле 'Этаж' превышен лимит в 50 символов.";
    }

    if (mb_strlen($_POST['comment']) > 4096) {
        $errors[] = "В поле 'Комментарий' превышен лимит в 4096 символов.";
    }

    if (empty($_POST['payment'])) {
        $errors[] = "Вы не выбрали способ оплаты.";
    }

    return !count($errors) ? false : $errors;
}

function generateErrors(&$errors)
{
    $htmlResult = null;

    for ($i = 0; $i < count($errors); $i++) {
        $htmlResult .= '<p class="validator_error">' . $errors[$i] . '</p>';
    }

    return $htmlResult;
}

function getUser($email, $name, $phone)
{
    global $pdo;

    $sql = "SELECT `id` FROM `users` WHERE `email` = ? LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch();

    return is_array($user) ? $user['id'] : registerUser($email, $name, $phone);
}

function registerUser($email, $name, $phone)
{
    global $pdo;

    $created = date("Y-m-d H:i:s");
    $sql = "INSERT INTO `users` (`email`, `name`, `phone`, `created`) values (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->bindParam(2, $name);
    $stmt->bindParam(3, $phone);
    $stmt->bindParam(4, $created);
    $stmt->execute();

    return $pdo->lastInsertId();
}

function sendMail($orderId)
{
    global $pdo;

    $sql = "SELECT u.`id`, u.`email`, u.`name`, o.`street`, o.`home`, o.`part`, o.`appt`, o.`floor` FROM `orders` o " .
            "INNER JOIN `users` u ON u.`id` = o.`user_id` " .
            "WHERE o.`id` = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $orderId, PDO::PARAM_INT);
    $stmt->execute();

    $order = $stmt->fetch();
    $orderCount = getOrderCount($order['id']);

    $theme = "Заказ №$orderId";
    $letter  = "Ваш заказ будет доставлен по адресу:\n\n";
    $letter .= "Улица: " . $order['street'];
    $letter .= "\nДом: " . $order['home'];

    if (!empty($order['part'])) {
        $letter .= "\nКорпус: " . $order['part'];
    }

    if (!empty($order['appt'])) {
        $letter .= "\nКвартира: " . $order['appt'];
    }

    if (!empty($order['floor'])) {
        $letter .= "\nЭтаж: " . $order['floor'];
    }

    $letter .= "\n\nСодержимое заказа: DarkBeefBurger за 500 рублей, 1 шт.\n\n";
    $letter .= $orderCount > 1 ? "Спасибо! Это уже $orderCount заказ." : "Спасибо - это ваш первый заказ.";

    mail($order['email'], $theme, $letter);
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
