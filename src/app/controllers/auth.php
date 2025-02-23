<?php include $_SERVER["DOCUMENT_ROOT"] . "/app/database/db.php"; ?>
<?php
if (isset($_POST['username'])) {
    $username = isset($_POST['username']) ? selectOne('ref_users', ['name' => $_POST['username']]) : '';
    //tt($username);
    $shop = isset($username) ? selectOne('ref_shops', ['id_bas' => $username['shop_id_bas']]) : '';
    //tt($shop);
    if (isset($shop)) {
        $_SESSION['work_shift']['user_id'] = $username['id'];
        $_SESSION['work_shift']['shop_id_bas'] = $shop['id_bas'];
        $_SESSION['work_shift']['shop_name'] = $shop['name'];
        $_SESSION['work_shift']['price_type_id_bas'] = $shop['price_type_id_bas'];
    }
    //tt($_SESSION['work_shift']);
}
