<?php
include $_SERVER["DOCUMENT_ROOT"] . "/app/database/db.php"; // Подключаем базу данных

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Количество чеков на одной странице
$offset = ($page - 1) * $limit;

// Запрос чеков из базы
$query = $pdo->prepare("SELECT * FROM checks LIMIT :limit OFFSET :offset");
$query->bindValue(':limit', $limit, PDO::PARAM_INT);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$checks = $query->fetchAll(PDO::FETCH_ASSOC);

// Отправляем HTML-код строк таблицы
foreach ($checks as $check) {
    echo "<tr>
            <td>{$check['cheсk_number']}</td>
            <td>" . substr($check['cheсk_data'], 11) . "</td>
            <td>" . (!empty($check['phone_number']) ? '+380' . $check['phone_number'] : '') . "</td>
            <td>{$check['name']}</td>
            <td>" . ($check['check_status_id'] == 1 ? 'Відкладений' : 'Пробитий') . "</td>
            <td>{$check['doc_sum']} грн.</td>
          </tr>";
}
