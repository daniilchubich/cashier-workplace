<?php

include $_SERVER["DOCUMENT_ROOT"] . "/app/database/db.php";

$page = isset($_POST['page']) && isset($_POST['totalPages']) && $_POST['page'] <= $_POST['totalPages'] ? (int)$_POST['page'] : 1;
$limit = $_POST['limit']; // Количество чеков на странице
$offset = ($page - 1) * $limit;

// Запрос в базу данных
if (isset($_POST['type'])) {
    $_POST['type'] == 'deffered' ? $check_list = selectAllCheck($limit, $offset, ['check_status_id' => 1]) : $check_list = selectAllCheck($limit, $offset);
    // $_POST['type'] == 'catalog' ? $check_list = selectAllCheck($limit, $offset, ['check_status_id' => 1]) : '';
} else {
    $check_list = selectAllCheck($limit, $offset);
}
//$check_list = selectAllCheck($limit, $offset);
?>
<?php if (isset($check_list)): ?>
    <?php for ($i = 0; $i < count($check_list); $i++):  ?>
        <tr>
            <td><?= $check_list[$i]['cheсk_number'] ?></td>
            <td><?= substr($check_list[$i]['cheсk_data'], 11) ?></td>
            <td><?= isset($check_list[$i]['phone_number']) ? '+380' . $check_list[$i]['phone_number'] : '' ?>
            </td>
            <td><?= $check_list[$i]['name'] ?></td>
            <?php if (empty($_POST['check_status_id'])): ?>
                <td><?= $check_list[$i]['check_status_id'] == 1 ? 'Відкладений' : 'Пробитий' ?>
                </td>
            <?php endif ?>
            <td><?= $check_list[$i]['doc_sum'] ?> грн.</td>
            <?php if (isset($_POST['check_status_id']) && $_POST['check_status_id'] == 1): ?>
                <td>
                    <?php if (empty($_SESSION['cart'])): ?>
                        <a class="navbar-item nav-link active" href="#" data-bs-dismiss="modal" aria-label="Close"
                            onclick="sendData({check_deffered_id: '<?= isset($check_list[$i]['id']) ? addslashes($check_list[$i]['id']) : null ?>'})()">
                            <span>Відкрити</span>
                        </a>

                    <?php endif; ?>
                </td>
            <?php endif; ?>
        </tr>
    <?php endfor; ?>
<?php endif; ?>